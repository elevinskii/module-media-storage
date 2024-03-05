<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\Gallery;

use Elevinskii\MediaStorage\Model\Gallery\Image\HashCache;
use Elevinskii\MediaStorage\Model\Gallery\Image\PathInfo;
use Elevinskii\MediaStorage\Model\Gallery\Image\PathInfoFactory;
use Magento\Catalog\Model\Product\Media\ConfigInterface as MediaConfig;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Magento\Framework\Filesystem\Directory\ReadFactory as DirectoryReaderFactory;
use Magento\Framework\Filesystem\Directory\ReadInterface as DirectoryReader;

class Image implements ImageInterface
{
    /**
     * Algorithm for hash calculation
     */
    private const HASH_ALGORITHM = 'md5';

    /**
     * @var DirectoryReader|null
     */
    private ?DirectoryReader $directoryReader = null;

    /**
     * @param DirectoryReaderFactory $directoryReaderFactory
     * @param PathInfoFactory $pathInfoFactory
     * @param DirectoryList $directoryList
     * @param MediaConfig $mediaConfig
     * @param HashCache $hashCache
     * @param string $catalogPath
     */
    public function __construct(
        private readonly DirectoryReaderFactory $directoryReaderFactory,
        private readonly PathInfoFactory $pathInfoFactory,
        private readonly DirectoryList $directoryList,
        private readonly MediaConfig $mediaConfig,
        private readonly HashCache $hashCache,
        private readonly string $catalogPath
    ) {
    }

    /**
     * Retrieve catalog image path
     *
     * @return string
     */
    public function getCatalogPath(): string
    {
        return $this->catalogPath;
    }

    /**
     * Retrieve information about the image path
     *
     * @return PathInfo
     * @throws FileSystemException
     */
    public function getPathInfo(): PathInfo
    {
        // phpcs:ignore
        $pathInfo = pathinfo($this->getAbsolutePath());

        return $this->pathInfoFactory->create()
            ->setData($pathInfo);
    }

    /**
     * Retrieve image size
     *
     * @return int
     * @throws FileSystemException
     */
    public function getFileSize(): int
    {
        $absolutePath = $this->getAbsolutePath();

        // phpcs:ignore
        $fileSize = @filesize($absolutePath);
        if (!$fileSize) {
            throw new FileSystemException(
                __('Cannot define filesize for the image by path %1', [$absolutePath])
            );
        }

        return $fileSize;
    }

    /**
     * Calculate hash for the image
     *
     * @return string
     * @throws FileSystemException
     */
    public function getHash(): string
    {
        $absolutePath = $this->getAbsolutePath();

        $hash = $this->hashCache->get($absolutePath);
        if (!$hash) {
            // phpcs:ignore
            $hash = @hash_file(self::HASH_ALGORITHM, $absolutePath) ?: null;
            $this->hashCache->set($absolutePath, $hash);
        }

        if (!$hash) {
            throw new FileSystemException(
                __('Cannot calculate hash for the image by path %1', [$absolutePath])
            );
        }

        return $hash;
    }

    /**
     * Retrieve absolute path to the image
     *
     * @return string
     * @throws FileSystemException
     */
    private function getAbsolutePath(): string
    {
        return $this->getDirectoryReader()->getAbsolutePath(
            $this->getCatalogPath()
        );
    }

    /**
     * Retrieve directory reader for further operations
     *
     * @return DirectoryReader
     * @throws FileSystemException
     */
    private function getDirectoryReader(): DirectoryReader
    {
        if (!$this->directoryReader) {
            $mediaPath = $this->directoryList->getPath(DirectoryList::MEDIA);
            $catalogPath = $this->mediaConfig->getBaseMediaPath();

            $this->directoryReader = $this->directoryReaderFactory->create(
                sprintf('%s/%s', $mediaPath, $catalogPath)
            );
        }

        return $this->directoryReader;
    }
}
