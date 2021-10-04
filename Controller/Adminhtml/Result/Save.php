<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml\Result;

use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Serialize\Serializer\Json;
use Sokoley\Quiz\Ui\DataProvider\Result\Form\DataProvider;
use Sokoley\Quiz\Ui\DataProvider\Result\Form\Modifier\ProductGrid;

class Save extends \Sokoley\Quiz\Controller\Adminhtml\Result
{
    /** @var \Magento\Framework\App\Request\DataPersistorInterface */
    private $dataPersistor;

    /** @var \Sokoley\Quiz\Api\Data\ResultInterfaceFactory */
    private $entityFactory;

    /**
     * @var Json
     */
    private $json;

    /**
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Sokoley\Quiz\Api\Data\ResultInterfaceFactory $entityFactory
     * @param \Sokoley\Quiz\Api\ResultRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Sokoley\Quiz\Api\Data\ResultInterfaceFactory $entityFactory,
        Json $json,
        \Sokoley\Quiz\Api\ResultRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->entityFactory = $entityFactory;
        $this->json = $json;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Save Result action
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
        if (isset($data['links'][ProductGrid::FIELDSET])) {
            $data[DataProvider::RELATED_PRODUCTS] = $this->json->serialize($data['links'][ProductGrid::FIELDSET]);
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
                        ->addErrorMessage(__('This Result no longer exists'));

                    return $resultRedirect->setPath('*/*/');
                }
            }
        }
        if (empty($data['id'])) {
            $data['id'] = null;
        }
        $entity->setData($data);

        try {
            $this->repository->save($entity);
            $this->messageManager->addSuccessMessage(__('You saved the Result'));
            $this->dataPersistor->clear('sokoley_quiz_result');
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $entity->getId()]);
            }

            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Result'));
        }
        $this->dataPersistor->set('sokoley_quiz_result', $data);

        return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
    }
}
