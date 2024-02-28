<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\ResourceModel;

use Magento\Catalog\Model\ResourceModel\Product\Gallery;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class GalleryImage extends AbstractDb
{
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(Gallery::GALLERY_TABLE, 'value_id');
    }
}
