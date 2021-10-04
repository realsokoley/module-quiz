<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml\Question;

use Magento\Framework\Exception\LocalizedException;

class Save extends \Sokoley\Quiz\Controller\Adminhtml\Question
{
    /** @var \Magento\Framework\App\Request\DataPersistorInterface */
    private $dataPersistor;

    /** @var \Sokoley\Quiz\Api\Data\QuestionInterfaceFactory */
    private $entityFactory;

    /**
     * @param \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor
     * @param \Sokoley\Quiz\Api\Data\QuestionInterfaceFactory $entityFactory
     * @param \Sokoley\Quiz\Api\QuestionRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\App\Request\DataPersistorInterface $dataPersistor,
        \Sokoley\Quiz\Api\Data\QuestionInterfaceFactory $entityFactory,
        \Sokoley\Quiz\Api\QuestionRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->entityFactory = $entityFactory;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Save Question action
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
        $entityId = $this->getRequest()->getParam('id');
        $entity = $this->entityFactory->create();
        if ($entityId) {
            try {
                $entity = $this->repository->getById($entityId);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                if (!$entity->getId() && $entityId) {
                    $this
                        ->messageManager
                        ->addErrorMessage(__('This Question no longer exists'));

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
            $this->messageManager->addSuccessMessage(__('You saved the Question'));
            $this->dataPersistor->clear('sokoley_quiz_question');
            if ($this->getRequest()->getParam('back')) {
                return $resultRedirect->setPath('*/*/edit', ['id' => $entity->getId()]);
            }

            return $resultRedirect->setPath('*/*/');
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the Question'));
        }
        $this->dataPersistor->set('sokoley_quiz_question', $data);

        return $resultRedirect->setPath('*/*/edit', ['id' => $this->getRequest()->getParam('id')]);
    }
}
