<?php

namespace Ekyna\Bundle\CommerceBundle\Form\Type\Product;

use Ekyna\Component\Commerce\Common\Model\SaleItemInterface;
use Ekyna\Component\Commerce\Exception\InvalidArgumentException;
use Ekyna\Component\Commerce\Product\Model\BundleSlotInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class ConfigurableSlotsType
 * @package Ekyna\Bundle\CommerceBundle\Form\Type\Product
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ConfigurableSlotsType extends AbstractType
{
    /**
     * @var string
     */
    private $slotTypeClass;


    /**
     * Constructor.
     *
     * @param $slotTypeClass
     */
    public function __construct($slotTypeClass)
    {
        $this->slotTypeClass = $slotTypeClass;
    }

    /**
     * @inheritdoc
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var \Ekyna\Component\Commerce\Product\Model\BundleSlotInterface[] $bundleSlots */
        $bundleSlots = $options['bundle_slots'];
        /** @var SaleItemInterface $item */
        $item = $options['item'];

        foreach ($bundleSlots as $bundleSlot) {
            foreach ($item->getChildren() as $key => $child) {
                $bundleSlotId = intval($child->getSubjectData(BundleSlotInterface::ITEM_DATA_KEY));
                if ($bundleSlotId == $bundleSlot->getId()) {
                    // TODO (PRE_SET_DATA) $form->add()
                    $builder->add('slot_' . $bundleSlot->getId(), $this->slotTypeClass, [
                        'bundle_slot'   => $bundleSlot,
                        'property_path' => 'children[' . $key . ']',
                    ]);
                    continue 2;
                }
            }

            throw new InvalidArgumentException("Bundle slots / Item children configuration miss match.");
        }
    }

    /**
     * @inheritdoc
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'label'        => false,
                'inherit_data' => true,
                'data_class'   => SaleItemInterface::class,
            ])
            ->setRequired(['bundle_slots', 'item'])
            ->setAllowedTypes('bundle_slots', 'array')
            ->setAllowedTypes('item', SaleItemInterface::class);
    }

    /**
     * @inheritdoc
     */
    public function getBlockPrefix()
    {
        return 'ekyna_commerce_configurable_slots';
    }
}