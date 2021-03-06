<?php

namespace Ekyna\Bundle\CommerceBundle\Form\Type\Supplier;

use Braincrafted\Bundle\BootstrapBundle\Form\Type\MoneyType;
use Ekyna\Bundle\AdminBundle\Form\Type\ResourceFormType;
use Ekyna\Bundle\AdminBundle\Form\Type\ResourceType;
use Ekyna\Bundle\CommerceBundle\Form\Type as Commerce;
use Ekyna\Bundle\CommerceBundle\Model\SupplierOrderStates;
use Ekyna\Bundle\CoreBundle\Form\Util\FormUtil;
use Symfony\Component\Form\Extension\Core\Type as Symfony;
use Symfony\Component\Form;

/**
 * Class SupplierOrderType
 * @package Ekyna\Bundle\CommerceBundle\Form\Type\Supplier
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class SupplierOrderType extends ResourceFormType
{
    /**
     * @var string
     */
    protected $supplierClass;


    /**
     * Constructor.
     *
     * @param string $dataClass
     * @param string $supplierClass
     */
    public function __construct($dataClass, $supplierClass)
    {
        parent::__construct($dataClass);

        $this->supplierClass = $supplierClass;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(Form\FormBuilderInterface $builder, array $options)
    {
        $builder->addEventListener(Form\FormEvents::PRE_SET_DATA, function (Form\FormEvent $event) use ($options) {
            $form = $event->getForm();

            /** @var \Ekyna\Component\Commerce\Supplier\Model\SupplierOrderInterface $supplierOrder */
            $supplierOrder = $event->getData();

            // Step 1: Supplier is not selected
            if (null === $supplier = $supplierOrder->getSupplier()) {
                $form
                    ->add('supplier', ResourceType::class, [
                        'label' => 'ekyna_commerce.supplier.label.singular',
                        'class' => $this->supplierClass,
                    ]);

                return;
            }

            /** @var \Ekyna\Component\Commerce\Common\Model\CurrencyInterface $currency */
            $currency = null !== $supplierOrder ? $supplierOrder->getCurrency() : null;

            // Step 2: Supplier is selected
            $form
                ->add('supplier', ResourceType::class, [
                    'label'    => 'ekyna_commerce.supplier.label.singular',
                    'class'    => $this->supplierClass,
                    'disabled' => true,
                ])
                ->add('number', Symfony\TextType::class, [
                    'label'    => 'ekyna_core.field.number',
                    'required' => false,
                    'disabled' => true,
                ])
                ->add('currency', Commerce\Common\CurrencyChoiceType::class)
                ->add('state', Symfony\ChoiceType::class, [
                    'label'    => 'ekyna_core.field.status',
                    'choices'  => SupplierOrderStates::getChoices(),
                    'required' => false,
                    'disabled' => true,
                ])
                ->add('estimatedDateOfArrival', Symfony\DateTimeType::class, [
                    'label'    => 'ekyna_commerce.supplier_order.field.estimated_date_of_arrival',
                    'format'   => 'dd/MM/yyyy', // TODO localised configurable format
                    'required' => false,
                ])
                ->add('shippingCost', MoneyType::class, [
                    'label'    => 'ekyna_commerce.supplier_order.field.shipping_cost',
                    'currency' => $currency ? $currency->getCode() : 'EUR', // TODO default user currency
                ])
                ->add('paymentDate', Symfony\DateTimeType::class, [
                    'label'    => 'ekyna_commerce.supplier_order.field.payment_date',
                    'format'   => 'dd/MM/yyyy', // TODO localised configurable format
                    'required' => false,
                ])
                ->add('paymentTotal', MoneyType::class, [
                    'label'    => 'ekyna_commerce.supplier_order.field.payment_total',
                    'currency' => $currency ? $currency->getCode() : 'EUR', // TODO default user currency
                    'disabled' => true,
                ])
                ->add('compose', SupplierOrderComposeType::class, [
                    'supplier' => $supplier,
                ]);
        });
    }

    /**
     * @inheritDoc
     */
    public function finishView(Form\FormView $view, Form\FormInterface $form, array $options)
    {
        FormUtil::addClass($view, 'commerce-supplier-order');
    }
}
