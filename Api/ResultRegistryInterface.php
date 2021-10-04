<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api;

use Sokoley\Quiz\Api\Data\ResultInterface;

/**
 * @api
 */
interface ResultRegistryInterface
{
    /**
     * @return ResultInterface|null
     */
    public function get(): ?ResultInterface;

    /**
     * @param ResultInterface $result
     * @return ResultRegistryInterface
     */
    public function set(ResultInterface $result): ResultRegistryInterface;
}
