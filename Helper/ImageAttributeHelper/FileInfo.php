<?php

namespace Sokoley\Quiz\Helper\ImageAttributeHelper;

use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\File\Mime;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\WriteInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Sokoley\Quiz\Model\ImageUploader;

class FileInfo
{
    /**
     * @var string
     */
    protected $basePath = ImageUploader::DEFAULT_BASE_PATH;

    /**
     * @var string
     */
    protected $mediaPath;

    /**
     * Store manager
     *
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * @var Mime
     */
    private $mime;

    /**
     * @var WriteInterface
     */
    private $mediaDirectory;

    public function __construct(
        StoreManagerInterface $storeManager,
        Filesystem $filesystem,
        Mime $mime
    ) {
        $this->storeManager = $storeManager;
        $this->filesystem = $filesystem;
        $this->mime = $mime;
    }

    /**
     * @param $basePath
     * @return FileInfo
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;

        return $this;
    }

    /**
     * @param $mediaPath
     * @return FileInfo
     */
    public function setMediaPath($mediaPath)
    {
        $this->mediaPath = $mediaPath;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityMediaPath()
    {
        return $this->mediaPath;
    }

    /**
     * Retrieve MIME type of requested file
     *
     * @param string $fileName
     * @throws FileSystemException
     * @return string
     */
    public function getMimeType($fileName)
    {
        $filePath = $this->getImageFilePath($fileName);
        $absoluteFilePath = $this->getMediaDirectory()->getAbsolutePath($filePath);

        return $this->mime->getMimeType($absoluteFilePath);
    }

    /**
     * Get file statistics data
     *
     * @param string $fileName
     * @throws FileSystemException
     * @return array
     */
    public function getStat($fileName)
    {
        $filePath = $this->getImageFilePath($fileName);

        return $this->getMediaDirectory()->stat($filePath);
    }

    /**
     * Check if the file exists
     *
     * @param string $fileName
     * @throws FileSystemException
     * @return bool
     */
    public function isExist($fileName)
    {
        $filePath = $this->getImageFilePath($fileName);

        return $this->getMediaDirectory()->isExist($filePath);
    }

    /**
     * @param $fileName
     * @throws NoSuchEntityException
     * @return bool|string
     */
    public function getImageUrl($fileName)
    {
        $url = false;

        if ($fileName) {
            $filePath = $this->getImageFilePath($fileName);

            $url = $this->storeManager->getStore()->getBaseUrl(
                UrlInterface::URL_TYPE_MEDIA
            ) . $filePath;
        }

        return $url;
    }

    /**
     * @param $fileName
     * @throws FileSystemException
     * @return string
     */
    public function getImagePath($fileName)
    {
        $filePath = $this->getImageFilePath($fileName);

        return $this->getMediaDirectory()->getAbsolutePath($filePath);
    }

    /**
     * @param $fileName
     * @return string
     */
    public function getImageFilePath($fileName)
    {
        return $this->basePath
            . DIRECTORY_SEPARATOR
            . $this->mediaPath
            . DIRECTORY_SEPARATOR
            . ltrim($fileName, DIRECTORY_SEPARATOR);
    }

    /**
     * Get WriteInterface instance
     *
     * @throws FileSystemException
     * @return WriteInterface
     */
    private function getMediaDirectory()
    {
        if ($this->mediaDirectory === null) {
            $this->mediaDirectory = $this->filesystem->getDirectoryWrite(DirectoryList::MEDIA);
        }

        return $this->mediaDirectory;
    }
}
