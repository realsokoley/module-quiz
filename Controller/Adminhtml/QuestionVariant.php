<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml;

abstract class QuestionVariant extends \Magento\Backend\App\Action
{
    /**
     * Authorization level
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Sokoley_Quiz::questionvariant';

    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $coreRegistry;

    /**
     * QuestionVariant repository
     *
     * @var \Sokoley\Quiz\Api\QuestionVariantRepositoryInterface
     */
    protected $repository;

    /**
     * @param \Sokoley\Quiz\Api\QuestionVariantRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Sokoley\Quiz\Api\QuestionVariantRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        parent::__construct($context);
        $this->repository = $repository;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * Init page
     *
     * @param \Magento\Backend\Model\View\Result\Page $resultPage
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function initPage($resultPage)
    {
        $resultPage->setActiveMenu('Sokoley_Quiz::questionvariant');

        return $resultPage;
    }
}
