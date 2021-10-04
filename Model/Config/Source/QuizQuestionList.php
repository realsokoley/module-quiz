<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\Config\Source;

use Sokoley\Quiz\Model\ResourceModel\Question\CollectionFactory as QuestionCollectionFactory;

class QuizQuestionList implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var QuestionCollectionFactory
     */
    private $questionCollectionFactory;

    /**
     * @var array
     */
    private $options = [];

    public function __construct(
        QuestionCollectionFactory $questionCollectionFactory
    ) {
        $this->questionCollectionFactory = $questionCollectionFactory;
    }

    public function toOptionArray()
    {
        if (!empty($this->options)) {
            return $this->options;
        }
        $collection = $this->questionCollectionFactory->create();
        foreach ($collection as $question) {
            $this->options[] = [
                'value' => $question->getId(),
                'label' => $question->getTitle() . ' (ID:' . $question->getId() . ')',
            ];
        }

        return $this->options;
    }
}
