<?php

namespace Ekyna\Bundle\CommerceBundle\EventListener;

use Ekyna\Bundle\AdminBundle\Event\ResourceEventInterface;
use Ekyna\Bundle\AdminBundle\Event\ResourceMessage;
use Ekyna\Component\Commerce\Bridge\Symfony\EventListener\OrderEventSubscriber as BaseSubscriber;
use Ekyna\Component\Commerce\Exception\CommerceExceptionInterface;
use Ekyna\Component\Commerce\Order\Event\OrderEvents;
use Ekyna\Component\Commerce\Order\Model\OrderEventInterface;
use Ekyna\Component\Commerce\Order\Model\OrderInterface;

/**
 * Class OrderEventSubscriber
 * @package Ekyna\Bundle\CommerceBundle\EventListener
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class OrderEventSubscriber extends BaseSubscriber
{
    /**
     * Pre delete event handler.
     *
     * @param OrderEventInterface $event
     */
    public function onPreDelete(OrderEventInterface $event)
    {
        try {
            parent::onPreDelete($event);
        } catch (CommerceExceptionInterface $e) {
            /** @var ResourceEventInterface $event */
            $event->addMessage(new ResourceMessage(
                'ekyna_commerce.order.message.cant_be_deleted', // TODO
                ResourceMessage::TYPE_ERROR
            ));
        }
    }

    /**
     * @inheritdoc
     */
    protected function handleIdentity(OrderInterface $order)
    {
        $changed = false;

        /**
         * @var \Ekyna\Bundle\CommerceBundle\Model\OrderInterface $order
         * @var \Ekyna\Bundle\CommerceBundle\Model\CustomerInterface $customer
         */
        if (null !== $customer = $order->getCustomer()) {
            if (0 == strlen($order->getGender())) {
                $order->setGender($customer->getGender());
                $changed = true;
            }
        }

        return $changed || parent::handleIdentity($order);
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return array_merge(parent::getSubscribedEvents(), [
            OrderEvents::PRE_DELETE => ['onPreDelete', 0],
        ]);
    }
}
