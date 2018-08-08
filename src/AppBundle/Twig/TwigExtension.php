<?php

/**
 * Created by PhpStorm.
 * User: DEVOPT04
 * Date: 28/03/2018
 * Time: 07:05
 */
namespace AppBundle\Twig;
use AppBundle\Entity\BcsOrder;
use AppBundle\Entity\BcsUser;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Translation\TranslatorInterface;

class TwigExtension extends \Twig_Extension
{
	protected $g_trTranslator;
	protected $g_rgRegistry;
	protected $g_utUtility;

	/**
	 * TwigExtension constructor.
	 *
	 * @param TranslatorInterface $p_trTranslator
	 * @param RegistryInterface       $p_rgRegistry
	 */
	public function __construct(TranslatorInterface $p_trTranslator,RegistryInterface $p_rgRegistry){
		$this->g_trTranslator    = $p_trTranslator;
		$this->g_rgRegistry = $p_rgRegistry;
		$this->g_utUtility       = new \AppBundle\Services\Utility();

	}

	public function getFilters(){
		return array(
			new \Twig_SimpleFilter('getRoleDescription', array($this, 'getRoleDescription')),
			new \Twig_SimpleFilter('showDetailCurrentOrderCustomer', array($this, 'showDetailCurrentOrderCustomer')),
			new \Twig_SimpleFilter('getStatusOrder', array($this, 'getStatusOrder')),
			new \Twig_SimpleFilter('getMessageOrder', array($this, 'getMessageOrder')),
			new \Twig_SimpleFilter('getMessage', array($this, 'getMessage'))
		);
	}

	/**
	 * return message depending on the route
	 * @param $p_sRoute
	 *
	 * @return string
	 */
	public function getMessage($p_sRoute){
		switch ($p_sRoute){
			case 'add-item':
				$l_sRet = $this->g_trTranslator->trans('message.item_added', array(), 'translations');
				break;
			case 'edit-item':
				$l_sRet = $this->g_trTranslator->trans('message.item_updated', array(), 'translations');
				break;
            case 'item-deleted':
                $l_sRet = $this->g_trTranslator->trans('message.item_deleted', array(), 'translations');
                break;
            case 'add-supplier':
                $l_sRet = $this->g_trTranslator->trans('message.supplier_added', array(), 'translations');
                break;
            case 'edit-supplier':
                $l_sRet = $this->g_trTranslator->trans('message.supplier_edited', array(), 'translations');
                break;
            case 'delete-supplier':
                $l_sRet = $this->g_trTranslator->trans('message.supplier_deleted', array(), 'translations');
                break;
            case 'add-movement':
                $l_sRet = $this->g_trTranslator->trans('message.movement_added', array(), 'translations');
                break;
            case 'edit-movement':
                $l_sRet = $this->g_trTranslator->trans('message.movement_edited', array(), 'translations');
                break;
            case 'delete-movement':
                $l_sRet = $this->g_trTranslator->trans('message.movement_deleted', array(), 'translations');
                break;
			default: $l_sRet = "No message";
		}

		return $l_sRet;
	}

    /**
     * show message for task with order
     * @param $p_sRoute
     * @return string
     */
    public function getMessageOrder($p_sRoute){
        switch ($p_sRoute){
            case 'item-ordered':
                $l_sRet = $this->g_trTranslator->trans('message.item_ordered_successfully', array(), 'translations');
                break;
            case 'item-already-ordered':
                $l_sRet = $this->g_trTranslator->trans('message.item_already_in_order', array(), 'translations');
                break;
            case 'add-order':
                $l_sRet = $this->g_trTranslator->trans('message.order_added', array(), 'translations');
                break;
            case 'edit-order':
                $l_sRet = $this->g_trTranslator->trans('message.order_edited', array(), 'translations');
                break;
            case 'validate-order':
                $l_sRet = $this->g_trTranslator->trans('message.order_validated', array(), 'translations');
                break;
            case 'delete-order':
                $l_sRet = $this->g_trTranslator->trans('message.order_deleted', array(), 'translations');
                break;
            case 'error-occurred':
                $l_sRet = $this->g_trTranslator->trans('message.error_occurred', array(), 'translations');
                break;
            default: $l_sRet = "No message";
        }

        return $l_sRet;
    }

    /**
     * @param $p_iGender
     * @return string
     */
    public function gender($p_iGender){
        $l_sGender = $this->g_trTranslator->trans('form.female', array(), 'translations');
        if ( $p_iGender == 1 ) $l_sGender = $this->g_trTranslator->trans('form.male', array(), 'translations');

        return $l_sGender;
    }

    /**
     * get the role description of an array of role
     * @param $p_arrRole
     * @return mixed|string
     */
    public function getRoleDescription($p_arrRole){
        $l_sRoleDescription = "No group";
        if ( is_array($p_arrRole) ) {
            if ( count($p_arrRole) > 0 ) {
                for ( $i = 0; $i <= count($p_arrRole)-1; $i++ ) {
                    if ( $p_arrRole[$i] == "ROLE_ADMIN" ) {
                        $l_sRole = $this->g_trTranslator->trans('general.administrator', array(), 'translations');
                    }
                    else if ( $p_arrRole[$i] == "ROLE_USER" ) {
                        $l_sRole = $this->g_trTranslator->trans('general.user', array(), 'translations');
                    }
                    else {
                        $l_sRole = $this->g_trTranslator->trans('general.writer', array(), 'translations');
                    }
                    if ( $i == 0) {
                        $l_sRoleDescription = $l_sRole;
                    }
                    else {
                        $l_sRoleDescription .= ", ". $l_sRole;
                    }
                }
            }
        }

        return $l_sRoleDescription;
    }

    /**
     * show that there is current order to send
     * @param BcsUser $p_cusCustomer
     * @return string
     */
    public function showDetailCurrentOrderCustomer(BcsUser $p_cusCustomer){
        $l_ordOrder = $this->g_rgRegistry->getRepository(BcsOrder::class)
            ->findOneBy(array('ordStatus' => 0, 'ordUser' => $p_cusCustomer->getId()));
        if ( !is_null($l_ordOrder) ) {
            $l_sContent = "<div class='container-fluid'>".
                            "<div class='row'>".
                                "<div class='col-sm'><label for=\"txt-quantity-ordered\" 
                                        class=\"col-form-label w-100 text-info\">".$this->g_trTranslator->trans('form.current_order',array(), 'translations').":</label>"
                                    .$l_ordOrder->getOrdCode().
                                "</div>".
                                "<div class='col-sm'><label for=\"txt-quantity-ordered\" 
                                                        class=\"col-form-label w-100 text-info\">".$this->g_trTranslator->trans('form.amount_order',array(), 'translations').":</label> MGA "
                                .$this->convertToMoneyFormat($l_ordOrder->getOrdAmount()).
                                "</div>".
                            "</div>".
                        "</div>";

            return $l_sContent;
        }
        else {
            return "";
        }
    }

    public function convertToMoneyFormat($p_fNumber){
        return number_format($p_fNumber, 2, ',', ' ');
    }

    /**
     * return the status of an order
     * @param BcsOrder $p_ordOrder
     * @return string
     */
    public function getStatusOrder(BcsOrder $p_ordOrder){
        $l_sStatus = "No status";
        switch ($p_ordOrder->getOrdStatus()){
            case 0;
                $l_sStatus = $this->g_trTranslator->trans('form.draft',array(), 'translations');
                break;
            case 1:
                $l_sStatus = $this->g_trTranslator->trans('form.in_progress',array(), 'translations');
                break;
            case 2:
                $l_sStatus = $this->g_trTranslator->trans('form.achieved',array(), 'translations');
                break;
        }

        return $l_sStatus;
    }
}