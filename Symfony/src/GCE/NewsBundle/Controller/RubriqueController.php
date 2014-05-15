<?php

namespace GCE\NewsBundle\Controller;

/* ------------------------------------------ */
/* CHARGEMENT DES CLASSES NECESSAIRES         */
/* ------------------------------------------ */

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use GCE\NewsBundle\Entity\Rubriques;

/* ------------------------------------------ */
/* LE CONTROLLER                              */
/* ------------------------------------------ */

class RubriqueController extends Controller
{
    
    /**
     * Action detail: détail de la rubrique
     * @param string $id
     * @return view: rubriques/detail
     */
    public function detailAction($id)
    
    {
        $rsRub = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('GCENewsBundle:Rubriques')
                            ->findOneById($id);
        
        return $this->render('GCENewsBundle:Rubriques:detail.html.twig', array('rubrique' => $rsRub));
    }
    
    /**
     * Action detail: liste des rubriques pour le menu
     * @return view: rubriques/menu
     */
   
    /** public function menuAction()
    {
        $rs... = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('GCENewsBundle:Rubriques')
                            ->findAll();
        
        return $this->render('GCENewsBundle:Rubriques:menu.html.twig', array('...' => $rs...));
    } */
    
}