<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api\Data;

/**
 * @api
 */
interface ResultGridProductInterface extends \JsonSerializable
{
    const
        ID = 'id',
        POSITION = 'position',
        GROUP = 'group';

    public function getId(): int;

    public function getPosition(): string;

    public function getGroup(): string;
}
