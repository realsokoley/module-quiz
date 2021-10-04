<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api\Data;

interface QuestionInterface extends \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'qui_q';
    const ID = 'id';
    const QUIZ_ID = 'quiz_id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const TYPE_VIEW = 'type_view';
    const POSITION = 'position';
    const WEIGHT = 'weight';
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

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
     * Get quiz id
     * @return int|null
     */
    public function getQuizId();

    /**
     * Set quiz id
     * @param int $quizId
     * @return $this
     */
    public function setQuizId($quizId);

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
     * Get type view
     * @return int|null
     */
    public function getTypeView();

    /**
     * Set type view
     * @param int $typeView
     * @return $this
     */
    public function setTypeView($typeView);

    /**
     * Get position
     * @return int|null
     */
    public function getPosition();

    /**
     * Set position
     * @param int $position
     * @return $this
     */
    public function setPosition($position);

    /**
     * Get weight
     * @return int|null
     */
    public function getWeight();

    /**
     * Set weight
     * @param int $weight
     * @return $this
     */
    public function setWeight($weight);

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
