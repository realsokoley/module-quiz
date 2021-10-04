<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\Config\Source;

class QuestionTypeViewList implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var array
     */
    private $possibleTypes;

    public function __construct(
        array $possibleTypes
    ) {
        $this->possibleTypes = $possibleTypes;
    }

    public function toOptionArray()
    {
        if (!empty($this->options)) {
            return $this->options;
        }
        foreach ($this->possibleTypes as $key => $value) {
            $this->options[] = [
                'value' => $key,
                'label' => $value,
            ];
        }

        return $this->options;
    }
}
