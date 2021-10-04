<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml\QuestionVariant;

use Magento\Framework\Exception\LocalizedException;
use Sokoley\Quiz\Model\QuestionVariant\DataProvider;
use Sokoley\Ui\Helper\ImageHelper;

class Save extends \Sokoley\Quiz\Controller\Adminhtml\QuestionVariant
{
    /**
     * @var ImageHelper
     */
    private $imageHelper;

    /** @var \Magento\Framework\App\Request\DataPersistorInterface */
    private $dataPersistor;

    /** @var \Sokoley\Quiz\Api\Data\QuestionVariantInterfaceFactory */
    private $entityFactory;

    /**
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Sokoley\Quiz\Api\Data\QuestionVariantInterfaceFactory $entityFactory
     * @param \Sokoley\Quiz\Api\QuestionVariantRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Sokoley\Quiz\Api\Data\QuestionVariantInterfaceFactory $entityFactory,
        ImageHelper $imageHelper,
        \Sokoley\Quiz\Api\QuestionVariantRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->entityFactory = $entityFactory;
        $this->imageHelper = $imageHelper;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Save QuestionVariant action
     *
     * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if (!$data) {
            return $resultRedirect->setPath('*/*/');
        }
        if (isset($data[DataProvider::RELATED_RESULTS]) && is_array($data[DataProvider::RELATED_RESULTS])) {
            $data[DataProvider::RELATED_RESULTS] = implode(',', $data[DataProvider::RELATED_RESULTS]);
        }
        $entityId = $this->getRequest()->getParam('id');
        $entity = $this->entityFactory->create();
        if ($entityId) {
            try {
                $entity = $this->repository->getById($entityId);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                if (!$entity->getId() && $entityId) {
                    $this
                        ->messageManager
                        ->addErrorMessage(__('This Question Variant no longer exists'));

                    return $resultRedirect->setPath('*/*/');
                }
            }
        }
        if (empty($data['id'])) {
            $data['id'] = null;
        }

        $data = $this->uploadImage($data, 'image');
        $entity->setData($data);

        try {
            $this->repository->save($entity);
            $this->messageManager->addSuccessMessage(__('You saved the Question Variant'));
            $this->dataPersistor->clear('sokoley_quiz_questionvariant');
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $entity->getId()]);
            }

            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Question Variant'));
        }
        $this->dataPersistor->set('sokoley_quiz_questionvariant', $data);

        return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
    }

    /**
     * @param array $data
     * @param $fieldName
     * @return array
     */
    protected function uploadImage(array $data, $fieldName)
    {
        $data[$fieldName] = $this->imageHelper->uploadImage(DataProvider::MEDIA_PATH, $data, $fieldName);

        return $data;
    }
}
