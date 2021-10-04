<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\Result\Product;

use Magento\Framework\Serialize\SerializerInterface;
use Sokoley\Quiz\Api\Data\ResultGridProductInterface;
use Sokoley\Quiz\Api\Data\ResultGridProductInterfaceFactory;
use Sokoley\Quiz\Api\Data\ResultInterface;

class GridProductManager
{
    /**
     * @var ResultGridProductInterfaceFactory
     */
    private $gridProductFactory;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    public function __construct(
        ResultGridProductInterfaceFactory $gridProductFactory,
        SerializerInterface $serializer
    ) {
        $this->gridProductFactory = $gridProductFactory;
        $this->serializer = $serializer;
    }

    public function extractGridProducts(ResultInterface $result): array
    {
        $products = $this->gridProductFactory->create();
        $this->sortProducts($products);

        return $products;
    }

    public function sortProducts(array &$products): void
    {
        usort($products, function (ResultGridProductInterface $a, ResultGridProductInterface $b) {
            return $a->getPosition() <=> $b->getPosition();
        });
    }
}
