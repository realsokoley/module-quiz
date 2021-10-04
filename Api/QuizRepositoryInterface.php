<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api;

interface QuizRepositoryInterface
{
    /**
     * Save Quiz
     * @param \Sokoley\Quiz\Api\Data\QuizInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\QuizInterface
     */
    public function save(Data\QuizInterface $entity);

    /**
     * Retrieve Quiz
     * @param int $entityId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\QuizInterface
     */
    public function getById($entityId);

    /**
     * Retrieve Quiz entities matching the specified criteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\QuizSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Quiz
     * @param \Sokoley\Quiz\Api\Data\QuizInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function delete(Data\QuizInterface $entity);

    /**
     * Delete Quiz
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function deleteById($entityId);
}
