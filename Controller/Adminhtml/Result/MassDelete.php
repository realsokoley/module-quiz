<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml\Result;

use Magento\Framework\Controller\ResultFactory;

class MassDelete extends \Sokoley\Quiz\Controller\Adminhtml\Result
{
    /** @var \Magento\Ui\Component\MassAction\Filter */
    private $filter;

    /** @var \Sokoley\Quiz\Model\ResourceModel\Result\CollectionFactory */
    private $collectionFactory;

    /**
     * @param \Sokoley\Quiz\Model\ResourceModel\Result\CollectionFactory $collectionFactory
     * @param \Magento\Ui\Component\MassAction\Filter $filter
     * @param \Sokoley\Quiz\Api\ResultRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Sokoley\Quiz\Model\ResourceModel\Result\CollectionFactory $collectionFactory,
        \Magento\Ui\Component\MassAction\Filter $filter,
        \Sokoley\Quiz\Api\ResultRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $collectionSize = $collection->getSize();

        foreach ($collection as $entity) {
            $this->repository->delete($entity);
        }
        $this->messageManager->addSuccessMessage(
            __('A total of %1 record(s) have been deleted.', $collectionSize)
        );
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        return $resultRedirect->setPath('*/*/');
    }
}
