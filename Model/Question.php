<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model;

use Magento\Framework\Model\AbstractModel;

class Question extends AbstractModel implements \Sokoley\Quiz\Api\Data\QuestionInterface
{
    /** @inheritDoc */
    protected $_eventPrefix = 'sokoley_quiz_question';

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
     * Get quiz id
     * @return int|null
     */
    public function getQuizId()
    {
        return $this->getData(self::QUIZ_ID);
    }

    /**
     * Set quiz id
     * @param int $quizId
     * @return $this
     */
    public function setQuizId($quizId)
    {
        return $this->setData(self::QUIZ_ID, $quizId);
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
     * Get type view
     * @return int|null
     */
    public function getTypeView()
    {
        return $this->getData(self::TYPE_VIEW);
    }

    /**
     * Set type view
     * @param int $typeView
     * @return $this
     */
    public function setTypeView($typeView)
    {
        return $this->setData(self::TYPE_VIEW, $typeView);
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
     * Get weight
     * @return int|null
     */
    public function getWeight()
    {
        return $this->getData(self::WEIGHT);
    }

    /**
     * Set weight
     * @param int $weight
     * @return $this
     */
    public function setWeight($weight)
    {
        return $this->setData(self::WEIGHT, $weight);
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
        $this->_init(\Sokoley\Quiz\Model\ResourceModel\Question::class);
    }
}
