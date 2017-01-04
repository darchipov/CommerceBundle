<?php

namespace Ekyna\Bundle\CommerceBundle\Twig;

use Ekyna\Bundle\CommerceBundle\Model\PaymentMethodInterface;
use Ekyna\Bundle\CommerceBundle\Service\ConstantsHelper;
use Ekyna\Component\Commerce\Common\Model\MessageInterface;
use Ekyna\Component\Commerce\Payment\Model\PaymentInterface;

/**
 * Class PaymentExtension
 * @package Ekyna\Bundle\CommerceBundle\Twig
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class PaymentExtension extends \Twig_Extension
{
    /**
     * @var ConstantsHelper
     */
    private $constantHelper;


    /**
     * Constructor.
     *
     * @param \Ekyna\Bundle\CommerceBundle\Service\ConstantsHelper $constantHelper
     */
    public function __construct(ConstantsHelper $constantHelper)
    {
        $this->constantHelper = $constantHelper;
    }

    /**
     * @inheritdoc
     */
    public function getFilters()
    {
        return [
            new \Twig_SimpleFilter(
                'payment_state_label',
                [$this->constantHelper, 'renderPaymentStateLabel'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFilter(
                'payment_state_badge',
                [$this->constantHelper, 'renderPaymentStateBadge'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFilter(
                'payment_state_message',
                [$this, 'renderPaymentStateMessage'],
                ['is_safe' => ['html']]
            ),
            new \Twig_SimpleFilter(
                'payment_method_config',
                [$this, 'renderMethodConfig'],
                ['is_safe' => ['html']]
            ),
        ];
    }

    /**
     * Renders the payment method config.
     *
     * @param PaymentMethodInterface $method
     * @return string
     */
    public function renderMethodConfig(PaymentMethodInterface $method)
    {
        $output = '<dl class="dl-horizontal">';

        foreach ($method->getConfig() as $key => $value) {
            if (is_array($value)) {
                continue;
            }

            $output .= sprintf('<dt>%s</dt><dd>%s</dd>', $key, $value);
        }

        $output .= '</dl>';

        return $output;
    }

    /**
     * Renders the payment state message.
     *
     * @param PaymentInterface $payment
     *
     * @return null|string
     */
    public function renderPaymentStateMessage(PaymentInterface $payment)
    {
        $state = $payment->getState();
        $method = $payment->getMethod();

        foreach ($method->getMessages() as $message) {
            if ($message->getState() === $state) {
                $content = $message->getContent();
                return $content;
            }
        }

        return null;
    }

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'ekyna_commerce_payment';
    }
}
