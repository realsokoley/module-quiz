<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Model\QuestionVariant;

use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Store\Model\StoreManagerInterface;
use Sokoley\Quiz\Model\ResourceModel\QuestionVariant\CollectionFactory;
use Sokoley\Ui\Helper\ImageHelper;

class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    const MEDIA_PATH = 'quiz';

    const RELATED_RESULTS = 'related_results';

    /** @var \Sokoley\Quiz\Model\ResourceModel\QuestionVariant\Collection */
    protected $collection;

    /** @var DataPersistorInterface */
    protected $dataPersistor;

    /** @var array */
    protected $loadedData;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ImageHelper
     */
    private $imageHelper;

    /**
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param StoreManagerInterface $storeManager
     * @param ImageHelper $imageHelper
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        StoreManagerInterface $storeManager,
        ImageHelper $imageHelper,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->storeManager = $storeManager;
        $this->imageHelper = $imageHelper;
    }

    /**
     * @param string $path
     * @return string
     */
    public function getMediaUrl($path)
    {
        $store = $this->storeManager->getStore();
        $media_dir = $store->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);

        return $media_dir . $path;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        foreach ($items as $model) {
            if ($model->getData(self::RELATED_RESULTS)) {
                $model->setData(self::RELATED_RESULTS, explode(',', $model->getData(self::RELATED_RESULTS)));
            }
            $this->loadedData[$model->getId()] = $this->prepareModelData($model->getData());
        }
        $data = $this->dataPersistor->get('sokoley_quiz_questionvariant');
        if (!empty($data)) {
            $model = $this->collection->getNewEmptyItem();
            $model->setData($data);
            $this->loadedData[$model->getId()] = $model->getData();
            $this->dataPersistor->clear('sokoley_quiz_questionvariant');
        }

        return $this->loadedData;
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareModelData(array $data)
    {
        return $this->prepareImage($data, 'image');
    }

    /**
     * @param array $data
     * @param $fieldName
     * @return array
     */
    private function prepareImage(array $data, $fieldName)
    {
        if (!isset($data[$fieldName])) {
            return $data;
        }

        $data[$fieldName] = $this->imageHelper->getImageData(self::MEDIA_PATH, $data, $fieldName);

        return $data;
    }
}
