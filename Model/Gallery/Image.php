<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\Gallery;

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
     * @param DirectoryList $directoryList
     * @param MediaConfig $mediaConfig
     * @param string $catalogPath
     */
    public function __construct(
        private readonly DirectoryReaderFactory $directoryReaderFactory,
        private readonly DirectoryList $directoryList,
        private readonly MediaConfig $mediaConfig,
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
     * Calculate hash for the image
     *
     * @return string
     * @throws FileSystemException
     */
    public function getHash(): string
    {
        $absolutePath = $this->getDirectoryReader()->getAbsolutePath(
            $this->getCatalogPath()
        );

        $hash = @hash_file(self::HASH_ALGORITHM, $absolutePath);
        if ($hash === false) {
            throw new FileSystemException(
                __('Cannot calculate hash for the image.')
            );
        }

        return $hash;
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
