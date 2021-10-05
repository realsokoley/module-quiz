<?php

namespace Sokoley\Quiz\Controller\Adminhtml\Image;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Sokoley\Quiz\Model\ImageUploader;

class Upload extends \Magento\Backend\App\Action
{
    const ATTRIBUTE_NAME = 'attribute_name';
    const MEDIA_PATH = 'media_path';

    /**
     * @var ImageUploader
     */
    protected $imageUploader;

    /**
     * Upload constructor.
     *
     * @param Context $context
     * @param ImageUploader $imageUploader
     */
    public function __construct(
        Context $context,
        ImageUploader $imageUploader
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
    }

    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam(self::ATTRIBUTE_NAME, 'image');
        $mediaPath = $this->getRequest()->getParam(self::MEDIA_PATH);

        try {
            $this->imageUploader->setMediaPath($mediaPath);
            $this->imageUploader->setBaseTmpPath($this->imageUploader::DEFAULT_BASE_TMP_PATH);
            $this->imageUploader->setBasePath($this->imageUploader::DEFAULT_BASE_PATH);
            $result = $this->imageUploader->saveFileToTmpDir($imageId);
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }

        return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}