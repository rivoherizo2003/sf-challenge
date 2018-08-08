<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BcsItem;
use AppBundle\FormType\ProductType;
use AppBundle\Model\BcsItemModel;
use AppBundle\Model\BcsMovementDetailModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;

class BcsItemController extends Controller
{
    /**
     * @Route("/secured/manage-product/{p_sRouteFrom}", name="adm_product",
     * defaults={"p_sRouteFrom"=null})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @param $p_sRouteFrom
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $p_rqRequest, $p_sRouteFrom)
    {
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_arrItem = $l_omObjectManager->getRepository(BcsItem::class)->findAll();
        $l_pngPaginator = $this->get('knp_paginator');
        $l_arrItemPaginated = $l_pngPaginator->paginate($l_arrItem, $p_rqRequest->query->getInt('page', 1), 5);

        return $this->render('admin/product/list.html.twig', ['p_arrItem' => $l_arrItemPaginated, 'p_sRouteFrom' => $p_sRouteFrom]);
    }

    /**
     * @Route("/secured/add-product", name="adm_add_product")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $p_rqRequest){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_itBcsItem = new BcsItem();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_frmBcsItemForm = $this->createForm(ProductType::class, $l_itBcsItem);
        $l_frmBcsItemForm->handleRequest($p_rqRequest);
        if ( $l_frmBcsItemForm->isSubmitted() && $l_frmBcsItemForm->isValid() ) {
            $l_imItemModel = new BcsItemModel($l_omObjectManager, $l_trTranslator);
            $l_itBcsItem = $l_frmBcsItemForm->getData();
            $l_itBcsItem = $l_imItemModel->taskAfterSubmittingAddItem('PRD', $l_itBcsItem);
            try{
                $l_omObjectManager->persist($l_itBcsItem);
                $l_omObjectManager->flush();

                return $this->redirectToRoute('bcs_show_product',
                    array('p_iIdItem' => $l_itBcsItem->getId(), 'p_sRouteFrom' => 'add-item')
                );
            } catch (\Exception $e){
                return 'Msg ' . $e->getMessage(). " ". $e->getLine()." ".$e->getFile();
            }
        }

        return $this->render('admin/product/addProduct.html.twig', array(
            "p_frmForm" => $l_frmBcsItemForm->createView()
        ));
    }


    /**
     * show detail product
     * @Route("/secured/detail-product/{p_iIdItem}/{p_sRouteFrom}", name="bcs_show_product", requirements={"p_iIdItem"="\d+"},
     *     defaults={"p_sRouteFrom"=null})
     * @param $p_iIdItem
     * @param $p_sRouteFrom
     * @param $p_rqRequest
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDetailAction($p_iIdItem, $p_sRouteFrom, Request $p_rqRequest){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_itmBcsItem = $l_omObjectManager->getRepository(BcsItem::class)->findOneBy(array('id' => $p_iIdItem));
        $l_mdmMovementDetailModel = new BcsMovementDetailModel($l_omObjectManager, $l_trTranslator);
        $l_arrMovementDetail = $l_mdmMovementDetailModel->getMovementDetailByItem($l_itmBcsItem);
        $l_pngPaginate = $this->get('knp_paginator');
        $l_arrMovementDetailPaginated = $l_pngPaginate->paginate($l_arrMovementDetail, $p_rqRequest->query->getInt('page', 1), 5);

        return $this->render('admin/product/detailProduct.html.twig', array(
                'p_itItem' => $l_itmBcsItem,
                'p_sRouteFrom' => $p_sRouteFrom,
                'p_arrMovementDetailPaginated' => $l_arrMovementDetailPaginated
            )
        );
    }

    /**
     * @Route("/secured/edit-product/{p_iIdItem}", name="adm_edit_product", requirements={"p_iIdItem"="\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $p_rqRequest, $p_iIdItem){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_itBcsItem = $l_omObjectManager->getRepository(BcsItem::class)->findOneBy(array('id' => $p_iIdItem));
        $l_frmBcsItemForm = $this->createForm(ProductType::class, $l_itBcsItem);
        $l_frmBcsItemForm->handleRequest($p_rqRequest);
        if ( $l_frmBcsItemForm->isSubmitted() && $l_frmBcsItemForm->isValid() ) {
            $l_itBcsItem = $l_frmBcsItemForm->getData();
            try{
                $l_omObjectManager->flush();

                return $this->redirectToRoute('bcs_show_product',
                    array('p_iIdItem' => $l_itBcsItem->getId(), 'p_sRouteFrom' => 'edit-item')
                );
            } catch (\Exception $e){
                return 'Msg ' . $e->getMessage(). " ". $e->getLine()." ".$e->getFile();
            }
        }

        return $this->render('admin/product/editProduct.html.twig', array(
            "p_frmForm" => $l_frmBcsItemForm->createView(),
            'p_itBcsItem' => $l_itBcsItem
        ));
    }

    /**
     * delete product definitively
     * @Route("/secured/delete-product/{p_iIdItem}", name="adm_delete_product", requirements={"p_iIdItem"="\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @param $p_iIdItem
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $p_rqRequest, $p_iIdItem){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_imItemModel = new BcsItemModel($l_omObjectManager, $l_trTranslator);
        $l_imItemModel->deleteItem($p_iIdItem);

        return $this->redirectToRoute('adm_product', array('p_sRouteFrom' => 'item-deleted'));
    }
}
