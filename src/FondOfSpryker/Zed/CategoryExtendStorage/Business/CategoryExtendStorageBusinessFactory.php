<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business;

use FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage\CategoryNodeExtendStorage;
use FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage\CategoryTreeExtendStorage;
use FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageDependencyProvider;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\Business\CategoryStorageBusinessFactory as SprykerCategoryStorageBusinessFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageConfig getConfig()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Persistence\CategoryExtendStorageQueryContainer getQueryContainer()
 */
class CategoryExtendStorageBusinessFactory extends SprykerCategoryStorageBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage\CategoryNodeExtendStorage|\Spryker\Zed\CategoryStorage\Business\Storage\CategoryNodeStorageInterface
     */
    public function createCategoryNodeStorage(): CategoryNodeExtendStorage
    {
        return new CategoryNodeExtendStorage(
            $this->getQueryContainer(),
            $this->getUtilSanitizeService(),
            $this->getStore(),
            $this->getConfig()->isSendingToQueue(),
            $this->getStoreFacade(),
            $this->getStorageMapperExpanderPlugins()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage\CategoryTreeExtendStorage
     */
    public function createCategoryTreeStorage(): CategoryTreeExtendStorage
    {
        return new CategoryTreeExtendStorage(
            $this->getQueryContainer(),
            $this->getUtilSanitizeService(),
            $this->getStore(),
            $this->getConfig()->isSendingToQueue(),
            $this->getStoreFacade()
        );
    }

    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\EntityExpander\EntityExpanderPluginInterface[]
     */
    public function getEntityExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CategoryExtendStorageDependencyProvider::PLUGIN_ENTITY_EXPANDER);
    }

    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\StorageExpander\StorageExpanderPluginInterface[]
     */
    public function getStorageMapperExpanderPlugins(): array
    {
        return $this->getProvidedDependency(CategoryExtendStorageDependencyProvider::PLUGIN_STORAGE_EXPANDER);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    public function getStore(): Store
    {
        return $this->getProvidedDependency(CategoryExtendStorageDependencyProvider::STORE);
    }

    /**
     * @throws
     *
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(CategoryExtendStorageDependencyProvider::FACADE_STORE);
    }
}
