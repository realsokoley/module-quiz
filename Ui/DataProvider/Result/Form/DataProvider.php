<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Ui\DataProvider\Result\Form;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Serialize\Serializer\Json;
use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Ui\DataProvider\Modifier\ModifierInterface;
use Magento\Ui\DataProvider\Modifier\PoolInterface;
use Sokoley\Quiz\Model\ResourceModel\Result\Collection;
use Sokoley\Quiz\Model\ResourceModel\Result\CollectionFactory;
use Sokoley\Quiz\Ui\DataProvider\Result\Form\Modifier\ProductGrid;

/**
 * @property Collection $collection
 */
class DataProvider extends AbstractDataProvider
{
    const FORM_NAME = 'sokoley_quiz_result_edit';

    const DATA_PERSISTOR_KEY = 'sokoley_quiz_result';

    const RELATED_PRODUCTS = 'related_products';

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var PoolInterface
     */
    protected $pool;

    /**
     * @var Json
     */
    private $json;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Json $json,
        PoolInterface $pool,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->json = $json;
        $this->pool = $pool;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get meta from all modifiers
     *
     * @return array
     */
    public function getMeta()
    {
        $meta = parent::getMeta();
        $modifiers = $this->pool->getModifiersInstances();
        /** @var ModifierInterface $modifier */
        foreach ($modifiers as $modifier) {
            $meta = $modifier->modifyMeta($meta);
        }

        return $meta;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            if ($model->getData(self::RELATED_PRODUCTS)) {
                $productGrid = $this->json->unserialize($model->getData(self::RELATED_PRODUCTS));
                $links[ProductGrid::FIELDSET] = $productGrid;
                $model->setData('links', $links);
            }
            $this->loadedData[$model->getId()] = $model->getData();
        }

        $data = $this->dataPersistor->get(self::DATA_PERSISTOR_KEY);
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear(self::DATA_PERSISTOR_KEY);
        }

        /** @var ModifierInterface $modifier */
        foreach ($this->pool->getModifiersInstances() as $modifier) {
            $this->loadedData = $modifier->modifyData($this->loadedData ?? []);
        }

        return $this->loadedData;
    }
}
