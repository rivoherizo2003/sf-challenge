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

class IsQuantityExitMovementCorrectValidator extends ConstraintValidator
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
		if ( $entity->getMvdItem()->getItmAvailableQuantity() < $entity->getMvdQuantity()
            && $entity->getMvdMovement()->getMvtMovementType()->getTpmCode() == 'TMV0608-000002' ) {
			$this->context->buildViolation($constraint->message)
				->atPath("mvdQuantity")
				->addViolation();
		}
		//create an array of id item from the movement detail
        $l_acMovementDetail = $entity->getMvdMovement()->getMvtMovementDetailLists();
		$l_arrIdItem = array();
		if ( count($l_acMovementDetail) > 0 ) {
            foreach ($l_acMovementDetail as $l_mvdMovementDetail) {
                $l_arrIdItem[] = $l_mvdMovementDetail->getMvdItem()->getId();
            }
        }

        //check item redundancy
        $l_arrArrayCount = array_count_values($l_arrIdItem);
		if ( $l_arrArrayCount[$entity->getMvdItem()->getId()] > 1 ) {
            $this->context->buildViolation($constraint->message_)
                ->atPath("mvdItem")
                ->addViolation();
        }
	}
}