<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model\ResourceModel;

use Magento\Catalog\Model\ResourceModel\Product\Gallery;
use Magento\Framework\Model\AbstractModel;
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

    /**
     * Change in EAV product table after gallery save
     *
     * @param AbstractModel $object
     * @return $this
     */
    protected function _afterSave(AbstractModel $object)
    {
        $imagePath = $object->getData('value');
        $originImagePath = $object->getOrigData('value');

        if ($imagePath !== $originImagePath) {
            $this->getConnection()->update(
                $this->getTable('catalog_product_entity_varchar'),
                ['value' => $imagePath],
                ['value = ?' => $originImagePath]
            );
        }

        return parent::_afterSave($object);
    }
}
