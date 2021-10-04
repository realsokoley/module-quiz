<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api;

interface QuestionRepositoryInterface
{
    /**
     * Save Question
     * @param \Sokoley\Quiz\Api\Data\QuestionInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\QuestionInterface
     */
    public function save(Data\QuestionInterface $entity);

    /**
     * Retrieve Question
     * @param int $entityId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\QuestionInterface
     */
    public function getById($entityId);

    /**
     * Retrieve Question entities matching the specified criteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\QuestionSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Question
     * @param \Sokoley\Quiz\Api\Data\QuestionInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function delete(Data\QuestionInterface $entity);

    /**
     * Delete Question
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function deleteById($entityId);
}
