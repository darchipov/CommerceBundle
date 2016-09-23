<?php

namespace Ekyna\Bundle\CommerceBundle\Table\Type;

use Ekyna\Bundle\AdminBundle\Table\Type\ResourceTableType;
use Ekyna\Component\Table\TableBuilderInterface;

/**
 * Class QuoteType
 * @package Ekyna\Bundle\CommerceBundle\Table\Type
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class QuoteType extends ResourceTableType
{
    /**
     * {@inheritdoc}
     */
    public function buildTable(TableBuilderInterface $builder, array $options)
    {
        $builder
            ->addColumn('id', 'number', [
                'sortable' => true,
            ])
            ->addColumn('number', 'anchor', [
                'label'                => 'ekyna_core.field.number',
                'sortable'             => true,
                'route_name'           => 'ekyna_commerce_quote_admin_show',
                'route_parameters_map' => [
                    'quoteId' => 'id',
                ],
            ])
            ->addColumn('customer', 'ekyna_commerce_sale_customer', [
                'label'    => 'ekyna_commerce.customer.label.singular',
                'sortable' => true,
            ])
            ->addColumn('grandTotal', 'price', [
                'label'         => 'ekyna_commerce.sale.field.grand_total',
                'sortable'      => true,
                'currency_path' => 'currency.code',
            ])
            ->addColumn('state', 'ekyna_commerce_sale_state', [
                'label' => 'ekyna_commerce.sale.field.state',
            ])
            ->addColumn('paymentState', 'ekyna_commerce_payment_state', [
                'label' => 'ekyna_commerce.sale.field.payment_state',
            ])
            ->addColumn('shipmentState', 'ekyna_commerce_shipment_state', [
                'label' => 'ekyna_commerce.sale.field.shipment_state',
            ])
            ->addColumn('actions', 'admin_actions', [
                'buttons' => [
                    [
                        'label'                => 'ekyna_core.button.edit',
                        'class'                => 'warning',
                        'route_name'           => 'ekyna_commerce_quote_admin_edit',
                        'route_parameters_map' => [
                            'quoteId' => 'id',
                        ],
                        'permission'           => 'edit',
                    ],
                    [
                        'label'                => 'ekyna_core.button.remove',
                        'class'                => 'danger',
                        'route_name'           => 'ekyna_commerce_quote_admin_remove',
                        'route_parameters_map' => [
                            'quoteId' => 'id',
                        ],
                        'permission'           => 'delete',
                    ],
                ],
            ])
            ->addFilter('number', 'text', [
                'label' => 'ekyna_core.field.number',
            ])
            ->addFilter('email', 'text', [
                'label' => 'ekyna_core.field.email',
            ])
            ->addFilter('company', 'text', [
                'label' => 'ekyna_core.field.company',
            ])
            ->addFilter('firstName', 'text', [
                'label' => 'ekyna_core.field.first_name',
            ])
            ->addFilter('lastName', 'text', [
                'label' => 'ekyna_core.field.last_name',
            ])/*->addFilter('atiTotal', 'number', [
                'label' => 'ekyna_quote.quote.field.ati_total',
            ])
            ->addFilter('state', 'choice', [
                'label' => 'ekyna_quote.quote.field.state',
                'choices' => QuoteStates::getChoices(),
            ])
            ->addFilter('paymentState', 'choice', [
                'label' => 'ekyna_quote.quote.field.payment_state',
                'choices' => PaymentStates::getChoices(),
            ])
            ->addFilter('shipmentState', 'choice', [
                'label' => 'ekyna_quote.quote.field.shipment_state',
                'choices' => ShipmentStates::getChoices(),
            ])*/
        ;
    }

    /**
     * {@inheritdoc}
     */
    /*public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver);

        if (null !== $group = $this->getUserGroup()) {
            $resolver->setDefaults([
                'customize_qb' => function (QueryBuilder $qb, $alias) use ($group) {
                    $qb
                        ->join($alias . '.group', 'g')
                        ->andWhere($qb->expr()->gte('g.position', $group->getPosition()));
                },
            ]);
        }
    }*/

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_commerce_quote';
    }
}