<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Ui\DataProvider\Result\Form\Modifier;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Helper\Image as ImageHelper;
use Magento\Catalog\Model\Product\Attribute\Source\Status;
use Magento\Catalog\Ui\Component\Listing\Columns\Price as PriceColumns;
use Magento\Eav\Api\AttributeSetRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Phrase;
use Magento\Framework\UrlInterface;
use Magento\Ui\Component\DynamicRows;
use Magento\Ui\Component\Form\Element\DataType\Number;
use Magento\Ui\Component\Form\Element\DataType\Text;
use Magento\Ui\Component\Form\Element\Input;
use Magento\Ui\Component\Form\Field;
use Magento\Ui\Component\Form\Fieldset;
use Magento\Ui\Component\Modal;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Sokoley\Quiz\Api\Data\ResultGridProductInterface;
use Sokoley\Quiz\Api\Data\ResultInterface;
use Sokoley\Quiz\Api\ResultRegistryInterface;
use Sokoley\Quiz\Model\Result\Product\GridProductManager;
use Sokoley\Quiz\Ui\DataProvider\Result\Form\DataProvider;

class ProductGrid implements ModifierInterface
{
    const DATA_SCOPE = 'product_grid';
    const FIELDSET = 'product_grid';
    const SCOPE_NAME = DataProvider::FORM_NAME . '.' . DataProvider::FORM_NAME;
    const GRID_NAME = 'sokoley_quiz_result_product_grid';

    /**
     * @var ResultRegistryInterface
     */
    private $resultRegistry;

    /**
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var Status
     */
    private $status;

    /**
     * @var AttributeSetRepositoryInterface
     */
    private $attributeSetRepository;

    /**
     * @var ImageHelper
     */
    private $imageHelper;

    /**
     * @var PriceColumns
     */
    private $priceModifier;

    /**
     * @var GridProductManager
     */
    private $gridProductManager;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        ResultRegistryInterface $resultRegistry,
        UrlInterface $urlBuilder,
        Status $status,
        AttributeSetRepositoryInterface $attributeSetRepository,
        ImageHelper $imageHelper,
        PriceColumns $priceModifier,
        GridProductManager $gridProductManager,
        ProductRepositoryInterface $productRepository
    ) {
        $this->resultRegistry = $resultRegistry;
        $this->urlBuilder = $urlBuilder;
        $this->status = $status;
        $this->attributeSetRepository = $attributeSetRepository;
        $this->imageHelper = $imageHelper;
        $this->priceModifier = $priceModifier;
        $this->gridProductManager = $gridProductManager;
        $this->productRepository = $productRepository;
    }

    public function modifyData(array $data)
    {
        $result = $this->resultRegistry->get();
        if ($result && $result->getId()) {
            $data[$result->getId()]['links'][self::FIELDSET] = $this->getData($result);
        }

        return $data;
    }

    public function modifyMeta(array $meta)
    {
        return array_replace_recursive(
            $meta,
            $this->getMeta()
        );
    }

    /**
     * @param ResultInterface $result
     * @return array
     */
    protected function getData(ResultInterface $result)
    {
        $productsData = array_filter(
            array_map([$this, 'fillData'], $this->gridProductManager->extractGridProducts($result))
        );
        if (!empty($productsData)) {
            $this->priceModifier->setData('name', 'price');
            $dataMap = $this->priceModifier->prepareDataSource([
                'data' => [
                    'items' => $productsData,
                ],
            ]);
            $productsData = $dataMap['data']['items'];
        }

        return array_values($productsData);
    }

    protected function getMeta(): array
    {
        return [
            self::FIELDSET => [
                'children' => [
                    'button_set' => $this->getButton(
                        __('Add product')
                    ),
                    'modal' => $this->getModal(
                        __('Add product')
                    ),
                    self::DATA_SCOPE => $this->getGrid(),
                ],
                'arguments' => [
                    'data' => [
                        'config' => [
                            'additionalClasses' => 'admin__fieldset-section',
                            'label' => __('Products'),
                            'collapsible' => true,
                            'opened' => true,
                            'componentType' => Fieldset::NAME,
                            'dataScope' => '',
                            'sortOrder' => 30,
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getButton(Phrase $buttonTitle): array
    {
        $modalTarget = static::SCOPE_NAME . '.' . static::FIELDSET . '.modal';

        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'formElement' => 'container',
                        'componentType' => 'container',
                        'label' => false,
                        'template' => 'ui/form/components/complex',
                    ],
                ],
            ],
            'children' => [
                'button_add' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'formElement' => 'container',
                                'componentType' => 'container',
                                'component' => 'Magento_Ui/js/form/components/button',
                                'actions' => [
                                    [
                                        'targetName' => $modalTarget,
                                        'actionName' => 'toggleModal',
                                    ],
                                    [
                                        'targetName' => $modalTarget . '.' . self::GRID_NAME,
                                        'actionName' => 'render',
                                    ],
                                ],
                                'title' => $buttonTitle,
                                'provider' => null,
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getModal(Phrase $title): array
    {
        $providerPrefix = self::GRID_NAME . '.' . self::GRID_NAME;

        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Modal::NAME,
                        'dataScope' => '',
                        'options' => [
                            'title' => $title,
                            'buttons' => [
                                [
                                    'text' => __('Cancel'),
                                    'actions' => [
                                        'closeModal',
                                    ],
                                ],
                                [
                                    'text' => __('Add selected products'),
                                    'class' => 'action-primary',
                                    'actions' => [
                                        [
                                            'targetName' => 'index = ' . self::GRID_NAME,
                                            'actionName' => 'save',
                                        ],
                                        'closeModal',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],
            'children' => [
                self::GRID_NAME => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'autoRender' => false,
                                'componentType' => 'insertListing',
                                'dataScope' => self::GRID_NAME,
                                'externalProvider' => $providerPrefix . '_data_source',
                                'selectionsProvider' => $providerPrefix . '.sokoley_quiz_result_product_grid_columns.ids',
                                'ns' => self::GRID_NAME,
                                'render_url' => $this->urlBuilder->getUrl('mui/index/render'),
                                'realTimeLink' => true,
                                'dataLinks' => [
                                    'imports' => false,
                                    'exports' => true,
                                ],
                                'behaviourType' => 'simple',
                                'externalFilterMode' => true,
                                'imports' => [
                                    'productId' => '${ $.provider }:data.product.current_product_id',
                                    'storeId' => '${ $.provider }:data.product.current_store_id',
                                ],
                                'exports' => [
                                    'productId' => '${ $.externalProvider }:params.current_product_id',
                                    'storeId' => '${ $.externalProvider }:params.current_store_id',
                                ],
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getGrid(): array
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'additionalClasses' => 'admin__field-wide',
                        'componentType' => DynamicRows::NAME,
                        'dndConfig' => [
                            'enabled' => true,
                        ],
                        'label' => null,
                        'columnsHeader' => false,
                        'columnsHeaderAfterRender' => true,
                        'renderDefaultRecord' => true,
                        'template' => 'ui/dynamic-rows/templates/grid',
                        'component' => 'Magento_Ui/js/dynamic-rows/dynamic-rows-grid',
                        'addButton' => false,
                        'recordTemplate' => 'record',
                        'dataScope' => 'data.links',
                        'deleteButtonLabel' => __('Remove'),
                        'dataProvider' => self::GRID_NAME,
                        'map' => [
                            'id' => 'entity_id',
                            'name' => 'name',
                            'status' => 'status_text',
                            'attribute_set' => 'attribute_set_text',
                            'sku' => 'sku',
                            'price' => 'price',
                            'thumbnail' => 'thumbnail_src',
                        ],
                        'links' => [
                            'insertData' => 'sokoley_quiz_result_edit.sokoley_quiz_result_edit_data_source:' . self::GRID_NAME,
                        ],
                        'sortOrder' => 2,
                    ],
                ],
            ],
            'children' => [
                'record' => [
                    'arguments' => [
                        'data' => [
                            'config' => [
                                'componentType' => 'container',
                                'isTemplate' => true,
                                'is_collection' => true,
                                'component' => 'Magento_Ui/js/dynamic-rows/record',
                                'dataScope' => '',
                            ],
                        ],
                    ],
                    'children' => $this->fillMeta(),
                ],
            ],
        ];
    }

    protected function fillMeta(): array
    {
        return [
            'position' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'dataType' => Number::NAME,
                            'formElement' => Input::NAME,
                            'componentType' => Field::NAME,
                            'dataScope' => 'position',
                            'sortOrder' => 0,
                            'visible' => false,
                        ],
                    ],
                ],
            ],
            'id' => $this->getTextColumn('id', true, __('ID'), 0),
            'thumbnail' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'componentType' => Field::NAME,
                            'formElement' => Input::NAME,
                            'elementTmpl' => 'ui/dynamic-rows/cells/thumbnail',
                            'dataType' => Text::NAME,
                            'dataScope' => 'thumbnail',
                            'fit' => true,
                            'label' => __('Thumbnail'),
                            'sortOrder' => 10,
                        ],
                    ],
                ],
            ],
            'name' => $this->getTextColumn('name', false, __('Name'), 20),
            'status' => $this->getTextColumn('status', true, __('Status'), 30),
            'attribute_set' => $this->getTextColumn('attribute_set', false, __('Attribute Set'), 40),
            'sku' => $this->getTextColumn('sku', true, __('SKU'), 50),
            'price' => $this->getTextColumn('price', true, __('Price'), 60),
            'actionDelete' => [
                'arguments' => [
                    'data' => [
                        'config' => [
                            'additionalClasses' => 'data-grid-actions-cell',
                            'componentType' => 'actionDelete',
                            'dataType' => Text::NAME,
                            'label' => __('Actions'),
                            'sortOrder' => 80,
                            'fit' => true,
                        ],
                    ],
                ],
            ],
        ];
    }

    protected function getTextColumn(string $dataScope, bool $fit, Phrase $label, int $sortOrder): array
    {
        return [
            'arguments' => [
                'data' => [
                    'config' => [
                        'componentType' => Field::NAME,
                        'formElement' => Input::NAME,
                        'elementTmpl' => 'ui/dynamic-rows/cells/text',
                        'component' => 'Magento_Ui/js/form/element/text',
                        'dataType' => Text::NAME,
                        'dataScope' => $dataScope,
                        'fit' => $fit,
                        'label' => $label,
                        'sortOrder' => $sortOrder,
                    ],
                ],
            ],
        ];
    }

    protected function getDataScope(): string
    {
        return 'data.' . self::DATA_SCOPE . '.' . self::DATA_SCOPE;
    }

    private function fillData(ResultGridProductInterface $product): ?array
    {
        try {
            $catalogProduct = $this->productRepository->getById($product->getId());
        } catch (NoSuchEntityException $e) {
            return null;
        }

        return [
            'id' => $catalogProduct->getId(),
            'name' => $catalogProduct->getName(),
            'status' => $this->status->getOptionText($catalogProduct->getStatus()),
            'attribute_set' => $this->attributeSetRepository
                ->get($catalogProduct->getAttributeSetId())
                ->getAttributeSetName(),
            'sku' => $catalogProduct->getSku(),
            'price' => $catalogProduct->getPrice(),
            'thumbnail' => $this->imageHelper->init($catalogProduct, 'product_listing_thumbnail')->getUrl(),
            'position' => $product->getPosition(),
        ];
    }
}
