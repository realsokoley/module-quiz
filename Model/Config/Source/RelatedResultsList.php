<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\Config\Source;

use Sokoley\Quiz\Model\ResourceModel\Result\CollectionFactory as ResultCollectionFactory;

class RelatedResultsList implements \Magento\Framework\Data\OptionSourceInterface
{
    /**
     * @var ResultCollectionFactory
     */
    private $resultCollectionFactory;

    /**
     * @var array
     */
    private $options = [];

    public function __construct(
        ResultCollectionFactory $resultCollectionFactory
    ) {
        $this->resultCollectionFactory = $resultCollectionFactory;
    }

    public function toOptionArray()
    {
        if (!empty($this->options)) {
            return $this->options;
        }
        $collection = $this->resultCollectionFactory->create();
        foreach ($collection as $result) {
            $this->options[] = [
                'value' => $result->getId(),
                'label' => $result->getTitle() . ' (ID:' . $result->getId() . ')',
            ];
        }

        return $this->options;
    }
}
