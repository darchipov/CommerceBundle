<?php

namespace Ekyna\Bundle\CommerceBundle\Table\Column;

use Ekyna\Bundle\CommerceBundle\Service\StateHelper;
use Ekyna\Component\Table\Extension\Core\Type\Column\TextType;
use Ekyna\Component\Table\Table;
use Ekyna\Component\Table\View\Cell;

/**
 * Class ShipmentStateType
 * @package Ekyna\Bundle\CommerceBundle\Table\Column
 * @author  Etienne Dauvergne <contact@ekyna.com>
 */
class ShipmentStateType extends TextType
{
    /**
     * @var StateHelper
     */
    private $stateHelper;


    /**
     * Constructor.
     *
     * @param StateHelper $stateHelper
     */
    public function __construct(StateHelper $stateHelper)
    {
        $this->stateHelper = $stateHelper;
    }

    /**
     * {@inheritdoc}
     */
    public function buildViewCell(Cell $cell, Table $table, array $options)
    {
        parent::buildViewCell($cell, $table, $options);

        $cell->setVars([
            'type'  => 'text',
            'value' => $this->stateHelper->renderShipmentStateBadge($cell->vars['value']),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ekyna_commerce_shipment_state';
    }
}
