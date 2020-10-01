<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade;

use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class CategoryExtendStorageToStoreFacadeBridge implements CategoryExtendStorageToStoreFacadeInterface
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct(StoreFacadeInterface $storeFacade)
    {
        $this->storeFacade = $storeFacade;
    }

    /**
     * @return \Generated\Shared\Transfer\StoreTransfer
     */
    public function getCurrentStore(): StoreTransfer
    {
        return $this->storeFacade->getCurrentStore();
    }
}
