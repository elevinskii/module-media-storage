<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\Gallery;

interface ImageInterface
{
    /**
     * Retrieve catalog image path
     *
     * @return string
     */
    public function getCatalogPath(): string;

    /**
     * Calculate hash for the image
     *
     * @return string
     */
    public function getHash(): string;
}
