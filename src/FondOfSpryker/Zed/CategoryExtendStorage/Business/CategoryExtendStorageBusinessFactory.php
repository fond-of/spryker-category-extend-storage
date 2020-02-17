<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business;

use FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage\CategoryNodeExtendStorage;
use FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage\CategoryTreeExtendStorage;
use FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageDependencyProvider;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\StorageExpanderPluginInterface;
use FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\Business\CategoryStorageBusinessFactory as SprykerCategoryStorageBusinessFactory;
use Spryker\Zed\CategoryStorage\Business\Storage\CategoryNodeStorageInterface;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageConfig getConfig()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Persistence\CategoryExtendStorageQueryContainer getQueryContainer()
 */
class CategoryExtendStorageBusinessFactory extends SprykerCategoryStorageBusinessFactory
{
    /**
     * @return \Spryker\Zed\CategoryStorage\Business\Storage\CategoryNodeStorageInterface
     */
    public function createCategoryNodeStorage(): CategoryNodeStorageInterface
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
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\StorageExpanderPluginInterface[]
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
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    protected function getStoreFacade(): CategoryExtendStorageToStoreFacadeInterface
    {
        return $this->getProvidedDependency(CategoryExtendStorageDependencyProvider::FACADE_STORE);
    }
}
