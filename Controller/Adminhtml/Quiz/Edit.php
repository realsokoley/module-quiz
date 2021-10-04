<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml\Quiz;

class Edit extends \Sokoley\Quiz\Controller\Adminhtml\Quiz
{
    /** @var \Sokoley\Quiz\Api\Data\QuizInterfaceFactory */
    private $entityFactory;

    /** @var \Magento\Framework\View\Result\PageFactory */
    private $resultPageFactory;

    /**
     * @param \Sokoley\Quiz\Api\Data\QuizInterfaceFactory $entityFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Sokoley\Quiz\Api\QuizRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Sokoley\Quiz\Api\Data\QuizInterfaceFactory $entityFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Sokoley\Quiz\Api\QuizRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->entityFactory = $entityFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Edit Quiz action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $entityId = $this->getRequest()->getParam('id');
        $entity = $this->entityFactory->create();
        if ($entityId) {
            try {
                $entity = $this->repository->getById($entityId);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $this->messageManager->addErrorMessage(__('This Quiz no longer exists'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('sokoley_quiz_quiz', $entity);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $entityId ? __('Edit Quiz') : __('New Quiz'),
            $entityId ? __('Edit Quiz') : __('New Quiz')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Quiz'));
        $resultPage->getConfig()->getTitle()->prepend(
            $entity->getId() ? $entity->getTitle() : __('New Quiz')
        );

        return $resultPage;
    }
}
