<?php

/**
* !!!!!!! pas encore en place !!!!!!
*/

namespace Ieps\PaypalBundle\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Ieps\PaypalBundle\Entity\objet;
 
/**
 * PaypalOrder
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="XXXBundle\Entity\PaypalOrderRepository")
 */
class PaypalOrder
{
     
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
     
 
 
    /**
     * @ORM\ManyToOne(targetEntity="XXXBundle\Entity\Song")
     * @ORM\JoinColumn(name="song_id", referencedColumnName="id")
     */
    private $objet;
     
    /** @ORM\Column(name="amount", type="float", nullable=true) */
    private $amount;
     
    /** @ORM\Column(name="name", type="string", length=60 , nullable=true) */
    private $name;
     
    /** @ORM\Column(name="address", type="string", length=255 , nullable=true) */
    private $address;
     
    /** @ORM\Column(name="email", type="string", length=255 , nullable=true) */
    private $email;
     
    /** @ORM\Column(name="date", type="datetime", nullable=true) */
    private $date;
     
    /** @ORM\Column(name="statut", type="string", length=60 , nullable=true) */
    private $statut;
     
    /** @ORM\Column(name="dl_token", type="string", length=60 , nullable=true) */
    private $dl_token;
     
    /** @ORM\Column(name="dl_cpt", type="integer", nullable=true) */
    private $dl_cpt;
     
    /** @ORM\Column(name="paypal_params", type="text", nullable=true) */
    private $paypal_params;
     
    /** @ORM\Column(name="paypal_details", type="text", nullable=true) */
    private $paypal_details;
     
    /** @ORM\Column(name="paypal_complete", type="text", nullable=true) */
    private $paypal_complete;
 
    public function __construct($amout)
    {
        $this->amount = $amout;
        $this->dl_cpt = 0;
    }
 
    //....
    // Getter et Setter de l'objet
    //...
}