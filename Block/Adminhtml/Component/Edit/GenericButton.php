<?php

/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley_Quiz
 */

namespace Sokoley\Quiz\Block\Adminhtml\Component\Edit;

class GenericButton
{
    /**
     * @var string
     */
    protected $key = 'id';

    /**
     * @var \Magento\Backend\Block\Widget\Context
     */
    private $context;

    /**
     * @param \Magento\Backend\Block\Widget\Context $context
     */
    public function __construct(
        \Magento\Backend\Block\Widget\Context $context
    ) {
        $this->context = $context;
    }

    /**
     * Return Entity ID
     *
     * @return int|null
     */
    public function getEntityId()
    {
        return $this->context->getRequest()->getParam($this->key) ?: null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param string $route
     * @param array $params
     * @return string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}