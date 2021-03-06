<?php

namespace Ekyna\Bundle\CommerceBundle\Form\Type\Supplier;

use Braincrafted\Bundle\BootstrapBundle\Form\Type\MoneyType;
use Ekyna\Bundle\CoreBundle\Form\Type\CollectionType;
use Ekyna\Bundle\CoreBundle\Form\Type\TinymceType;
use Ekyna\Component\Commerce\Exception\InvalidArgumentException;
use Ekyna\Component\Commerce\Supplier\Model\SupplierOrderInterface;
use Symfony\Component\Form;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Class SupplierOrderSubmitType
 * @package Ekyna\Bundle\CommerceBundle\Form\Type\Supplier
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SupplierOrderSubmitType extends Form\AbstractType
{
    /**
     * @var string
     */
    private $orderClass;


    /**
     * Constructor.
     *
     * @param string $orderClass
     */
    public function __construct($orderClass)
    {
        $this->orderClass = $orderClass;
    }

    /**
     * @inheritDoc
     */
    public function buildForm(Form\FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('emails', CollectionType::class, [
                'label'         => 'ekyna_core.field.recipients',
                'required'      => false,
                'entry_type'    => Type\EmailType::class,
                'entry_options' => [
                    'label' => false,
                    'attr'  => [
                        'widget_col' => 12,
                    ],
                ],
                'constraints'   => [
                    new Assert\Count(['min' => 1]),
                    new Assert\All([
                        'constraints' => [
                            new Assert\Email(),
                        ],
                    ]),
                ],
            ])
            ->add('message', TinymceType::class, [
                'label'    => 'ekyna_core.field.message',
                'required' => false,
            ])
            ->add('confirm', Type\CheckboxType::class, [
                'label'       => 'ekyna_core.message.action_confirm',
                'required'    => false,
                'constraints' => [
                    new Assert\IsTrue(),
                ],
                'attr'        => [
                    'align_with_widget' => true,
                ],
            ])
            ->add($builder
                ->create('order', Type\FormType::class, [
                    'data_class' => $this->orderClass,
                ])
            );

        $builder->addEventListener(Form\FormEvents::PRE_SET_DATA, function (Form\FormEvent $event) use ($options) {
            $data = $event->getData();
            $form = $event->getForm();

            if (!isset($data['order'])) {
                throw new InvalidArgumentException("Key 'order' must be defined in form data.");
            }
            $order = $data['order'];
            if (!$order instanceof SupplierOrderInterface) {
                throw new InvalidArgumentException(
                    "Expected form data 'order' key as instance of " . SupplierOrderInterface::class
                );
            }

            $currency = $order->getCurrency();

            $form
                ->get('order')
                ->add('estimatedDateOfArrival', Type\DateTimeType::class, [
                    'label'    => 'ekyna_commerce.supplier_order.field.estimated_date_of_arrival',
                    'format'   => 'dd/MM/yyyy', // TODO localised configurable format
                    'required' => false,
                ])
                ->add('paymentTotal', MoneyType::class, [
                    'label'    => 'ekyna_core.field.amount',
                    'currency' => $currency ? $currency->getCode() : 'EUR', // TODO default user currency
                ]);
        });
    }
}
