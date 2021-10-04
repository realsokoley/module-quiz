<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api;

interface QuestionVariantRepositoryInterface
{
    /**
     * Save QuestionVariant
     * @param \Sokoley\Quiz\Api\Data\QuestionVariantInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\QuestionVariantInterface
     */
    public function save(Data\QuestionVariantInterface $entity);

    /**
     * Retrieve QuestionVariant
     * @param int $entityId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\QuestionVariantInterface
     */
    public function getById($entityId);

    /**
     * Retrieve QuestionVariant entities matching the specified criteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\QuestionVariantSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete QuestionVariant
     * @param \Sokoley\Quiz\Api\Data\QuestionVariantInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function delete(Data\QuestionVariantInterface $entity);

    /**
     * Delete QuestionVariant
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function deleteById($entityId);
}
