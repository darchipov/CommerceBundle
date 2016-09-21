<?php

namespace Ekyna\Bundle\CommerceBundle\Form\Type\Sale;

use Ekyna\Bundle\AdminBundle\Form\Type\ResourceFormType;
use Ekyna\Bundle\CommerceBundle\Form\Type\CurrencyChoiceType;
use Ekyna\Bundle\CommerceBundle\Model\CustomerInterface;
use Ekyna\Bundle\CoreBundle\Form\Type\EntitySearchType;
use Ekyna\Bundle\UserBundle\Form\Type\IdentityType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class QuoteType
 * @package Ekyna\Bundle\CommerceBundle\Form\Type\Sale
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class QuoteType extends ResourceFormType
{
    /**
     * @var string
     */
    private $customerClass;


    /**
     * Constructor.
     *
     * @param string $quoteClass
     * @param string $customerClass
     */
    public function __construct($quoteClass, $customerClass)
    {
        parent::__construct($quoteClass);

        $this->customerClass = $customerClass;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', Type\TextType::class, [
                'label'    => 'ekyna_core.field.number',
                'disabled' => true,
            ])
            ->add('currency', CurrencyChoiceType::class, [
                'sizing' => 'sm',
            ])
            ->add('customer', EntitySearchType::class, [
                'label'           => 'ekyna_commerce.customer.label.singular',
                'class'          => $this->customerClass,
                'search_route'    => 'ekyna_commerce_customer_admin_search',
                'find_route'      => 'ekyna_commerce_customer_admin_find',
                'allow_clear'     => false,
                'choice_label' => function(CustomerInterface $data) {
                    $output = $data->getFirstName() . ' ' . $data->getLastName() . ' &lt;<em>' . $data->getEmail() . '</em>&gt;';
                    if (0 < strlen($data->getCompany())) {
                        $output = '[<strong>' . $data->getCompany() . '</strong>] ' . $output;
                    }
                    return '<span>' . $output . '</span>';
                },
                'format_function' =>
                    "if(!data.id)return 'Rechercher';" .
                    "var output=data.first_name+' '+data.last_name+' &lt;<em>'+data.email+'</em>&gt;';" .
                    "if(data.company)output='[<strong>'+data.company+'</strong>] '+output;" .
                    "return $('<span>'+output+'</span>');",
                'required'        => false,
            ])
            ->add('company', Type\TextType::class, [
                'label'    => 'ekyna_core.field.company',
                'required' => false,
            ])
            ->add('identity', IdentityType::class)
            ->add('email', Type\EmailType::class, [
                'label'    => 'ekyna_core.field.email',
                'required' => false,
            ])
            ->add('invoiceAddress', QuoteAddressType::class, [
                'label' => 'ekyna_commerce.sale.field.invoice_address',
            ])
            ->add('sameAddress', Type\CheckboxType::class, [
                'label'    => 'ekyna_commerce.sale.field.same_address',
                'required' => false,
                'attr'     => [
                    'align_with_widget' => true,
                ],
            ])
            ->add('deliveryAddress', QuoteAddressType::class, [
                'label'    => 'ekyna_commerce.sale.field.delivery_address',
                'required' => false,
            ])
            /*->add('items', QuoteItemsType::class)
            ->add('adjustments', AdjustmentsType::class, [
                'entry_type'            => QuoteAdjustmentType::class,
                'add_button_text'       => 'ekyna_commerce.sale.form.add_adjustment',
                'delete_button_confirm' => 'ekyna_commerce.sale.form.remove_adjustment',
            ])*/;
    }
}
