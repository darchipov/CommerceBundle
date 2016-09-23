<?php

namespace Ekyna\Bundle\CommerceBundle\EventListener;

use Ekyna\Bundle\AdminBundle\Event\ResourceMessage;
use Ekyna\Component\Commerce\Bridge\Symfony\EventListener\QuoteEventSubscriber as BaseSubscriber;
use Ekyna\Component\Commerce\Common\Model\SaleInterface;
use Ekyna\Component\Commerce\Exception\CommerceExceptionInterface;
use Ekyna\Component\Commerce\Exception\InvalidArgumentException;
use Ekyna\Component\Commerce\Quote\Event\QuoteEvents;
use Ekyna\Component\Commerce\Quote\Model\QuoteInterface;
use Ekyna\Component\Resource\Event\ResourceEventInterface;

/**
 * Class QuoteEventSubscriber
 * @package Ekyna\Bundle\CommerceBundle\EventListener
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class QuoteEventSubscriber extends BaseSubscriber
{
    /**
     * @inheritdoc
     */
    public function onPreDelete(ResourceEventInterface $event)
    {
        try {
            parent::onPreDelete($event);
        } catch (CommerceExceptionInterface $e) {
            /** @var \Ekyna\Bundle\AdminBundle\Event\ResourceEventInterface $event */
            $event->addMessage(new ResourceMessage(
                'ekyna_commerce.quote.message.cant_be_deleted', // TODO
                ResourceMessage::TYPE_ERROR
            ));
        }
    }

    /**
     * @inheritdoc
     */
    protected function handleIdentity(SaleInterface $sale)
    {
        if (!$sale instanceof QuoteInterface) {
            throw new InvalidArgumentException("Expected instance of QuoteInterface.");
        }

        $changed = false;

        /**
         * @var \Ekyna\Bundle\CommerceBundle\Model\QuoteInterface    $sale
         * @var \Ekyna\Bundle\CommerceBundle\Model\CustomerInterface $customer
         */
        if (null !== $customer = $sale->getCustomer()) {
            if (0 == strlen($sale->getGender())) {
                $sale->setGender($customer->getGender());
                $changed = true;
            }
        }

        return $changed || parent::handleIdentity($sale);
    }

    /**
     * @inheritdoc
     */
    public static function getSubscribedEvents()
    {
        return array_merge(parent::getSubscribedEvents(), [
            QuoteEvents::PRE_DELETE => ['onPreDelete', 0],
        ]);
    }
}