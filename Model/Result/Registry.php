<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\Result;

use Sokoley\Quiz\Api\Data\ResultInterface;
use Sokoley\Quiz\Api\ResultRegistryInterface;

class Registry implements ResultRegistryInterface
{
    /**
     * @var ResultInterface|null
     */
    private $result = null;

    public function get(): ?ResultInterface
    {
        return $this->result;
    }

    public function set(ResultInterface $result): ResultRegistryInterface
    {
        $this->result = $result;

        return $this;
    }
}
