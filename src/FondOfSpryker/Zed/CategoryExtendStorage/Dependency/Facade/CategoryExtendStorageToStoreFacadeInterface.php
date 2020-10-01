<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;

interface CategoryExtendStorageToStoreFacadeInterface
{
    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(): StoreTransfer;
}
