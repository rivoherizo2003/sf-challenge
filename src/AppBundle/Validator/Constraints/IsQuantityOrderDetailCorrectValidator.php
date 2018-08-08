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
		if ( $entity->getOddItem()->getItmStockQuantity() < $entity->getOddQuantity() ) {
			$this->context->buildViolation($constraint->message)
				->atPath("oddQuantity")
				->addViolation();
		}
		//check duplicate item
//        $l_iCountDuplicateItem = 0;

	}
}