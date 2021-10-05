<?php

namespace Sokoley\Quiz\Helper;

use Magento\Framework\App\ObjectManager;
use Sokoley\Quiz\Helper\ImageAttributeHelper\FileInfo;
use Sokoley\Quiz\Model\ImageUploader;
use Psr\Log\LoggerInterface;

class ImageHelper
{
    /**
     * @var
     */
    private $fileInfo;

    /**
     * @var ImageUploader
     */
    private $imageUploader;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        ImageUploader $imageUploader,
        LoggerInterface $logger
    ) {
        $this->imageUploader = $imageUploader;
        $this->logger = $logger;
    }

    public function deleteImage($mediaPath, $imageFile)
    {
        $this->imageUploader->setMediaPath($mediaPath);
        $imagePath = $this->imageUploader->getBasePath() . DIRECTORY_SEPARATOR . $imageFile;

        if (file_exists($imagePath)) {
            unlink($imagePath);
        }
    }

    public function uploadImage($mediaPath, array $data, $fieldName)
    {
        if (!isset($data[$fieldName])) {
            return '';
        }

        $imageData = $data[$fieldName];
        $imageName = $this->getUploadedImageName($imageData);
        if (!$imageName) {
            return '';
        }

        if ($this->isTmpFileAvailable($imageData)) {
            try {
                $this->imageUploader->setMediaPath($mediaPath . DIRECTORY_SEPARATOR . $fieldName);
                $this->imageUploader->setBaseTmpPath($this->imageUploader::DEFAULT_BASE_TMP_PATH);
                $this->imageUploader->setBasePath($this->imageUploader::DEFAULT_BASE_PATH);

                return $this->imageUploader->moveFileFromTmp($imageName);
            } catch (\Exception $e) {
                $this->logger->critical($e);
            }
        }

        return $imageName;
    }

    public function getImageData($mediaPath, $data, $fieldName)
    {
        if (!isset($data[$fieldName])) {
            return null;
        }

        $imageFile = $data[$fieldName];
        if (!$imageFile) {
            return null;
        }

        /** @var FileInfo $fileInfo */
        $fileInfo = $this->getFileInfo();
        $fileInfo->setMediaPath($mediaPath . DIRECTORY_SEPARATOR . $fieldName);
        if (!$fileInfo->isExist($imageFile)) {
            return null;
        }

        $stat = $fileInfo->getStat($imageFile);
        $mime = $fileInfo->getMimeType($imageFile);

        $imageData[0]['name'] = $imageFile;
        $imageData[0]['url'] = $fileInfo->getImageUrl($imageFile);
        $imageData[0]['size'] = isset($stat) ? $stat['size'] : 0;
        $imageData[0]['type'] = $mime;

        return $imageData;
    }

    public function getImageUrl($mediaPath, $data, $fieldName)
    {
        if (!isset($data[$fieldName])) {
            return null;
        }

        $imageFile = $data[$fieldName];
        if (!$imageFile) {
            return null;
        }

        /** @var FileInfo $fileInfo */
        $fileInfo = $this->getFileInfo();
        $fileInfo->setMediaPath($mediaPath . DIRECTORY_SEPARATOR . $fieldName);
        if (!$fileInfo->isExist($imageFile)) {
            return null;
        }

        return $fileInfo->getImageUrl($imageFile);
    }

    private function isTmpFileAvailable(array $imageData)
    {
        return is_array($imageData) && isset($imageData[0]['tmp_name']);
    }

    private function getUploadedImageName($imageData)
    {
        if (is_array($imageData) && isset($imageData[0]['name'])) {
            return $imageData[0]['name'];
        }

        return '';
    }

    private function getFileInfo()
    {
        if ($this->fileInfo === null) {
            $this->fileInfo = ObjectManager::getInstance()->get(FileInfo::class);
        }

        return $this->fileInfo;
    }
}
