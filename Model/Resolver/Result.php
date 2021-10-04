<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\Resolver;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Exception\GraphQlNoSuchEntityException;
use Magento\Framework\GraphQl\Query\ResolverInterface;
use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\Serialize\Serializer\Json;
use Sokoley\Quiz\Api\ResultRepositoryInterface;

class Result implements ResolverInterface
{
    /**
     * @var ResultRepositoryInterface
     */
    private $resultRepository;

    /**
     * @var Json
     */
    private $json;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * Test constructor.
     * @param ResultRepositoryInterface $resultRepository
     * @param Json $json
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        ResultRepositoryInterface $resultRepository,
        Json $json,
        ProductRepositoryInterface $productRepository
    ) {
        $this->resultRepository = $resultRepository;
        $this->json = $json;
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
        $resultId = $this->getResultId($args);

        try {
            $result = $this->resultRepository->getById($resultId);
        } catch (NoSuchEntityException $e) {
            throw new GraphQlNoSuchEntityException(__('Result with selected id doesnt exist'));
        }
        $resultData['id'] = $resultId;
        $resultData['title'] = $result->getTitle();
        $resultData['description'] = $result->getDescription();
        $productData = $this->json->unserialize($result->getRelatedProducts());
        $relatedProducts = [];
        if (empty($productData)) {
            return [];
        }

        foreach ($productData as $resultProduct) {
            if (!isset($resultProduct['sku'])) {
                throw new GraphQlNoSuchEntityException(__('Product data filling exception'));
            }

            try {
                $relatedProducts[] = $this->productRepository->get($resultProduct['sku'])->getData();
            } catch (NoSuchEntityException $e) {
                throw new GraphQlNoSuchEntityException(__('Product with sku %1 doesnt exist', $resultProduct['sku']));
            }
        }
        $resultData['products'] = $relatedProducts;

        return  $resultData;
    }

    /**
     * @param array $args
     * @throws GraphQlInputException
     * @return string
     */
    private function getResultId(array $args): string
    {
        if (!isset($args['id'])) {
            throw new GraphQlInputException(__('"Result id should be specified'));
        }

        return (string) $args['id'];
    }
}
