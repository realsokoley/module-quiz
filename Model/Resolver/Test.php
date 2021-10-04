<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\Resolver;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Serialize\Serializer\Json;
use Sokoley\Quiz\Api\Data\QuestionVariantInterface;
use Sokoley\Quiz\Api\QuestionRepositoryInterface;
use Sokoley\Quiz\Api\QuestionVariantRepositoryInterface;
use Sokoley\Quiz\Api\QuizRepositoryInterface;

class Test implements ResolverInterface
{
    /**
     * @var QuizRepositoryInterface
     */
    private $quizRepository;

    /**
     * @var QuestionRepositoryInterface
     */
    private $questionRepository;

    /**
     * @var QuestionVariantRepositoryInterface
     */
    private $variantRepository;

    /**
     * @var Json
     */
    private $json;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Test constructor.
     * @param QuizRepositoryInterface $quizRepository
     * @param QuestionRepositoryInterface $questionRepository
     * @param QuestionVariantRepositoryInterface $variantRepository
     * @param Json $json
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        QuizRepositoryInterface $quizRepository,
        QuestionRepositoryInterface $questionRepository,
        QuestionVariantRepositoryInterface $variantRepository,
        Json $json,
        SearchCriteriaBuilder $searchCriteriaBuilder,
        SortOrderBuilder $sortOrderBuilder,
        ProductRepositoryInterface $productRepository
    ) {
        $this->quizRepository = $quizRepository;
        $this->questionRepository = $questionRepository;
        $this->variantRepository = $variantRepository;
        $this->json = $json;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
        $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        $quizId = $this->getTestId($args);

        try {
            $quiz = $this->quizRepository->getById($quizId);
        } catch (NoSuchEntityException $e) {
            return [];
        }
        if (!$quiz->getIsActive()) {
            throw new GraphQlInputException(__('Selected test is not active'));
        }
        $quizData['id'] = $quizId;
        $quizData['name'] = $quiz->getName();
        $quizData['description'] = $quiz->getDescription();
        $quizData['questions'] = $this->getQuestions($quizId);

        return  $quizData;
    }

    /**
     * @param array $args
     * @throws GraphQlInputException
     * @return string
     */
    private function getTestId(array $args): string
    {
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('Test id should be specified'));
        }

        return (string) $args['id'];
    }

    /**
     * @param $quizId
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return array
     */
    private function getQuestions($quizId)
    {
        $sortOrder = $this->sortOrderBuilder->setField('position')->setDirection('ASC')->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('quiz_id', $quizId, 'eq')
            ->setSortOrders([$sortOrder])
            ->create();
        $questions = $this->questionRepository->getList($searchCriteria)->getItems();
        if (empty($questions)) {
            return [];
        }
        $questionResolver = [];

        foreach ($questions as $question) {
            $weight = $question->getWeight();
            $questionData['id'] = $question->getId();
            $questionData['title'] = $question->getTitle();
            $questionData['position'] = $question->getPosition();
            $questionData['type'] = $question->getTypeView();
            $questionData['position'] = $question->getPosition();
            $questionData['variants'] = $this->getVariants($questionData['id'], $weight);
            $questionResolver[] = $questionData;
        }

        return $questionResolver;
    }

    /**
     * @param $questionId
     * @param $weight
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return array
     */
    private function getVariants($questionId, $weight)
    {
        $sortOrder = $this->sortOrderBuilder->setField('position')->setDirection('ASC')->create();
        $searchCriteria = $this->searchCriteriaBuilder
            ->addFilter('quiz_question_id', $questionId, 'eq')
            ->setSortOrders([$sortOrder])
            ->create();
        $variants = $this->variantRepository->getList($searchCriteria)->getItems();
        if (empty($variants)) {
            return [];
        }

        foreach ($variants as $variant) {
            $variantData['id'] = $variant->getId();
            $variantData['title'] = $variant->getTitle();
            $variantData['description'] = $variant->getDescription();
            $variantData['image'] = $variant->getImage();
            $variantData['position'] = $variant->getPosition();
            $variantData['result_weight'] = $this->getResults($variant, $weight);
            $variantResolver[] = $variantData;
        }

        return $variantResolver;
    }

    /**
     * @param QuestionVariantInterface $variant
     * @param mixed $weight
     * @return array
     */
    private function getResults($variant, $weight)
    {
        $results = $variant->getRelatedResults();
        if ($results == '') {
            return [];
        }

        $results = explode(',', $results);
        $resultResolver = [];

        foreach ($results as $resultId) {
            $resultData['result_id'] = $resultId;
            $resultData['weight'] = $weight;
            $resultResolver[] = $resultData;
        }

        return $resultResolver;
    }
}
