<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage;

use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\CategoryStorageConfig as SprykerCategoryStorageConfig;

class CategoryExtendStorageConfig extends SprykerCategoryStorageConfig
{
    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return Store::getInstance();
    }
}
