<?php

namespace AppBundle\Controller;

use AppBundle\Entity\BcsBrand;
use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsSupplier;
use AppBundle\FormType\BcsSupplierType;
use AppBundle\FormType\ProductType;
use AppBundle\Model\BcsItemModel;
use AppBundle\Model\BcsSupplierModel;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Translation\Translator;

class BcsSupplierController extends Controller
{
    /**
     * @Route("/secured/manage-supplier/{p_sRouteFrom}", name="bcs_list_supplier",
     * defaults={"p_sRouteFrom"=null})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @param $p_sRouteFrom
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $p_rqRequest, $p_sRouteFrom)
    {
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_arrSupplier = $l_omObjectManager->getRepository(BcsSupplier::class)->findAll();
        $l_pngPaginate = $this->get('knp_paginator');
        $l_arrSupplierPaginated = $l_pngPaginate->paginate($l_arrSupplier, $p_rqRequest->query->getInt('page', 1), 5);

        return $this->render('admin/supplier/list.html.twig', ['p_arrSupplier' => $l_arrSupplierPaginated, 'p_sRouteFrom' => $p_sRouteFrom]);
    }

    /**
     * @Route("/secured/add-supplier", name="bcs_add_supplier")
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function addAction(Request $p_rqRequest){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_supSupplier = new BcsSupplier();
        $l_brdBrand = new BcsBrand();
        $l_brdBrand->setBrdSupplier($l_supSupplier);
        $l_supSupplier->getSplBrandLists()->add($l_brdBrand);
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_frmBcsSupplierForm = $this->createForm(BcsSupplierType::class, $l_supSupplier);
        $l_frmBcsSupplierForm->handleRequest($p_rqRequest);
        if ( $l_frmBcsSupplierForm->isSubmitted() && $l_frmBcsSupplierForm->isValid() ) {
            $l_smSupplierModel = new BcsSupplierModel($l_omObjectManager, $l_trTranslator);
            $l_supBcsSupplier = $l_frmBcsSupplierForm->getData();
            $l_supBcsSupplier = $l_smSupplierModel->taskAfterSubmittingAddSupplier('SUP', $l_supBcsSupplier);
            try{
                $l_omObjectManager->persist($l_supBcsSupplier);
                $l_omObjectManager->flush();

                return $this->redirectToRoute('bcs_show_supplier',
                    array('p_iIdSupplier' => $l_supBcsSupplier->getId(), 'p_sRouteFrom' => 'add-supplier')
                );
            } catch (\Exception $e){
                return 'Msg ' . $e->getMessage(). " ". $e->getLine()." ".$e->getFile();
            }
        }

        return $this->render('admin/supplier/addSupplier.html.twig', array(
            "p_frmForm" => $l_frmBcsSupplierForm->createView()
        ));
    }


    /**
     * show detail supplier
     * @Route("/secured/detail-supplier/{p_iIdSupplier}/{p_sRouteFrom}", name="bcs_show_supplier", requirements={"p_iIdItem"="\d+"},
     *     defaults={"p_sRouteFrom"=null})
     * @param $p_iIdSupplier
     * @param $p_sRouteFrom
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function showDetailAction($p_iIdSupplier, $p_sRouteFrom){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_supSupplier = $l_omObjectManager->getRepository(BcsSupplier::class)->findOneBy(array('id' => $p_iIdSupplier));

        return $this->render('admin/supplier/detailSupplier.html.twig', array(
                'p_supSupplier' => $l_supSupplier,
                'p_sRouteFrom' => $p_sRouteFrom
            )
        );
    }

    /**
     * edit supplier
     * @Route("/secured/edit-supplier/{p_iIdSupplier}/{p_sRouteFrom}", name="bcs_edit_supplier", requirements={"p_iIdItem"="\d+"},
     *     defaults={"p_sRouteFrom"=null})
     * @Security("has_role('ROLE_ADMIN')")
     * @param $p_iIdSupplier
     * @param Request $p_rqRequest
     * @return string|\Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function editAction($p_iIdSupplier, Request $p_rqRequest){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_supSupplier = $l_omObjectManager->getRepository(BcsSupplier::class)->findOneBy(array('id' => $p_iIdSupplier));
        $l_frmBcsSupplierForm = $this->createForm(BcsSupplierType::class, $l_supSupplier);
        $l_frmBcsSupplierForm->handleRequest($p_rqRequest);
        if ( $l_frmBcsSupplierForm->isSubmitted() && $l_frmBcsSupplierForm->isValid() ) {
            $l_supBcsSupplier = $l_frmBcsSupplierForm->getData();
            try{
                $l_omObjectManager->flush();

                return $this->redirectToRoute('bcs_show_supplier',
                    array('p_iIdSupplier' => $l_supBcsSupplier->getId(), 'p_sRouteFrom' => 'add-supplier')
                );
            } catch (\Exception $e){
                return 'Msg ' . $e->getMessage(). " ". $e->getLine()." ".$e->getFile();
            }
        }

        return $this->render('admin/supplier/editSupplier.html.twig', array(
            "p_frmForm" => $l_frmBcsSupplierForm->createView(),
            'p_supSupplier' => $l_supSupplier
        ));
    }


    /**
     * delete supplier definitively
     * @Route("/secured/delete-supplier/{p_iIdSupplier}", name="bcs_delete_supplier", requirements={"p_iIdSupplier"="\d+"})
     * @Security("has_role('ROLE_ADMIN')")
     * @param Request $p_rqRequest
     * @param $p_iIdSupplier
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $p_rqRequest, $p_iIdSupplier){
        $l_omObjectManager = $this->getDoctrine()->getManager();
        $l_trTranslator = new Translator($p_rqRequest->getLocale());
        $l_smSupplierModel = new BcsSupplierModel($l_omObjectManager, $l_trTranslator);
        $l_sRouteFrom = $l_smSupplierModel->deleteSupplier($p_iIdSupplier);

        return $this->redirectToRoute('bcs_list_supplier', array('p_sRouteFrom' => $l_sRouteFrom));
    }
}
