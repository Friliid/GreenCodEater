<?php
// src/Sdz/UserBundle/Controller/SecurityController.php;

namespace Ieps\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;


class SecurityController extends Controller
{
  public function loginAction()
  {
    // Si le visiteur est déjà identifié, on le redirige vers l'accueil
    if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
      return $this->redirect($this->generateUrl('sdzblog_accueil'));
    }

    $request = $this->getRequest();
    $session = $request->getSession();

    // On vérifie s'il y a des erreurs d'une précédente soumission du formulaire
    if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) {
      $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);
    } else {
      $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
      $session->remove(SecurityContext::AUTHENTICATION_ERROR);
    }

    return $this->render('SdzUserBundle:Security:login.html.twig', array(
      // Valeur du précédent nom d'utilisateur entré par l'internaute
      'last_username' => $session->get(SecurityContext::LAST_USERNAME),
      'error'         => $error,
    ));
  }
  
  $user = $this->getUser();

if (null === $user) {
  // Ici, l'utilisateur est anonyme ou l'URL n'est pas derrière un pare-feu
} else {
  // Ici, $user est une instance de notre classe User
}



<?php
// src/Ieps/CmsBaseBundle/Controller/DefaultController.php

namespace Ieps\BlogBundle\Controller;

// Pensez à rajouter ce use pour l'exception qu'on utilise
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

// …

/**
    class BlogController extends Controller
{
    /**
    * @Secure(roles="ROLE_AUTEUR, ROLE_MODERATEUR, ROLE_ADMIN")
    */

/**  public function ajouterAction($form)
  {
    // On teste que l'utilisateur dispose bien du rôle ROLE_AUTEUR
    if (!$this->get('security.context')->isGranted('ROLE_AUTEUR')) {
      // Sinon on déclenche une exception « Accès interdit »
      throw new AccessDeniedHttpException('Accès limité aux auteurs');
    }

    // … Ici le code d'ajout d'un article qu'on a déjà fait
  }

  // …
}
 */

  
}