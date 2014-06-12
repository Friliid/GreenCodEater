<?php

namespace Ieps\BackOfficeBundle\Controller;
/**
 * use Ieps\CmsBaseBundle\Entity\...
 * use Ieps\CmsBaseBundle\Entity\...
 */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

public function editAction($slug) {
        
        $modelManager = $this->getDoctrine()->getManager();
        
        $rRubrique = $modelManager->getRepository('Ieps...Bundle:...')
                          ->findOneBySlug($slug);
        
        $form = $this->createForm(new RubriquesType(),$rRubrique);
        
        $request = $this->getRequest();
        if ($request->isMethod('POST')) {
            $form->bind($request);
            $rubrique = $form->getData();
            
            // On stocke et on exécute
                $modelManager->persist($rubrique);
                $modelManager->flush();
                
            // On redirige vers la page
                return $this->redirect($this->generateUrl('ieps_..._...', array(
                                                          'slug' =>$rubrique->getSlug())));
                
        }
        
        
        $rRubrique = $this->getDoctrine()
                          ->getManager()
                          ->getRepository('Ieps...Bundle:...')
                          ->findOneBySlug($slug);
        
        $form = $this->createForm(new RubriquesType(),$rRubrique);
        
        return $this->render('IepsSiteDeBaseBundle:Pages:edit.html.twig',
                                array('form' => $form->createView(),
                                    'rubrique' => $rRubrique));
        
    }
}
