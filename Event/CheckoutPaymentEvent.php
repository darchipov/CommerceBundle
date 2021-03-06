<?php

namespace Ekyna\Bundle\CommerceBundle\Event;

use Ekyna\Component\Commerce\Common\Model\SaleInterface;
use Ekyna\Component\Commerce\Payment\Model\PaymentInterface;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\Form\FormInterface;

/**
 * Class CheckoutPaymentEvent
 * @package Ekyna\Bundle\CommerceBundle\Event
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class CheckoutPaymentEvent extends Event
{
    const BUILD_FORM = 'ekyna_commerce.checkout.build_payment_form';

    /**
     * @var SaleInterface
     */
    private $sale;

    /**
     * @var PaymentInterface
     */
    private $payment;

    /**
     * @var FormInterface
     */
    private $form;


    /**
     * Constructor.
     *
     * @param SaleInterface    $sale
     * @param PaymentInterface $payment
     */
    public function __construct(SaleInterface $sale, PaymentInterface $payment)
    {
        $this->sale = $sale;
        $this->payment = $payment;
    }

    /**
     * Returns the sale.
     *
     * @return SaleInterface
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * Returns the payment.
     *
     * @return PaymentInterface
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Returns the form.
     *
     * @return FormInterface
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * Sets the form.
     *
     * @param FormInterface $form
     */
    public function setForm(FormInterface $form)
    {
        $this->form = $form;
    }
}
