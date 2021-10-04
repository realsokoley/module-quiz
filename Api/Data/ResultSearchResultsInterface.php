<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api\Data;

interface ResultSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get list of Result
     * @return \Sokoley\Quiz\Api\Data\ResultInterface[]
     */
    public function getItems();

    /**
     * Set list of Result
     * @param \Sokoley\Quiz\Api\Data\ResultInterface[] $items
     */
    public function setItems(array $items);
}
