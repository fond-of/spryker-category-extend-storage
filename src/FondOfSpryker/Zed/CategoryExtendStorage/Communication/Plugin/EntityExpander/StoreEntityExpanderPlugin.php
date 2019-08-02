<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\EntityExpander;

use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Business\CategoryExtendStorageFacade getFacade()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Communication\CategoryExtendStorageCommunicationFactory getFactory()
 */
class StoreEntityExpanderPlugin extends AbstractPlugin implements EntityExpanderPluginInterface
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
