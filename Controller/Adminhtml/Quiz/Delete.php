<?php
/**
 * @author Sokoley
 * @copyright 2021 Sokoley
 * @package Sokoley
 */
namespace Sokoley\Quiz\Controller\Adminhtml\Quiz;

class Delete extends \Sokoley\Quiz\Controller\Adminhtml\Quiz
{
    /**
     * Delete Quiz action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $entityId = $this->getRequest()->getParam('id');
        if (!$entityId) {
            $this->messageManager->addErrorMessage(__('We can not find a Quiz to delete.'));

            return $resultRedirect->setPath('*/*/');
        }

        try {
            $this->repository->deleteById($entityId);
            $this->messageManager->addSuccessMessage(__('You deleted the Quiz'));

            return $resultRedirect->setPath('*/*/');
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }

        return $resultRedirect->setPath('*/*/edit', ['id' => $entityId]);
    }
}
