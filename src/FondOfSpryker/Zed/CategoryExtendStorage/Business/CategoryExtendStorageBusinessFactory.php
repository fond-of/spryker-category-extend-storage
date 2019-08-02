<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business;

use FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\EntityExpander\StoreEntityExpanderPlugin;
use FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\StorageExpander\CategoryKeyStorageMapperExpanderPlugin;
use FondOfSpryker\Zed\CategoryExtendStorage\Business\StoreTransfersfer as StoreTransfersferAlias;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\Store\Persistence\Base\SpyStoreQuery;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage\CategoryNodeExtendStorage;
use Spryker\Zed\CategoryStorage\Business\CategoryStorageBusinessFactory as SprykerCategoryStorageBusinessFactory;

class CategoryExtendStorageBusinessFactory extends SprykerCategoryStorageBusinessFactory
{
    public function createCategoryNodeStorage()
    {
        return new CategoryNodeExtendStorage(
            $this->getQueryContainer(),
            $this->getUtilSanitizeService(),
            $this->getStore(),
            $this->getConfig()->isSendingToQueue(),
            $this->getEntityExpanderPlugins(),
            $this->getStorageMapperExpanderPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\EntityExpander\EntityExpanderPluginInterface[]
     */
    public function getEntityExpanderPlugins(): array
    {
        
        return $this->getProvidedDependency()
        return [
            new StoreEntityExpanderPlugin($this->getStore()),
        ];
    }

    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\StorageExpander\StorageExpanderPluginInterface[]
     */
    public function getStorageMapperExpanderPlugins(): array
    {
        return [
            new CategoryKeyStorageMapperExpanderPlugin(),
        ];
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return $this->getConfig()->getStore();
    }
}
