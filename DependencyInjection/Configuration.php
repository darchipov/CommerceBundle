<?php

namespace Ekyna\Bundle\CommerceBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Ekyna\Bundle\CommerceBundle\DependencyInjection
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('ekyna_commerce');

        $this->addDefaultSection($rootNode);
        $this->addPoolsSection($rootNode);

        return $treeBuilder;
    }

    /**
     * Adds `pools` section.
     *
     * @param ArrayNodeDefinition $node
     */
    private function addDefaultSection(ArrayNodeDefinition $node)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $node
            ->children()
                ->arrayNode('default')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('countries')
                            ->defaultValue(['US'])
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('currencies')
                            ->defaultValue(['USD'])
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
            ->end();
    }

    /**
     * Adds `pools` section.
     *
     * @param ArrayNodeDefinition $node
     *
     * @TODO Split
     */
    private function addPoolsSection(ArrayNodeDefinition $node)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $node
            ->children()
                ->arrayNode('pools')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('cart')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Cart:_form.html',
                                    'show.html'   => 'EkynaCommerceBundle:Admin/Cart:show.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Cart:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Cart:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Cart\Entity\Cart')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\CartRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Cart\CartType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\CartType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cart_address')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Cart\Entity\CartAddress')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.cart')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cart_attachment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Attachment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Attachment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Attachment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Attachment:remove.html',
                                ])->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleAttachmentController')->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Cart\Entity\CartAttachment')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Cart\CartAttachmentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.cart')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cart_item')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'     => 'EkynaCommerceBundle:Admin/Common/Item:_form.html',
                                    'add.html'       => 'EkynaCommerceBundle:Admin/Common/Item:add.html',
                                    'new.html'       => 'EkynaCommerceBundle:Admin/Common/Item:new.html',
                                    'configure.html' => 'EkynaCommerceBundle:Admin/Common/Item:configure.html',
                                    'edit.html'      => 'EkynaCommerceBundle:Admin/Common/Item:edit.html',
                                    'remove.html'    => 'EkynaCommerceBundle:Admin/Common/Item:remove.html',
                                ])->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleItemController')->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Cart\Entity\CartItem')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Cart\CartItemType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.cart')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cart_item_adjustment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Cart\Entity\CartItemAdjustment')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.cart_item')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cart_adjustment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Adjustment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Adjustment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Adjustment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Adjustment:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Cart\Entity\CartAdjustment')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleAdjustmentController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Cart\CartAdjustmentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.cart')->end()
                            ->end()
                        ->end()
                        ->arrayNode('cart_payment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Payment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Payment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Payment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Payment:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Cart\Entity\CartPayment')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\CartPaymentRepository')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SalePaymentController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Cart\CartPaymentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.cart')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('country')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/Country:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/Country:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Common\Entity\Country')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\CountryController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\CountryRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Common\CountryType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\CountryType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('currency')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/Currency:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/Currency:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Common\Entity\Currency')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\CurrencyController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\CurrencyRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Common\CurrencyType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\CurrencyType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('customer_address')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue('EkynaCommerceBundle:Admin/CustomerAddress')->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Customer\Entity\CustomerAddress')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\CustomerAddressController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\CustomerAddressRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Customer\CustomerAddressType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\CustomerAddressType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.customer')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('customer')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/Customer:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/Customer:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Bundle\CommerceBundle\Entity\Customer')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\CustomerController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Bundle\CommerceBundle\Repository\CustomerRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Customer\CustomerType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\CustomerType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('customer_group')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/CustomerGroup:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/CustomerGroup:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Customer\Entity\CustomerGroup')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\CustomerGroupController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\CustomerGroupRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Customer\CustomerGroupType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\CustomerGroupType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'     => 'EkynaCommerceBundle:Admin/Order:_form.html',
                                    'show.html'      => 'EkynaCommerceBundle:Admin/Order:show.html',
                                    'edit.html'      => 'EkynaCommerceBundle:Admin/Order:edit.html',
                                    'remove.html'    => 'EkynaCommerceBundle:Admin/Order:remove.html',
                                    'transform.html' => 'EkynaCommerceBundle:Admin/Order:transform.html',
                                    'notify.html'    => 'EkynaCommerceBundle:Admin/Order:notify.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Bundle\CommerceBundle\Entity\Order')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\OrderRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Order\OrderType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\OrderType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_address')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderAddress')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_attachment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Attachment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Attachment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Attachment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Attachment:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderAttachment')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleAttachmentController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Order\OrderAttachmentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_item')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'     => 'EkynaCommerceBundle:Admin/Common/Item:_form.html',
                                    'add.html'       => 'EkynaCommerceBundle:Admin/Common/Item:add.html',
                                    'new.html'       => 'EkynaCommerceBundle:Admin/Common/Item:new.html',
                                    'configure.html' => 'EkynaCommerceBundle:Admin/Common/Item:configure.html',
                                    'edit.html'      => 'EkynaCommerceBundle:Admin/Common/Item:edit.html',
                                    'remove.html'    => 'EkynaCommerceBundle:Admin/Common/Item:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderItem')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleItemController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Order\OrderItemType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_item_stock_assignment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderItemStockAssignment')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order_item')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_item_adjustment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderItemAdjustment')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order_item')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_adjustment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Adjustment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Adjustment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Adjustment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Adjustment:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderAdjustment')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleAdjustmentController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Order\OrderAdjustmentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_payment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Payment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Payment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Payment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Payment:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderPayment')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\OrderPaymentRepository')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SalePaymentController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Order\OrderPaymentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_shipment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Shipment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Shipment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Shipment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Shipment:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderShipment')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleShipmentController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Order\OrderShipmentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_shipment_item')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderShipmentItem')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order_shipment')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_credit')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Credit:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Credit:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Credit:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Credit:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderCredit')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleCreditController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Order\OrderCreditType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order')->end()
                            ->end()
                        ->end()
                        ->arrayNode('order_credit_item')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Order\Entity\OrderCreditItem')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.order_credit')->end()
                            ->end()
                        ->end()
                        ->arrayNode('payment_message')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Payment\Entity\PaymentMessage')->end()
                                ->arrayNode('translation')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Payment\Entity\PaymentMessageTranslation')->end()
                                        ->arrayNode('fields')->prototype('scalar')->end()->defaultValue(['content'])->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('payment_method')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/PaymentMethod:_form.html',
                                    'new.html'   => 'EkynaCommerceBundle:Admin/PaymentMethod:new.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/PaymentMethod:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Bundle\CommerceBundle\Entity\PaymentMethod')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\PaymentMethodController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\PaymentMethodRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Payment\PaymentMethodType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\PaymentMethodType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                                ->arrayNode('translation')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Payment\Entity\PaymentMethodTranslation')->end()
                                        ->scalarNode('repository')->end()
                                        ->arrayNode('fields')
                                            ->prototype('scalar')->end()
                                            ->defaultValue(['title', 'description'])
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('payment_term')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/PaymentTerm:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/PaymentTerm:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Payment\Entity\PaymentTerm')->end()
                                ->scalarNode('controller')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Payment\PaymentTermType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\PaymentTermType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                                ->arrayNode('translation')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Payment\Entity\PaymentTermTranslation')->end()
                                        ->scalarNode('repository')->end()
                                        ->arrayNode('fields')
                                            ->prototype('scalar')->end()
                                            ->defaultValue(['title', 'description'])
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('shipment_message')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Shipment\Entity\ShipmentMessage')->end()
                                ->arrayNode('translation')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Shipment\Entity\ShipmentMessageTranslation')->end()
                                        ->scalarNode('repository')->end()
                                        ->arrayNode('fields')->prototype('scalar')->end()->defaultValue(['content'])->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('shipment_method')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/ShipmentMethod:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/ShipmentMethod:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Bundle\CommerceBundle\Entity\ShipmentMethod')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\ShipmentMethodController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\ShipmentMethodRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Shipment\ShipmentMethodType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\ShipmentMethodType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                                ->arrayNode('translation')
                                    ->addDefaultsIfNotSet()
                                    ->children()
                                        ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Shipment\Entity\ShipmentMethodTranslation')->end()
                                        ->scalarNode('repository')->end()
                                        ->arrayNode('fields')
                                            ->prototype('scalar')->end()
                                            ->defaultValue(['title', 'description'])
                                        ->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('shipment_zone')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/ShipmentZone:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/ShipmentZone:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Shipment\Entity\ShipmentZone')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\ShipmentZoneController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\ShipmentZoneRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Shipment\ShipmentZoneType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\ShipmentZoneType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('shipment_price')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Shipment\Entity\ShipmentPrice')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\ShipmentPriceRepository')->end()
                            ->end()
                        ->end()
                        ->arrayNode('supplier')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/Supplier:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/Supplier:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Supplier\Entity\Supplier')->end()
                                ->scalarNode('controller')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Supplier\SupplierType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\SupplierType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('supplier_product')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue('EkynaCommerceBundle:Admin/SupplierProduct')->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Supplier\Entity\SupplierProduct')->end()
                                ->scalarNode('controller')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Supplier\SupplierProductType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\SupplierProductType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.supplier')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('supplier_order')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/SupplierOrder:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/SupplierOrder:new.html',
                                    'show.html'   => 'EkynaCommerceBundle:Admin/SupplierOrder:show.html',
                                    'submit.html' => 'EkynaCommerceBundle:Admin/SupplierOrder:submit.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Supplier\Entity\SupplierOrder')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SupplierOrderController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Supplier\SupplierOrderType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\SupplierOrderType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('supplier_order_item')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Supplier\Entity\SupplierOrderItem')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Supplier\SupplierOrderItemType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.supplier_order')->end()
                            ->end()
                        ->end()
                        ->arrayNode('supplier_delivery')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue('EkynaCommerceBundle:Admin/SupplierDelivery')->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Supplier\Entity\SupplierDelivery')->end()
                                ->scalarNode('controller')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Supplier\SupplierDeliveryType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\SupplierDeliveryType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.supplier_order')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('supplier_delivery_item')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Supplier\Entity\SupplierDeliveryItem')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Supplier\SupplierDeliveryItemType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.supplier_delivery')->end()
                            ->end()
                        ->end()
                        ->arrayNode('quote')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'     => 'EkynaCommerceBundle:Admin/Quote:_form.html',
                                    'show.html'      => 'EkynaCommerceBundle:Admin/Quote:show.html',
                                    'edit.html'      => 'EkynaCommerceBundle:Admin/Quote:edit.html',
                                    'remove.html'    => 'EkynaCommerceBundle:Admin/Quote:remove.html',
                                    'transform.html' => 'EkynaCommerceBundle:Admin/Quote:transform.html',
                                    'notify.html'    => 'EkynaCommerceBundle:Admin/Quote:notify.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Quote\Entity\Quote')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\QuoteRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Quote\QuoteType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\QuoteType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('quote_address')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Quote\Entity\QuoteAddress')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.quote')->end()
                            ->end()
                        ->end()
                        ->arrayNode('quote_attachment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Attachment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Attachment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Attachment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Attachment:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Quote\Entity\QuoteAttachment')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleAttachmentController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Quote\QuoteAttachmentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.quote')->end()
                            ->end()
                        ->end()
                        ->arrayNode('quote_item')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'     => 'EkynaCommerceBundle:Admin/Common/Item:_form.html',
                                    'add.html'       => 'EkynaCommerceBundle:Admin/Common/Item:add.html',
                                    'new.html'       => 'EkynaCommerceBundle:Admin/Common/Item:new.html',
                                    'configure.html' => 'EkynaCommerceBundle:Admin/Common/Item:configure.html',
                                    'edit.html'      => 'EkynaCommerceBundle:Admin/Common/Item:edit.html',
                                    'remove.html'    => 'EkynaCommerceBundle:Admin/Common/Item:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Quote\Entity\QuoteItem')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleItemController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Quote\QuoteItemType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.quote')->end()
                            ->end()
                        ->end()
                        ->arrayNode('quote_item_adjustment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Quote\Entity\QuoteItemAdjustment')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.quote_item')->end()
                            ->end()
                        ->end()
                        ->arrayNode('quote_adjustment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Adjustment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Adjustment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Adjustment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Adjustment:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Quote\Entity\QuoteAdjustment')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SaleAdjustmentController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Quote\QuoteAdjustmentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.quote')->end()
                            ->end()
                        ->end()
                        ->arrayNode('quote_payment')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html'  => 'EkynaCommerceBundle:Admin/Common/Payment:_form.html',
                                    'new.html'    => 'EkynaCommerceBundle:Admin/Common/Payment:new.html',
                                    'edit.html'   => 'EkynaCommerceBundle:Admin/Common/Payment:edit.html',
                                    'remove.html' => 'EkynaCommerceBundle:Admin/Common/Payment:remove.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Quote\Entity\QuotePayment')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\QuotePaymentRepository')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\SalePaymentController')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\Quote\QuotePaymentType')->end()
                                ->scalarNode('parent')->defaultValue('ekyna_commerce.quote')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('tax')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/Tax:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/Tax:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Pricing\Entity\Tax')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\TaxController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\TaxType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\TaxType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('tax_group')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/TaxGroup:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/TaxGroup:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Pricing\Entity\TaxGroup')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\TaxGroupController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\TaxGroupRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\TaxGroupType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\TaxGroupType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                        ->arrayNode('tax_rule')
                            ->addDefaultsIfNotSet()
                            ->children()
                                ->variableNode('templates')->defaultValue([
                                    '_form.html' => 'EkynaCommerceBundle:Admin/TaxRule:_form.html',
                                    'show.html'  => 'EkynaCommerceBundle:Admin/TaxRule:show.html',
                                ])->end()
                                ->scalarNode('entity')->defaultValue('Ekyna\Component\Commerce\Pricing\Entity\TaxRule')->end()
                                ->scalarNode('controller')->defaultValue('Ekyna\Bundle\CommerceBundle\Controller\Admin\TaxRuleController')->end()
                                ->scalarNode('operator')->end()
                                ->scalarNode('repository')->defaultValue('Ekyna\Component\Commerce\Bridge\Doctrine\ORM\Repository\TaxRuleRepository')->end()
                                ->scalarNode('form')->defaultValue('Ekyna\Bundle\CommerceBundle\Form\Type\TaxRuleType')->end()
                                ->scalarNode('table')->defaultValue('Ekyna\Bundle\CommerceBundle\Table\Type\TaxRuleType')->end()
                                ->scalarNode('parent')->end()
                                ->scalarNode('event')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
}
