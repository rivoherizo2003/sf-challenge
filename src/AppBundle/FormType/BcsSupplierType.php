<?php
namespace AppBundle\FormType;
use AppBundle\Entity\BcsBrand;
use AppBundle\Entity\BcsItem;
use AppBundle\Entity\BcsSupplier;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Created by PhpStorm.
 * User: Zo
 * Date: 20/04/2018
 * Time: 09:23
 */
class BcsSupplierType extends AbstractType
{
	/**
	 * @var TranslatorInterface
	 */
	protected $g_trTranslator;

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		parent::buildForm($builder, $options); // TODO: Change the autogenerated stub

		$builder
			->add("splName")
            ->add("splPhone")
            ->add("splMail", EmailType::class)
			->add("splAddress", TextareaType::class)
            ->add('splBrandLists', CollectionType::class, array(
                    'entry_type' => BcsBrandType::class,
                    'prototype' => true,
                    'entry_options' => array('label' => false),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false
                )
            )
			;

	}

	public function configureOptions(OptionsResolver $resolver)
	{
		parent::configureOptions($resolver); // TODO: Change the autogenerated stub
		$resolver->setDefaults(
			array(
				'data_class' => BcsSupplier::class,
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