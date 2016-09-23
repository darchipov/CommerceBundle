<?php

namespace Ekyna\Bundle\CommerceBundle\Form\Type;

use Ekyna\Bundle\AdminBundle\Form\Type\ResourceFormType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class PaymentType
 * @package Ekyna\Bundle\CommerceBundle\Form\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class PaymentType extends ResourceFormType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /* TODO $builder
            ->add('designation', Type\TextType::class, [
                'label' => 'ekyna_core.field.designation',
                'sizing' => 'sm',
                'attr'   => [
                    'placeholder' => 'ekyna_core.field.designation',
                ],
            ])
            ->add('type', Type\ChoiceType::class, [
                'label' => 'ekyna_core.field.type',
                'choices' => AdjustmentTypes::getChoices(),
                'sizing' => 'sm',
                'attr'   => [
                    'class' => 'no-select2',
                    'placeholder' => 'ekyna_core.field.type',
                ],
            ])
            ->add('mode', Type\ChoiceType::class, [
                'label' => 'ekyna_core.field.mode',
                'choices' => AdjustmentModes::getChoices(),
                'sizing' => 'sm',
                'attr'   => [
                    'class' => 'no-select2',
                    'placeholder' => 'ekyna_core.field.mode',
                ],
            ])
            ->add('amount', Type\NumberType::class, [
                'label' => 'ekyna_core.field.value',
                'scale' => 2,
                'sizing' => 'sm',
                'attr'   => [
                    'placeholder' => 'ekyna_core.field.value',
                ],
            ])
            ->add('position', Type\HiddenType::class, [
                'attr' => [
                    'data-collection-role' => 'position',
                ],
            ]);*/
    }

    /**
     * {@inheritdoc}
     */
    /* TODO public function getBlockPrefix()
    {
        return 'ekyna_commerce_payment';
    }*/
}