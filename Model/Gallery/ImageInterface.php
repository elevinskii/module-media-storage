<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\Gallery;

use Elevinskii\MediaStorage\Model\Gallery\Image\PathInfo;
use Magento\Framework\Exception\FileSystemException;

interface ImageInterface
{
    /**
     * Retrieve catalog image path
     *
     * @return string
     */
    public function getCatalogPath(): string;

    /**
     * Retrieve information about the image path
     *
     * @return PathInfo
     * @throws FileSystemException
     */
    public function getPathInfo(): PathInfo;

    /**
     * Retrieve image size
     *
     * @return int
     * @throws FileSystemException
     */
    public function getFileSize(): int;

    /**
     * Calculate hash for the image
     *
     * @return string
     * @throws FileSystemException
     */
    public function getHash(): string;
}
