<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api\Data;

interface QuizSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get list of Quiz
     * @return \Sokoley\Quiz\Api\Data\QuizInterface[]
     */
    public function getItems();

    /**
     * Set list of Quiz
     * @param \Sokoley\Quiz\Api\Data\QuizInterface[] $items
     */
    public function setItems(array $items);
}
