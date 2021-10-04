<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml\Question;

class NewAction extends \Sokoley\Quiz\Controller\Adminhtml\Question
{
    /** @var \Magento\Backend\Model\View\Result\ForwardFactory */
    private $resultForwardFactory;

    /**
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     * @param \Sokoley\Quiz\Api\QuestionRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory,
        \Sokoley\Quiz\Api\QuestionRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->resultForwardFactory = $resultForwardFactory;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Create new Question
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Forward $resultForward */
        $resultForward = $this->resultForwardFactory->create();

        return $resultForward->forward('edit');
    }
}
