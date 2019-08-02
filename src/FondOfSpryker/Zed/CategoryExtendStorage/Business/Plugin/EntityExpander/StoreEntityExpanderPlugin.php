<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\EntityExpander;

use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Spryker\Shared\Kernel\Store;

class StoreEntityExpanderPlugin implements EntityExpanderPluginInterface
{
    /**
     * @var \Spryker\Shared\Kernel\Store $store
     */
    protected $store;

    /**
     * @param \Spryker\Shared\Kernel\Store $store
     */
    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage $categoryNodeStorageEntity
     *
     * @return void
     */
    public function expand(SpyCategoryNodeStorage $categoryNodeStorageEntity): void
    {
        $categoryNodeStorageEntity->setStore($this->store->getStoreName());
    }
}
