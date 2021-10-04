<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Api\Data;

interface QuestionVariantInterface extends \Magento\Framework\DataObject\IdentityInterface
{
    const CACHE_TAG = 'qui_q';
    const ID = 'id';
    const QUIZ_QUESTION_ID = 'quiz_question_id';
    const TITLE = 'title';
    const DESCRIPTION = 'description';
    const IMAGE = 'image';
    const RELATED_RESULTS = 'related_results';
    const POSITION = 'position';
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
     * Get quiz question id
     * @return int|null
     */
    public function getQuizQuestionId();

    /**
     * Set quiz question id
     * @param int $quizQuestionId
     * @return $this
     */
    public function setQuizQuestionId($quizQuestionId);

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
     * Get image
     * @return string|null
     */
    public function getImage();

    /**
     * Set image
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * Get related results
     * @return string|null
     */
    public function getRelatedResults();

    /**
     * Set related results
     * @param string $relatedResults
     * @return $this
     */
    public function setRelatedResults($relatedResults);

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
