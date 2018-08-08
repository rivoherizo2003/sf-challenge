<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsOrderDetail;
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

class BcsOrderDetailController extends Controller
{

    /**
     * list customer's orders
     * @Route("/secured/show-order-detail", name="cus_order_detail")
     * @param Request $p_rqRequest
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showOrderDetailAction(Request $p_rqRequest){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_odmOrderDetailModel = new BcsOrderDetailModel($l_omObjectManager, $l_trTranslator);
        $l_arrOrderDetail = $l_odmOrderDetailModel->getOrderDetailByOrderId($p_rqRequest->request->get('p_iIdOrder'));

        return $this->render('orderDetail/orderDetail.html.twig',array(
            'p_arrOrderDetail' => $l_arrOrderDetail
        ));
    }
}
