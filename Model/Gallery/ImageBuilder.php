<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\Gallery;

class ImageBuilder
{
    /**
     * @param ImageFactory $imageFactory
     */
    public function __construct(
        private readonly ImageFactory $imageFactory
    ) {
    }

    /**
     * Create image model with specified path
     *
     * @param string $catalogPath
     * @return Image
     */
    public function create(string $catalogPath): Image
    {
        return $this->imageFactory->create([
            'catalogPath' => $catalogPath
        ]);
    }
}
