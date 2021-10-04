<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\Config\Source;

use Sokoley\Quiz\Model\ResourceModel\Quiz\CollectionFactory;

class QuizList implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var CollectionFactory
     */
    private $quizCollectionFactory;

    /**
     * @var array
     */
    private $options = [];

    public function __construct(
        CollectionFactory $quizCollectionFactory
    ) {
        $this->quizCollectionFactory = $quizCollectionFactory;
    }

    public function toOptionArray()
    {
        if (!empty($this->options)) {
            return $this->options;
        }
        $collection = $this->quizCollectionFactory->create();
        $this->options = $collection->toOptionArray();

        return $this->options;
    }
}
