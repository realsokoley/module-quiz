<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\ResourceModel\Question;

class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    /** @var string */
    protected $_idFieldName = 'id';

    /**
     * Define resource model
     */
    protected function _construct()
    {
        $this->_init(
            \Sokoley\Quiz\Model\Question::class,
            \Sokoley\Quiz\Model\ResourceModel\Question::class
        );
    }
}
