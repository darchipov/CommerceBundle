<?php

namespace Ekyna\Bundle\CommerceBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;

/**
 * Class AdminMenuPass
 * @package Ekyna\Bundle\CommerceBundle\DependencyInjection\Compiler
 * @author  Étienne Dauvergne <contact@ekyna.com>
 */
class AdminMenuPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->hasDefinition('ekyna_admin.menu.pool')) {
            return;
        }

        $pool = $container->getDefinition('ekyna_admin.menu.pool');

        $pool->addMethodCall('createGroup', [[
            'name'     => 'sales',
            'label'    => 'ekyna_commerce.sale.label.plural',
            'icon'     => 'file',
            'position' => 10,
        ]]);

        // Orders
        $pool->addMethodCall('createEntry', ['sales', [
            'name'     => 'orders',
            'route'    => 'ekyna_commerce_order_admin_home',
            'label'    => 'ekyna_commerce.order.label.plural',
            'resource' => 'ekyna_commerce_order',
            'position' => 1,
        ]]);
        $pool->addMethodCall('createEntry', ['sales', [
            'name'     => 'quotes',
            'route'    => 'ekyna_commerce_quote_admin_home',
            'label'    => 'ekyna_commerce.quote.label.plural',
            'resource' => 'ekyna_commerce_quote',
            'position' => 2,
        ]]);

        // Customers
        $pool->addMethodCall('createEntry', ['sales', [
            'name'     => 'customer_groups',
            'route'    => 'ekyna_commerce_customer_group_admin_home',
            'label'    => 'ekyna_commerce.customer_group.label.plural',
            'resource' => 'ekyna_commerce_customer_group',
            'position' => 10,
        ]]);
        $pool->addMethodCall('createEntry', ['sales', [
            'name'     => 'customers',
            'route'    => 'ekyna_commerce_customer_admin_home',
            'label'    => 'ekyna_commerce.customer.label.plural',
            'resource' => 'ekyna_commerce_customer',
            'position' => 11,
        ]]);

        // ------------------------------------------------------------

        $pool->addMethodCall('createGroup', [[
            'name'     => 'suppliers',
            'label'    => 'ekyna_commerce.supplier.label.plural',
            'icon'     => 'file',
            'position' => 11,
        ]]);

        // Suppliers
        $pool->addMethodCall('createEntry', ['suppliers', [
            'name'     => 'suppliers',
            'route'    => 'ekyna_commerce_supplier_admin_home',
            'label'    => 'ekyna_commerce.supplier.label.plural',
            'resource' => 'ekyna_commerce_supplier',
            'position' => 1,
        ]]);

        // Supplier orders
        $pool->addMethodCall('createEntry', ['suppliers', [
            'name'     => 'supplier_orders',
            'route'    => 'ekyna_commerce_supplier_order_admin_home',
            'label'    => 'ekyna_commerce.supplier_order.label.plural',
            'resource' => 'ekyna_commerce_supplier_order',
            'position' => 1,
        ]]);

        // ------------------------------------------------------------

        $pool->addMethodCall('createGroup', [[
            'name'     => 'setting',
            'label'    => 'ekyna_setting.label',
            'icon'     => 'cogs',
            'position' => 100,
        ]]);

        // Payment / Shipment methods

        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'payment_term',
            'route'    => 'ekyna_commerce_payment_term_admin_home',
            'label'    => 'ekyna_commerce.payment_term.label.plural',
            'resource' => 'ekyna_commerce_payment_term',
            'position' => 50,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'payment_method',
            'route'    => 'ekyna_commerce_payment_method_admin_home',
            'label'    => 'ekyna_commerce.payment_method.label.plural',
            'resource' => 'ekyna_commerce_payment_method',
            'position' => 51,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'shipment_method',
            'route'    => 'ekyna_commerce_shipment_method_admin_home',
            'label'    => 'ekyna_commerce.shipment_method.label.plural',
            'resource' => 'ekyna_commerce_shipment_method',
            'position' => 52,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'shipment_zone',
            'route'    => 'ekyna_commerce_shipment_zone_admin_home',
            'label'    => 'ekyna_commerce.shipment_zone.label.plural',
            'resource' => 'ekyna_commerce_shipment_zone',
            'position' => 53,
        ]]);

        // Tax groups / Tax rules / Taxes
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'tax_group',
            'route'    => 'ekyna_commerce_tax_group_admin_home',
            'label'    => 'ekyna_commerce.tax_group.label.plural',
            'resource' => 'ekyna_commerce_tax_group',
            'position' => 70,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'tax_rule',
            'route'    => 'ekyna_commerce_tax_rule_admin_home',
            'label'    => 'ekyna_commerce.tax_rule.label.plural',
            'resource' => 'ekyna_commerce_tax_rule',
            'position' => 71,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'taxes',
            'route'    => 'ekyna_commerce_tax_admin_home',
            'label'    => 'ekyna_commerce.tax.label.plural',
            'resource' => 'ekyna_commerce_tax',
            'position' => 72,
        ]]);

        // Countries / Currencies
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'countries',
            'route'    => 'ekyna_commerce_country_admin_home',
            'label'    => 'ekyna_commerce.country.label.plural',
            'resource' => 'ekyna_commerce_country',
            'position' => 98,
        ]]);
        $pool->addMethodCall('createEntry', ['setting', [
            'name'     => 'currencies',
            'route'    => 'ekyna_commerce_currency_admin_home',
            'label'    => 'ekyna_commerce.currency.label.plural',
            'resource' => 'ekyna_commerce_currency',
            'position' => 99,
        ]]);
    }
}
