<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\Gallery;

class ImageBuilder
{
    /**
     * @param ImageInterfaceFactory $imageFactory
     */
    public function __construct(
        private readonly ImageInterfaceFactory $imageFactory
    ) {
    }

    /**
     * Create image model with specified path
     *
     * @param string $catalogPath
     * @return ImageInterface
     */
    public function create(string $catalogPath): ImageInterface
    {
        return $this->imageFactory->create([
            'catalogPath' => $catalogPath
        ]);
    }
}
