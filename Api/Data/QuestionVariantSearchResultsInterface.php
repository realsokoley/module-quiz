<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api\Data;

interface QuestionVariantSearchResultsInterface extends \Magento\Framework\Api\SearchResultsInterface
{
    /**
     * Get list of QuestionVariant
     * @return \Sokoley\Quiz\Api\Data\QuestionVariantInterface[]
     */
    public function getItems();

    /**
     * Set list of QuestionVariant
     * @param \Sokoley\Quiz\Api\Data\QuestionVariantInterface[] $items
     */
    public function setItems(array $items);
}
