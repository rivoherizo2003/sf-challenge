<?php
/**
 * Created by PhpStorm.
 * User: ainadevopt
 * Date: 15/06/2018
 * Time: 12:36
 */
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


/**
 * @Annotation
 */
class IsQuantityExitMovementCorrect extends Constraint
{
	public $message = "Quantity stock not sufficient";
	public $message_ = "Duplicate product";

	public function validatedBy()
	{
		return get_class($this).'Validator'; // TODO: Change the autogenerated stub
	}

	public function getTargets()
	{
		return self::CLASS_CONSTRAINT;
	}
}