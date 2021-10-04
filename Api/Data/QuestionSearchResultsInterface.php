<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api\Data;

interface QuestionSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get list of Question
     * @return \Sokoley\Quiz\Api\Data\QuestionInterface[]
     */
    public function getItems();

    /**
     * Set list of Question
     * @param \Sokoley\Quiz\Api\Data\QuestionInterface[] $items
     */
    public function setItems(array $items);
}
