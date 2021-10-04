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
class QuizRepository implements \Sokoley\Quiz\Api\QuizRepositoryInterface
{
    /** @var \Sokoley\Quiz\Model\ResourceModel\Quiz */
    private $resource;

    /** @var \Sokoley\Quiz\Model\ResourceModel\Quiz\CollectionFactory */
    private $collectionFactory;

    /** @var \Sokoley\Quiz\Api\Data\QuizInterfaceFactory */
    private $entityFactory;

    /** @var \Sokoley\Quiz\Api\Data\QuizSearchResultsInterfaceFactory */
    private $searchResultsFactory;

    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    /**
     * @param \Sokoley\Quiz\Model\ResourceModel\Quiz $resource
     * @param \Sokoley\Quiz\Model\ResourceModel\Quiz\CollectionFactory $collectionFactory
     * @param \Sokoley\Quiz\Api\Data\QuizInterfaceFactory $entityFactory
     * @param \Sokoley\Quiz\Api\Data\QuizSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        ResourceModel\Quiz $resource,
        ResourceModel\Quiz\CollectionFactory $collectionFactory,
        \Sokoley\Quiz\Api\Data\QuizInterfaceFactory $entityFactory,
        \Sokoley\Quiz\Api\Data\QuizSearchResultsInterfaceFactory $searchResultsFactory,
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
     * @return \Sokoley\Quiz\Api\Data\QuizInterface
     */
    public function getById($entityId)
    {
        $entity = $this->entityFactory->create();
        $this->resource->load($entity, $entityId);
        if (!$entity->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Quiz Quiz with id "%1" does not exist.', $entityId)
            );
        }

        return $entity;
    }

    /**
     * @param \Sokoley\Quiz\Api\Data\QuizInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return \Sokoley\Quiz\Api\Data\QuizInterface
     */
    public function save(\Sokoley\Quiz\Api\Data\QuizInterface $entity)
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
     * @param \Sokoley\Quiz\Api\Data\QuizInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @return bool
     */
    public function delete(\Sokoley\Quiz\Api\Data\QuizInterface $entity)
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
     * @return \Sokoley\Quiz\Api\Data\QuizSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Sokoley\Quiz\Model\ResourceModel\Quiz\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var \Sokoley\Quiz\Api\Data\QuizSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
