<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsUser;
use AppBundle\FormType\CustomerType;
use AppBundle\Model\CustomerModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Guard\GuardAuthenticatorInterface;
use Symfony\Component\Translation\Translator;

class CustomerController extends Controller
{

    /**
     * @Route("/secured/customer", name="cus_home")
     * @Security("has_role('ROLE_CUSTOMER')")
     * @param Request $p_rqRequest
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $p_rqRequest)
    {
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_arrItem = $l_omObjectManager->getRepository(BcsItem::class)->findAll();
        $l_pngPaginator = $this->get('knp_paginator');
        $l_arrItemPaginated = $l_pngPaginator->paginate($l_arrItem, $p_rqRequest->query->getInt('page', 1), 5);

        return $this->render('product/listProductCustomer.html.twig', ['p_arrItem' => $l_arrItemPaginated]);
    }

    /**
     * authenticate customer
     * @param BcsUser $p_cusCustomer
     */
    public function authenticateCustomer(BcsUser $p_cusCustomer){
        $providerKey = 'secured_area';
        $token = new UsernamePasswordToken($p_cusCustomer, null, $providerKey, $p_cusCustomer->getRoles());
        $this->get('security.token_storage')->setToken($token);
        $this->get('session')->set('_security_secured_area', serialize($token));
        $this->addFlash('success', 'You are now successfully registered!');

        $this->container->get('security.token_storage')->setToken($token);
    }

    /**
     * form subscription customer
     * @Route("/subscription-customer", name="cus_subscription")
     * @param Request $p_rqRequest
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function subscriptionAction(Request $p_rqRequest){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_usrBcsUser = new BcsUser();
        $l_ecEncoder = $this->container->get('security.password_encoder');
        $l_frmCustomerForm = $this->createForm(CustomerType::class, $l_usrBcsUser, array("p_tiTranslatorInterface" => $l_trTranslator));
        $l_frmCustomerForm->handleRequest($p_rqRequest);
        if ( $l_frmCustomerForm->isSubmitted() && $l_frmCustomerForm->isValid() ) {
            $l_cmCustomerModel = new CustomerModel($l_omObjectManager, $l_trTranslator);
            $l_cusCustomer = $l_frmCustomerForm->getData();
            $l_cusCustomer = $l_cmCustomerModel->taskAfterSubmittingAddCustomer('CSM', $l_cusCustomer, $l_ecEncoder);
            try{
                $l_omObjectManager->persist($l_cusCustomer);
                $l_omObjectManager->flush();
                $this->authenticateCustomer($l_cusCustomer);

                return $this->redirectToRoute('cus_home');
            } catch (\Exception $e){
                return 'Msg ' . $e->getMessage(). " ". $e->getLine()." ".$e->getFile();
            }
        }

        return $this->render('customer/subscribeCustomer.html.twig', array(
            "p_frmForm" => $l_frmCustomerForm->createView()
        ));
    }

    /**
     * show detail product
     * @Route("/secured/customer/detail-product/{p_iIdItem}/{p_sRouteFrom}", name="cus_show_product", requirements={"p_iIdItem"="\d+"},
     *     defaults={"p_sRouteFrom"=null})
     * @Security("has_role('ROLE_CUSTOMER')")
     * @param $p_iIdItem
     * @param $p_sRouteFrom
     * @param $p_rqRequest
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDetailAction($p_iIdItem, $p_sRouteFrom, Request $p_rqRequest){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_itmBcsItem = $l_omObjectManager->getRepository(BcsItem::class)->findOneBy(array('id' => $p_iIdItem));

        return $this->render('customer/detailProductCustomer.html.twig', array(
                'p_itItem' => $l_itmBcsItem,
                'p_sRouteFrom' => $p_sRouteFrom
            )
        );
    }
}
