<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\ResourceModel\GalleryImage;

use Elevinskii\MediaStorage\Model\GalleryImage;
use Elevinskii\MediaStorage\Model\ResourceModel\GalleryImage as GalleryImageResource;
use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Reference for model/resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(GalleryImage::class, GalleryImageResource::class);
    }
}
