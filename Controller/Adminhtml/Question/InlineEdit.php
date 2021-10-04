<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml\Question;

class InlineEdit extends \Sokoley\Quiz\Controller\Adminhtml\Question
{
    /** @var \Magento\Framework\Controller\Result\JsonFactory */
    private $jsonFactory;

    /**
     * @param \Magento\Framework\Controller\Result\JsonFactory $jsonFactory
     * @param \Sokoley\Quiz\Api\QuestionRepositoryInterface $repository
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\App\Action\Context $context
     */
    public function __construct(
        \Magento\Framework\Controller\Result\JsonFactory $jsonFactory,
        \Sokoley\Quiz\Api\QuestionRepositoryInterface $repository,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Backend\App\Action\Context $context
    ) {
        $this->jsonFactory = $jsonFactory;
        parent::__construct($repository, $coreRegistry, $context);
    }

    /**
     * Execute action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        $postItems = $this->getRequest()->getParam('items', []);
        if (!($this->getRequest()->getParam('isAjax') && count($postItems))) {
            return $resultJson->setData([
                'messages' => [__('Please correct the data sent.')],
                'error' => true,
            ]);
        }
        foreach (array_keys($postItems) as $id) {
            try {
                $entity = $this->repository->getById($id);
                $entity->setData(array_merge($entity->getData(), $postItems[$id]));
                $this->repository->save($entity);
            } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
                $messages[] = $id . ' -> ' . __('Not found');
                $error = true;
                continue;
            } catch (\Exception $e) {
                $messages[] = __($e->getMessage());
                $error = true;
                continue;
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error,
        ]);
    }
}
