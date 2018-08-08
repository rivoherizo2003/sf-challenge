<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BcsBrand;
use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsMovement;
use AppBundle\Entity\BcsMovementDetail;
use AppBundle\Entity\BcsSupplier;
use AppBundle\FormType\BcsMovementType;
use AppBundle\FormType\BcsSupplierType;
use AppBundle\FormType\ProductType;
use AppBundle\Model\BcsItemModel;
use AppBundle\Model\BcsMovementDetailModel;
use AppBundle\Model\BcsMovementModel;
use AppBundle\Model\BcsSupplierModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;

class BcsMovementController extends Controller
{
    /**
     * @Route("/secured/manage-stock/{p_sRouteFrom}", name="bcs_manage_stock",
     * defaults={"p_sRouteFrom"=null})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @param $p_sRouteFrom
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $p_rqRequest, $p_sRouteFrom)
    {
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_arrBcsMovement = $l_omObjectManager->getRepository(BcsMovement::class)->findAll();
        $l_pngPaginate = $this->get('knp_paginator');
        $l_arrMovementPaginated = $l_pngPaginate->paginate($l_arrBcsMovement, $p_rqRequest->query->getInt('page', 1), 5);

        return $this->render('admin/stock/list.html.twig', ['p_arrMovement' => $l_arrMovementPaginated, 'p_sRouteFrom' => $p_sRouteFrom]);
    }

    /**
     * @Route("/secured/add-movement", name="bcs_add_movement")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $p_rqRequest){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_mvtMovement = new BcsMovement();
        $l_mvdMovementDetail = new BcsMovementDetail();
        $l_mvdMovementDetail->setMvdMovement($l_mvtMovement);
        $l_mvtMovement->getMvtMovementDetailLists()->add($l_mvdMovementDetail);
        $l_frmBcsMovementForm = $this->createForm(BcsMovementType::class, $l_mvtMovement);
        $l_frmBcsMovementForm->handleRequest($p_rqRequest);
        if ( $l_frmBcsMovementForm->isSubmitted() && $l_frmBcsMovementForm->isValid() ) {
            $l_mvmMovementModel = new BcsMovementModel($l_omObjectManager, $l_trTranslator);
            $l_mvtMovement = $l_frmBcsMovementForm->getData();
            $l_mvtMovement = $l_mvmMovementModel->taskAfterSubmittingAddMovement('ENT', $l_mvtMovement);
            try{
                $l_omObjectManager->persist($l_mvtMovement);
                $l_omObjectManager->flush();

                return $this->redirectToRoute('bcs_show_movement',
                    array('p_iIdMovement' => $l_mvtMovement->getId(), 'p_sRouteFrom' => 'add-movement')
                );
            } catch (\Exception $e){
                return 'Msg ' . $e->getMessage(). " ". $e->getLine()." ".$e->getFile();
            }
        }

        return $this->render('admin/stock/addMovement.html.twig', array(
            "p_frmForm" => $l_frmBcsMovementForm->createView()
        ));
    }


    /**
     * show detail supplier
     * @Route("/secured/detail-movement/{p_iIdMovement}/{p_sRouteFrom}", name="bcs_show_movement", requirements={"p_iIdMovement"="\d+"},
     *     defaults={"p_sRouteFrom"=null})
     * @param $p_iIdMovement
     * @param $p_sRouteFrom
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDetailAction($p_iIdMovement, $p_sRouteFrom){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_mvtMovement = $l_omObjectManager->getRepository(BcsMovement::class)->findOneBy(array('id' => $p_iIdMovement));

        return $this->render('admin/stock/detailMovement.html.twig', array(
                'p_mvtMovement' => $l_mvtMovement,
                'p_sRouteFrom' => $p_sRouteFrom
            )
        );
    }

    /**
     * edit supplier
     * @Route("/secured/edit-movement/{p_iIdMovement}/{p_sRouteFrom}", name="bcs_edit_movement", requirements={"p_iIdMovement"="\d+"},
     *     defaults={"p_sRouteFrom"=null})
     * @Security("has_role('ROLE_ADMIN')")
     * @param $p_iIdMovement
     * @param Request $p_rqRequest
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($p_iIdMovement, Request $p_rqRequest){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_mdmMovementDetailModel = new BcsMovementDetailModel($l_omObjectManager, $l_trTranslator);
        $l_mvtMovement = $l_omObjectManager->getRepository(BcsMovement::class)->findOneBy(array('id' => $p_iIdMovement));
        $l_mvtMovement = $l_mdmMovementDetailModel->initializeMovementDetail($l_mvtMovement);
        $l_frmBcsMovementForm = $this->createForm(BcsMovementType::class, $l_mvtMovement);
        $l_frmBcsMovementForm->handleRequest($p_rqRequest);
        if ( $l_frmBcsMovementForm->isSubmitted() && $l_frmBcsMovementForm->isValid() ) {
            $l_mvmMovementModel = new BcsMovementModel($l_omObjectManager, $l_trTranslator);
            $l_mvtMovement = $l_frmBcsMovementForm->getData();
            $l_mvtMovement = $l_mvmMovementModel->taskAfterSubmittingEditMovement($l_mvtMovement);
            try{
                $l_omObjectManager->flush();

                return $this->redirectToRoute('bcs_show_movement',
                    array('p_iIdMovement' => $l_mvtMovement->getId(), 'p_sRouteFrom' => 'edit-movement')
                );
            } catch (\Exception $e){
                return 'Msg ' . $e->getMessage(). " ". $e->getLine()." ".$e->getFile();
            }
        }

        return $this->render('admin/stock/editMovement.html.twig', array(
            "p_frmForm" => $l_frmBcsMovementForm->createView(),
            'p_mvtMovement' => $l_mvtMovement
        ));
    }


    /**
     * delete movement definitively
     * @Route("/secured/delete-movement/{p_iIdMovement}", name="bcs_delete_movement", requirements={"p_iIdMovement"="\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @param $p_iIdMovement
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $p_rqRequest, $p_iIdMovement){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_mvMovementModel = new BcsMovementModel($l_omObjectManager, $l_trTranslator);
        $l_sRouteFrom = $l_mvMovementModel->deleteMovement($p_iIdMovement);

        return $this->redirectToRoute('bcs_manage_stock', array('p_sRouteFrom' => $l_sRouteFrom));
    }
}
