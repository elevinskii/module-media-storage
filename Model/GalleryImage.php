<?php
declare(strict_types=1);

namespace Elevinskii\MediaStorage\Model;

use Elevinskii\MediaStorage\Model\ResourceModel\GalleryImage as GalleryImageResource;
use Magento\Framework\Model\AbstractModel;

/**
 * @method int getValueId()
 * @method $this setValueId(int $valueId)
 *
 * @method int getAttributeId()
 * @method $this setAttributeId(int $attributeId)
 *
 * @method string|null getValue()
 * @method $this setValue(?string $value)
 *
 * @method string getMediaType()
 * @method $this setMediaType(string $mediaType)
 *
 * @method int getDisabled()
 * @method $this setDisabled(int $disabled)
 */
class GalleryImage extends AbstractModel
{
    /**
     * Reference to resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(GalleryImageResource::class);
    }
}
