<?php
/**
 * Created by PhpStorm.
 * User: ainadevopt
 * Date: 15/06/2018
 * Time: 12:42
 */

namespace AppBundle\Validator\Constraints;


use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsQuantityOrderDetailCorrectValidator extends ConstraintValidator
{
    private $g_riRegistryInterface;
    private $g_tiTranslatorInterface;

    public function __construct(RegistryInterface $p_riRegistryInterface, TranslatorInterface $p_tiTranslatorInterface){
        $this->g_riRegistryInterface = $p_riRegistryInterface;
        $this->g_tiTranslatorInterface = $p_riRegistryInterface;
    }

	/**
	 * Checks if the passed value is valid.
	 *
	 * @param mixed      $entity      The value that should be validated
	 * @param Constraint $constraint The constraint for the validation
	 */
	public function validate($entity, Constraint $constraint)
	{
		if ( $entity->getOddItem()->getItmAvailableQuantity() < $entity->getOddQuantity() ) {
			$this->context->buildViolation($constraint->message)
				->atPath("oddQuantity")
				->addViolation();
		}
        //create an array of id item from the movement detail
        $l_acOrderDetail = $entity->getOddOrder()->getOrdOrderDetailLists();
        $l_arrIdItem = array();
        if ( count($l_acOrderDetail) > 0 ) {
            foreach ($l_acOrderDetail as $l_oddOrderDetail) {
                $l_arrIdItem[] = $l_oddOrderDetail->getOddItem()->getId();
            }
        }

        //check item redundancy
        $l_arrArrayCount = array_count_values($l_arrIdItem);
        if ( $l_arrArrayCount[$entity->getOddItem()->getId()] > 1 ) {
            $this->context->buildViolation($constraint->message_)
                ->atPath("oddItem")
                ->addViolation();
        }
	}
}