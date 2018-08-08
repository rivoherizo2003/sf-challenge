<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsOrder;
use AppBundle\Entity\BcsOrderDetail;
use AppBundle\FormType\BcsOrderType;
use AppBundle\FormType\ProductType;
use AppBundle\Model\BcsItemModel;
use AppBundle\Model\BcsMovementDetailModel;
use AppBundle\Model\BcsOrderDetailModel;
use AppBundle\Model\BcsOrderModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;

class BcsOrderController extends Controller
{
    /**
     * @Route("/secured/order-product/{p_iIdItem}", name="ord_product", requirements={"p_iIdItem"="\d+"})
     * @Security("has_role('ROLE_CUSTOMER')")
     * @param Request $p_rqRequest
     * @param $p_iIdItem
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function orderProductAction(Request $p_rqRequest, $p_iIdItem){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_omOrderModel = new BcsOrderModel($l_omObjectManager, $l_trTranslator);
        $l_odmOrderDetailModel = new BcsOrderDetailModel($l_omObjectManager, $l_trTranslator);
        $l_ordOrder = $l_omOrderModel->createOrder($this->getUser());
        $l_sRet = $l_odmOrderDetailModel->createOrderDetail($l_ordOrder, $p_iIdItem, $p_rqRequest->request->get('txt-quantity-ordered'));

        return $this->redirectToRoute('cus_show_product', array('p_iIdItem' => $p_iIdItem, 'p_sRouteFrom' => $l_sRet));
    }

    /**
     * list customer's orders
     * @Route("/secured/order-customer/{p_sRouteFrom}/{p_iIdOrder}", name="cus_order_customer",
     * defaults={"p_sRouteFrom"=null,"p_iIdOrder"=null})
     * @Security("has_role('ROLE_CUSTOMER')")
     * @param Request $p_rqRequest
     * @param $p_sRouteFrom
     * @param $p_iIdOrder
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showListOrderCustomerAction(Request $p_rqRequest, $p_sRouteFrom, $p_iIdOrder){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_omOrderModel = new BcsOrderModel($l_omObjectManager, $l_trTranslator);
        if ( !is_null($p_iIdOrder) ) {
            $l_arrOrder = $l_omObjectManager->getRepository(BcsOrder::class)->findBy(array('id' => $p_iIdOrder));
        } else {
            $l_arrOrder = $l_omOrderModel->getOrderByUser($this->getUser());
        }
        $l_pngPaginator = $this->get('knp_paginator');
        $l_arrOrderPaginated = $l_pngPaginator->paginate($l_arrOrder, $p_rqRequest->query->getInt('page', 1), 5);


        return $this->render('order/listOrderCustomer.html.twig',array(
            'p_arrOrderPaginated' => $l_arrOrderPaginated,
            'p_sRouteFrom' => $p_sRouteFrom
        ));
    }


    /**
     * delete supplier definitively
     * @Route("/secured/delete-order/{p_iIdOrder}", name="bcs_delete_order", requirements={"p_iIdOrder"="\d+"})
     * @Security("has_role('ROLE_CUSTOMER')")
     * @param Request $p_rqRequest
     * @param $p_iIdOrder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteCustomerOrderAction(Request $p_rqRequest, $p_iIdOrder){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_odmOrderModel = new BcsOrderModel($l_omObjectManager, $l_trTranslator);
        $l_sRouteFrom = $l_odmOrderModel->deleteOrder($p_iIdOrder);
//        var_dump($l_sRouteFrom);die;

        return $this->redirectToRoute('cus_order_customer', array('p_sRouteFrom' => $l_sRouteFrom));
    }

    /**
     * @Route("/secured/edit-order-customer/{p_iIdOrder}", name="bcs_edit_order_customer")
     * @Security("has_role('ROLE_CUSTOMER')")
     * @param Request $p_rqRequest
     * @param $p_iIdOrder
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction(Request $p_rqRequest, $p_iIdOrder){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_ordOrder = $l_omObjectManager->getRepository(BcsOrder::class)->findOneBy(array('id' => $p_iIdOrder));
        $l_odmOrderDetailModel = new BcsOrderDetailModel($l_omObjectManager, $l_trTranslator);
        $l_ordOrder = $l_odmOrderDetailModel->initializeOrderDetail($l_ordOrder);
        $l_frmBcsOrderForm = $this->createForm(BcsOrderType::class, $l_ordOrder);
        $l_frmBcsOrderForm->handleRequest($p_rqRequest);
        if ( $l_frmBcsOrderForm->isSubmitted() && $l_frmBcsOrderForm->isValid() ) {
            $l_odmOrderModel = new BcsOrderModel($l_omObjectManager, $l_trTranslator);
            $l_ordOrder = $l_frmBcsOrderForm->getData();
            $l_arrRet = $l_odmOrderModel->taskAfterSubmitEditOrder($l_ordOrder);
            $l_ordOrder = $l_arrRet['order'];
            try{
                $l_omObjectManager->flush();

                return $this->redirectToRoute('cus_order_customer',
                    array('p_sRouteFrom' => $l_arrRet['route'], 'p_iIdOrder' => $l_ordOrder->getId())
                );
            } catch (\Exception $e){
                return 'Msg ' . $e->getMessage(). " ". $e->getLine()." ".$e->getFile();
            }
        }

        return $this->render('order/editOrder.html.twig', array(
            "p_frmForm" => $l_frmBcsOrderForm->createView()
        ));
    }
}
