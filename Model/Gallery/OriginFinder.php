<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\Gallery;

use Magento\Framework\Exception\FileSystemException;

class OriginFinder
{
    /**
     * @param ImageBuilder $imageBuilder
     */
    public function __construct(
        private readonly ImageBuilder $imageBuilder
    ) {
    }

    /**
     * Search origin image by duplicate
     *
     * @param ImageInterface $duplicateImage
     * @return ImageInterface|null
     * @throws FileSystemException
     */
    public function getOriginImage(
        ImageInterface $duplicateImage
    ): ?ImageInterface {
        $originImage = $this->imageBuilder->create(
            $this->getOriginPath($duplicateImage)
        );

        $originHash = $originImage->getHash();
        $duplicateHash = $duplicateImage->getHash();

        if ($originHash === $duplicateHash) {
            return $originImage;
        } else {
            return null;
        }
    }

    /**
     * Calculate origin path by duplicate
     *
     * @param ImageInterface $duplicateImage
     * @return string
     * @throws FileSystemException
     */
    private function getOriginPath(ImageInterface $duplicateImage): string
    {
        $duplicatePath = $duplicateImage->getCatalogPath();

        return substr($duplicatePath, 0, strrpos($duplicatePath, '_')) .
            '.' .$duplicateImage->getPathInfo()->getExtension();
    }
}
