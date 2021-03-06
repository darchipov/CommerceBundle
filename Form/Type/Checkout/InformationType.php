<?php

namespace Ekyna\Bundle\CommerceBundle\Form\Type\Checkout;

use Ekyna\Bundle\CommerceBundle\Form\Type\Common\IdentityType;
use Ekyna\Component\Commerce\Cart\Model\CartInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class InformationType
 * @package Ekyna\Bundle\CommerceBundle\Form\Type\Checkout
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class InformationType extends AbstractType
{
    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('company', Type\TextType::class, [
                'label'    => 'ekyna_core.field.company',
                'required' => true,
            ])
            ->add('identity', IdentityType::class, [
                'required' => true,
            ])
            ->add('email', Type\EmailType::class, [
                'label'    => 'ekyna_core.field.email',
                'required' => true,
            ]);
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('data_class', CartInterface::class);
    }
}
