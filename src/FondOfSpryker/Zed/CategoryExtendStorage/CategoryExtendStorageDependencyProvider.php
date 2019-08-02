<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage;

use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\EntityExpander\StoreEntityExpanderPlugin;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\CategoryKeyStorageMapperExpanderPlugin;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\CategoryStorageDependencyProvider as SprykerCategoryStorageDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CategoryExtendStorageDependencyProvider extends SprykerCategoryStorageDependencyProvider
{
    public const PLUGIN_ENTITY_EXPANDER = 'PLUGIN_ENTITY_EXPANDER';

    public const PLUGIN_STORAGE_EXPANDER = 'PLUGIN_STORAGE_EXPANDER';
    
    public const STORE = 'STORE';

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addEntityPluginExpander($container);
        $container = $this->addStoragePluginExpander($container);
        $container = $this->addStore($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addEntityPluginExpander(Container $container): Container
    {
        $container[static::PLUGIN_ENTITY_EXPANDER] = function () {
            return $this->createEntityPluginExpander();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoragePluginExpander(Container $container): Container
    {
        $container[static::PLUGIN_STORAGE_EXPANDER] = function () {
            return $this->createStoragePluginExpander();
        };

        return $container;
    }

    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\EntityExpander\EntityExpanderPluginInterface[]
     */
    protected function createEntityPluginExpander(): array
    {
        return [
            new StoreEntityExpanderPlugin($this->getStore()),
        ];
    }

    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\StorageExpanderPluginInterface[]
     */
    protected function createStoragePluginExpander(): array
    {
        return [
            new CategoryKeyStorageMapperExpanderPlugin(),
        ];
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStore(Container $container): Container
    {
        $container[static::STORE] = function () {
            return $this->getStore();
        };

        return $container;
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    protected function getStore(): Store
    {
        return Store::getInstance();
    }
}
