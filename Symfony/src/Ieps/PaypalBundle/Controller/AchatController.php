<?php
 
namespace Ieps\PaypalBundle\Controller;
 
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ieps\PaypalBundle\Entity\Paypal;
/**
 * use Ieps\PaypalBundle\Entity\...
 */
 
/**
 * @Route("/payments")
 */
class PaymentController extends Controller
{
    /**
     * @Route("/{id}/details", name="paypal_details")
     */
    public function detailsAction(article $Objet)
    {
        // Ici article représente la chanson à acheter
        // Initialisation d'un objet Order et flush afin d'avoir l'id de dispo pour l'url de retour (RETURNURL)
        $em = $this->getDoctrine()->getEntityManager();
        $order = new PaypalOrder($Objet->getPrice());
        $order->setSong($Objet);
        $em->persist($order);
        $em->flush();
         
        $data = array(
            'METHOD' => 'SetExpressCheckout',
            'CANCELURL' => $this->get('router')->generate('index', array(), true),
            'RETURNURL' => $this->get('router')->generate('paypal_complete', array('id' => $order->getId()), true),
            'PAYMENTREQUEST_0_AMT' => $Objet->getPrice(),
            'PAYMENTREQUEST_0_ITEMAMT' => $Objet->getPrice(),
            'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
            'L_PAYMENTREQUEST_0_NAME0' => $Objet->getTitle(),
            'L_PAYMENTREQUEST_0_QTY0' => '1',
            'L_PAYMENTREQUEST_0_AMT0' => $Objet->getPrice(),
            'SOLUTIONTYPE' => 'Sole',
            'LANDINGPAGE' => 'Billing',
            'CURRENCYCODE' => 'EUR',
            'DESC' => $Objet->getTitle(),
            'LOCALECODE' => 'FR',
        );
        //La fonction sendPaypal est une fonction privé de la classe expliquée plus bas
        $return_paypal = $this->sendPaypal($data);
        //La fonction getPaypalParam découpe et transforme la chaine de caractère retourné par Paypal en un tableau associatif
        $param = $this->getPaypalParam($return_paypal);
        //Pour ma part je stock le tout le retour en json dans l'entité mais libre à vous de faire votre propre logique ! la mienne est très bourrine par manque de temps
        $order->setPaypalParams(json_encode($param));
        $em->flush();
        //Si le premier retour de paypal est OK, on redirige vers paypal pour que le client puisse effectuer le paiement
        if ($param['ACK'] == 'Success')
            return $this->redirect("https://www.sandbox.paypal.com/webscr&cmd=_express-checkout&token=".$param['TOKEN']);

        
        
        
    /**
     * @Route("/{id}/complete", name="paypal_complete")
     */
    public function completeAction(PaypalOrder $order)
    {
        //si on a pas de token ou de payerId, rien a faire
        if (!$this->getRequest()->get('token') || !$this->getRequest()->get('PayerID'))
            throw $this->createNotFoundException();
        //si l'objet $order est déjà renseigné, rien a faire
        if ($order->getPaypalDetails() != null || $order->getPaypalComplete() != null)
            throw $this->createNotFoundException();
         
        $em = $this->getDoctrine()->getEntityManager();
         
        //Récupération des infos sur l'user et on stoke ça dans l'objet PaypalOrder
        $data = array(
            'METHOD'    => 'GetExpressCheckoutDetails',
            'TOKEN'     => urldecode($this->getRequest()->get('token')),
        );
 
        $orderDetails = $this->getPaypalParam($this->sendPaypal($data));
         
        $order->setEmail($orderDetails['EMAIL']);
        $order->setName($orderDetails['PAYMENTREQUEST_0_SHIPTONAME']);
        $order->setAddress($orderDetails['PAYMENTREQUEST_0_SHIPTOSTREET']." / ".
                $orderDetails['PAYMENTREQUEST_0_SHIPTOCITY']." / ".
                $orderDetails['PAYMENTREQUEST_0_SHIPTOCOUNTRYNAME']);
        $order->setDate(new \DateTime());
        $order->setPaypalDetails(json_encode($orderDetails));
        $em->flush();
         
        //Envoi de la requete de paiement et récupération du résultat final dans l'objet PaypalOrder
        $data = array(
            'PAYMENTREQUEST_0_PAYMENTACTION' => 'Sale',
            'PAYERID' => urldecode($this->getRequest()->get('PayerID')),
            'TOKEN' => urldecode($this->getRequest()->get('token')),
            'PAYMENTREQUEST_0_AMT' => $order->getAmount(),
            'PAYMENTREQUEST_0_CURRENCYCODE' => 'EUR',
            'METHOD' => 'DoExpressCheckoutPayment'
            );
         
        $orderComplete = $this->getPaypalParam($this->sendPaypal($data));
        //Utilisation de la fonction privé qui laisse 5 téléchargement à mon utilisateur
        if ($orderComplete['PAYMENTINFO_0_PAYMENTSTATUS'] == "Completed")
            $this->allowSong($order);
        //Mise à jour de l'objet Order
        $order->setStatut($orderComplete['PAYMENTINFO_0_PAYMENTSTATUS']);
        $order->setPaypalComplete(json_encode($orderComplete));
        $em->flush();
         
        return $this->redirect($this->get('router')->generate('index'));
    }
     
    private function sendPaypal($data)
    {
        //Récupération des paramètre stoqué dans parameter.yml
        /*
        parameters.yml
parameters:
     
    paypal_api_url:   https://api-3t.sandbox.paypal.com/nvp
    paypal_api_version:   93
    paypal_user:   XXX
    paypal_pass:   XXX
    paypal_signature:  XXX    
        */
 
        $api_paypal = $this->container->getParameter('paypal_api_url');
        $version = $this->container->getParameter('paypal_api_version');
        $user = $this->container->getParameter('paypal_user');
        $pass =  $this->container->getParameter('paypal_pass');
        $signature =  $this->container->getParameter('paypal_signature');
        //construction de l'url
        $url = $api_paypal.'?VERSION='.$version.
                '&USER='.$user.
                '&PWD='.$pass.
                '&SIGNATURE='.$signature;
        //ajout des paramètres passé en paramètres
        foreach($data as $k => $v)
            $url .= '&'.$k."=".urlencode($v);
        //init de curl
        $ch =curl_init($url);
         
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //envoi de la requete
        $res =  curl_exec($ch);
        curl_close($ch);
        if (!$res)
        {
            echo "<p>Erreur</p><p>".curl_error($ch)."</p>";
            die;
        }
        //on retourne le resultat
        return $res;      
    }
    
    
    private function getPaypalParam($url)
    {
        $params = array();
 
        $lst_params = explode('&', $url);
        foreach($lst_params as $param_paypal)
        {
            list($nom, $valeur) = explode("=", $param_paypal);
            $params[$nom]=urldecode($valeur);
        }
 
        return $params;
    }
}