<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business;

use FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage\CategoryNodeExtendStorage;
use FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageDependencyProvider;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\Business\CategoryStorageBusinessFactory as SprykerCategoryStorageBusinessFactory;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageConfig getConfig()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Persistence\CategoryExtendStorageQueryContainer getQueryContainer()
 */
class CategoryExtendStorageBusinessFactory extends SprykerCategoryStorageBusinessFactory
{
    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage\CategoryNodeExtendStorage|\Spryker\Zed\CategoryStorage\Business\Storage\CategoryNodeStorageInterface
     */
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
}
