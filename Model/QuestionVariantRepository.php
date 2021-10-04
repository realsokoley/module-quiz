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
class QuestionVariantRepository implements \Sokoley\Quiz\Api\QuestionVariantRepositoryInterface
{
    /** @var \Sokoley\Quiz\Model\ResourceModel\QuestionVariant */
    private $resource;

    /** @var \Sokoley\Quiz\Model\ResourceModel\QuestionVariant\CollectionFactory */
    private $collectionFactory;

    /** @var \Sokoley\Quiz\Api\Data\QuestionVariantInterfaceFactory */
    private $entityFactory;

    /** @var \Sokoley\Quiz\Api\Data\QuestionVariantSearchResultsInterfaceFactory */
    private $searchResultsFactory;

    /** @var CollectionProcessorInterface */
    private $collectionProcessor;

    /**
     * @param \Sokoley\Quiz\Model\ResourceModel\QuestionVariant $resource
     * @param \Sokoley\Quiz\Model\ResourceModel\QuestionVariant\CollectionFactory $collectionFactory
     * @param \Sokoley\Quiz\Api\Data\QuestionVariantInterfaceFactory $entityFactory
     * @param \Sokoley\Quiz\Api\Data\QuestionVariantSearchResultsInterfaceFactory $searchResultsFactory
     * @param CollectionProcessorInterface|null $collectionProcessor
     */
    public function __construct(
        ResourceModel\QuestionVariant $resource,
        ResourceModel\QuestionVariant\CollectionFactory $collectionFactory,
        \Sokoley\Quiz\Api\Data\QuestionVariantInterfaceFactory $entityFactory,
        \Sokoley\Quiz\Api\Data\QuestionVariantSearchResultsInterfaceFactory $searchResultsFactory,
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
     * @return \Sokoley\Quiz\Api\Data\QuestionVariantInterface
     */
    public function getById($entityId)
    {
        $entity = $this->entityFactory->create();
        $this->resource->load($entity, $entityId);
        if (!$entity->getId()) {
            throw new \Magento\Framework\Exception\NoSuchEntityException(
                __('Quiz Question Variant with id "%1" does not exist.', $entityId)
            );
        }

        return $entity;
    }

    /**
     * @param \Sokoley\Quiz\Api\Data\QuestionVariantInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     * @return \Sokoley\Quiz\Api\Data\QuestionVariantInterface
     */
    public function save(\Sokoley\Quiz\Api\Data\QuestionVariantInterface $entity)
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
     * @param \Sokoley\Quiz\Api\Data\QuestionVariantInterface $entity
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     * @return bool
     */
    public function delete(\Sokoley\Quiz\Api\Data\QuestionVariantInterface $entity)
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
     * @return \Sokoley\Quiz\Api\Data\QuestionVariantSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $criteria)
    {
        /** @var \Sokoley\Quiz\Model\ResourceModel\QuestionVariant\Collection $collection */
        $collection = $this->collectionFactory->create();

        $this->collectionProcessor->process($criteria, $collection);

        /** @var \Sokoley\Quiz\Api\Data\QuestionVariantSearchResultsInterface $searchResults */
        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($criteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }
}
