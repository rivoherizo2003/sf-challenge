<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BcsItem;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $p_rqRequest)
    {
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_arrItem = $l_omObjectManager->getRepository(BcsItem::class)->findAll();
        $l_pngPaginator = $this->get('knp_paginator');
        $l_arrItemPaginated = $l_pngPaginator->paginate($l_arrItem, $p_rqRequest->query->getInt('page', 1), 5);

        return $this->render('default/index.html.twig', ['p_arrItem' => $l_arrItemPaginated]);
    }
}
