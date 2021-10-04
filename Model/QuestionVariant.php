<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model;

use Magento\Framework\Model\AbstractModel;

class QuestionVariant extends AbstractModel implements \Sokoley\Quiz\Api\Data\QuestionVariantInterface
{
    /** @inheritDoc */
    protected $_eventPrefix = 'sokoley_quiz_question_variant';

    /**
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get id
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::ID);
    }

    /**
     * Set id
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * Get quiz question id
     * @return int|null
     */
    public function getQuizQuestionId()
    {
        return $this->getData(self::QUIZ_QUESTION_ID);
    }

    /**
     * Set quiz question id
     * @param int $quizQuestionId
     * @return $this
     */
    public function setQuizQuestionId($quizQuestionId)
    {
        return $this->setData(self::QUIZ_QUESTION_ID, $quizQuestionId);
    }

    /**
     * Get title
     * @return string|null
     */
    public function getTitle()
    {
        return $this->getData(self::TITLE);
    }

    /**
     * Set title
     * @param string $title
     * @return $this
     */
    public function setTitle($title)
    {
        return $this->setData(self::TITLE, $title);
    }

    /**
     * Get description
     * @return string|null
     */
    public function getDescription()
    {
        return $this->getData(self::DESCRIPTION);
    }

    /**
     * Set description
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        return $this->setData(self::DESCRIPTION, $description);
    }

    /**
     * Get image
     * @return string|null
     */
    public function getImage()
    {
        return $this->getData(self::IMAGE);
    }

    /**
     * Set image
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * Get related results
     * @return string|null
     */
    public function getRelatedResults()
    {
        return $this->getData(self::RELATED_RESULTS);
    }

    /**
     * Set related results
     * @param string $relatedResults
     * @return $this
     */
    public function setRelatedResults($relatedResults)
    {
        return $this->setData(self::RELATED_RESULTS, $relatedResults);
    }

    /**
     * Get position
     * @return int|null
     */
    public function getPosition()
    {
        return $this->getData(self::POSITION);
    }

    /**
     * Set position
     * @param int $position
     * @return $this
     */
    public function setPosition($position)
    {
        return $this->setData(self::POSITION, $position);
    }

    /**
     * Get created at
     * @return string|null
     */
    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    /**
     * Set created at
     * @param string $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    /**
     * Get updated at
     * @return string|null
     */
    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    /**
     * Set updated at
     * @param string $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init(\Sokoley\Quiz\Model\ResourceModel\QuestionVariant::class);
    }
}
