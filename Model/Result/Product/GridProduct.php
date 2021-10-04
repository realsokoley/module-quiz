<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\Result\Product;

use Magento\Framework\Api\AbstractSimpleObject;
use Sokoley\Quiz\Api\Data\ResultGridProductInterface;

class GridProduct extends AbstractSimpleObject implements ResultGridProductInterface
{
    public function getId(): int
    {
        return $this->_get(self::ID);
    }

    public function getPosition(): string
    {
        return $this->_get(self::POSITION);
    }

    public function getGroup(): string
    {
        return $this->_get(self::GROUP);
    }

    public function jsonSerialize()
    {
        return $this->__toArray();
    }
}
