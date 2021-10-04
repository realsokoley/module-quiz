<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model;

use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class ResultRepository implements \Sokoley\Quiz\Api\ResultRepositoryInterface
{
    /** @var \Sokoley\Quiz\Model\ResourceModel\Result */
    private $resource;

    /** @var \Sokoley\Quiz\Model\ResourceModel\Result\CollectionFactory */
    private $collectionFactory;

    /** @var \Sokoley\Quiz\Api\Data\ResultInterfaceFactory */
    private $entityFactory;

    /** @var \Sokoley\Quiz\Api\Data\ResultSearchResultsInterfaceFactory */
    private $searchResultsFactory;

    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    /**
     * @param \Sokoley\Quiz\Model\ResourceModel\Result $resource
     * @param \Sokoley\Quiz\Model\ResourceModel\Result\CollectionFactory $collectionFactory
     * @param \Sokoley\Quiz\Api\Data\ResultInterfaceFactory $entityFactory
     * @param \Sokoley\Quiz\Api\Data\ResultSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        ResourceModel\Result $resource,
        ResourceModel\Result\CollectionFactory $collectionFactory,
        \Sokoley\Quiz\Api\Data\ResultInterfaceFactory $entityFactory,
        \Sokoley\Quiz\Api\Data\ResultSearchResultsInterfaceFactory $searchResultsFactory,
        CollectionProcessorInterface $collectionProcessor = null
    ) {
        $this->resource = $resource;
        $this->collectionFactory = $collectionFactory;
        $this->entityFactory = $entityFactory;
        $this->searchResultsFactory = $searchResultsFactory;
        $this->collectionProcessor = $collectionProcessor;
    }

    /**
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @return \Sokoley\Quiz\Api\Data\ResultInterface
     */
    public function getById($entityId)
    {
        $entity = $this->entityFactory->create();
        $this->resource->load($entity, $entityId);
        if (!$entity->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Quiz Result with id "%1" does not exist.', $entityId)
            );
        }

        return $entity;
    }

    /**
     * @param \Sokoley\Quiz\Api\Data\ResultInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return \Sokoley\Quiz\Api\Data\ResultInterface
     */
    public function save(\Sokoley\Quiz\Api\Data\ResultInterface $entity)
    {
        try {
            $this->resource->save($entity);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotSaveException(
                __($exception->getMessage())
            );
        }

        return $entity;
    }

    /**
     * @param \Sokoley\Quiz\Api\Data\ResultInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @return bool
     */
    public function delete(\Sokoley\Quiz\Api\Data\ResultInterface $entity)
    {
        try {
            $this->resource->delete($entity);
        } catch (\Exception $exception) {
            throw new \Magento\Framework\Exception\CouldNotDeleteException(
                __($exception->getMessage())
            );
        }

        return true;
    }

    /**
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @return bool
     */
    public function deleteById($entityId)
    {
        return $this->delete($this->getById($entityId));
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $criteria
     * @return \Sokoley\Quiz\Api\Data\ResultSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Sokoley\Quiz\Model\ResourceModel\Result\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var \Sokoley\Quiz\Api\Data\ResultSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
