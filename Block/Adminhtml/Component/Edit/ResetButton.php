<?php

/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley_Quiz
 */

namespace Sokoley\Quiz\Block\Adminhtml\Component\Edit;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class ResetButton implements ButtonProviderInterface
{
    /**
     * Get Button Data
     *
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30,
        ];
    }
}