<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml\QuestionVariant;

class Edit extends \Sokoley\Quiz\Controller\Adminhtml\QuestionVariant
{
    /** @var \Sokoley\Quiz\Api\Data\QuestionVariantInterfaceFactory */
    private $entityFactory;

    /** @var \Magento\Framework\View\Result\PageFactory */
    private $resultPageFactory;

    /**
     * @param \Sokoley\Quiz\Api\Data\QuestionVariantInterfaceFactory $entityFactory
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Sokoley\Quiz\Api\QuestionVariantRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Sokoley\Quiz\Api\Data\QuestionVariantInterfaceFactory $entityFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Sokoley\Quiz\Api\QuestionVariantRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->entityFactory = $entityFactory;
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Edit Question Variant action
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
                $this->messageManager->addErrorMessage(__('This Question Variant no longer exists'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }
        $this->coreRegistry->register('sokoley_quiz_questionvariant', $entity);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $this->initPage($resultPage)->addBreadcrumb(
            $entityId ? __('Edit Question Variant') : __('New Question Variant'),
            $entityId ? __('Edit Question Variant') : __('New Question Variant')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Question Variant'));
        $resultPage->getConfig()->getTitle()->prepend(
            $entity->getId() ? $entity->getTitle() : __('New Question Variant')
        );

        return $resultPage;
    }
}
