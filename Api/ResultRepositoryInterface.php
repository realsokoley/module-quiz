<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api;

interface ResultRepositoryInterface
{
    /**
     * Save Result
     * @param \Sokoley\Quiz\Api\Data\ResultInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\ResultInterface
     */
    public function save(Data\ResultInterface $entity);

    /**
     * Retrieve Result
     * @param int $entityId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\ResultInterface
     */
    public function getById($entityId);

    /**
     * Retrieve Result entities matching the specified criteria
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return \Sokoley\Quiz\Api\Data\ResultSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);

    /**
     * Delete Result
     * @param \Sokoley\Quiz\Api\Data\ResultInterface $entity
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function delete(Data\ResultInterface $entity);

    /**
     * Delete Result
     * @param int $entityId
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return bool true on success
     */
    public function deleteById($entityId);
}
