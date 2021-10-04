<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api\Data;

interface ResultInterface extends \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'qui_r';
    const ID = 'id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const RELATED_PRODUCTS = 'related_products';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const
        CONDITION_TYPE = 'conditions',
        GRID_TYPE = 'grid';

    /**
     * Get id
     * @return int|null
     */
    public function getId();

    /**
     * Set id
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * Get title
     * @return string|null
     */
    public function getTitle();

    /**
     * Set title
     * @param string $title
     * @return $this
     */
    public function setTitle($title);

    /**
     * Get description
     * @return string|null
     */
    public function getDescription();

    /**
     * Set description
     * @param string $description
     * @return $this
     */
    public function setDescription($description);

    /**
     * Get related products
     * @return string|null
     */
    public function getRelatedProducts();

    /**
     * Set related products
     * @param string $relatedProducts
     * @return $this
     */
    public function setRelatedProducts($relatedProducts);

    /**
     * Get created at
     * @return string|null
     */
    public function getCreatedAt();

    /**
     * Set created at
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * Get updated at
     * @return string|null
     */
    public function getUpdatedAt();

    /**
     * Set updated at
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
