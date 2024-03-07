[![Latest Stable Version](http://poser.pugx.org/elevinskii/module-media-storage/v)](https://packagist.org/packages/elevinskii/module-media-storage)
[![Total Downloads](http://poser.pugx.org/elevinskii/module-media-storage/downloads)](https://packagist.org/packages/elevinskii/module-media-storage)
[![PHP Version Require](http://poser.pugx.org/elevinskii/module-media-storage/require/php)](https://packagist.org/packages/elevinskii/module-media-storage)

### What's the problem?

That sometimes might be a case when your Magento content managers use the same images with assigning them to
different products - and that may consume a lot of priceless server media storage. Especially if you're on
a big number of SKUs, that'll become a real issue.

### What to do?

Our small extension helps to discover such duplicates in products' galleries, remove them and point the images to
original path.

### How to use?

That's easy - `bin/magento catalog:images:remove-duplicates`

Possible options:

- `--dry-run` - performs dry running without any operations with database 

**Warning**

Please create dumps of below listed tables, for being able to revert changes if something goes wrong.

- catalog_product_entity_media_gallery
- catalog_product_entity_varchar
