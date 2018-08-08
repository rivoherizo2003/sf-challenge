<?php
namespace AppBundle\FormType;
use AppBundle\Entity\BcsBrand;
use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsItemCategory;
use AppBundle\Entity\BcsItemType;
use AppBundle\Entity\BcsUnitOfMeasure;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Created by PhpStorm.
 * User: Zo
 * Date: 20/04/2018
 * Time: 09:23
 */
class ProductType extends AbstractType
{
	/**
	 * @var TranslatorInterface
	 */
	protected $g_trTranslator;

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options); // TODO: Change the autogenerated stub

		$builder
			->add("itmTitle")
			->add("itmDescription")
			->add("itmItemCodeSupplier")
			->add("itmPriceWithDuty", MoneyType::class, array(
			        'currency' => 'MGA',
                    'required' => true
                )
            )
			->add('itmItemCategory', EntityType::class, array(
				                       'class' => BcsItemCategory::class,
				                       'choice_label' => 'itcDescription',
				                       'attr' => ['required'=> true,'class' => 'sel-select2'],
				                       'choice_value' => 'id',
				                       'placeholder' => 'Choose an option',
				                       'required' => true,
			                       )
			)
            ->add('itmItemType', EntityType::class, array(
                    'class' => BcsItemType::class,
                    'choice_label' => 'ittDescription',
                    'attr' => ['required'=> true,'class' => 'sel-select2'],
                    'choice_value' => 'id',
                    'placeholder' => 'Choose an option',
                    'required' => true
                )
            )
            ->add('itmUnitOfMeasure', EntityType::class, array(
                    'class' => BcsUnitOfMeasure::class,
                    'choice_label' => 'uomDescription',
                    'attr' => ['required'=> true,'class' => 'sel-select2'],
                    'choice_value' => 'id',
                    'required' => true
                )
            )
            ->add('itmItemBrand', EntityType::class, array(
                    'class' => BcsBrand::class,
                    'choice_label' => function(BcsBrand $p_brdBrand){
                        return $p_brdBrand->getBrdName(). '-' . $p_brdBrand->getBrdSupplier()->getSplName();
                    },
                    'attr' => ['required'=> true,'class' => 'sel-select2'],
                    'choice_value' => 'id',
                    'placeholder' => 'Choose an option',
                    'required' => true
                )
            );

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		parent::configureOptions($resolver); // TODO: Change the autogenerated stub
		$resolver->setDefaults(
			array(
				'data_class' => BcsItem::class,
				'csrf_protection' => true,
				'allow_extra_fields' => true,
				'csrf_field_name' => '_token',
				'translation_domain' => 'translations',
				// a unique key to help generate the secret token
				'csrf_token_id'   => 'task_item',
			)
		);
	}
}