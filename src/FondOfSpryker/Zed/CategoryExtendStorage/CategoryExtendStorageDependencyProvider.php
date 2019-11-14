<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage;

use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\EntityExpander\StoreEntityExpanderPlugin;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\CategoryKeyStorageMapperExpanderPlugin;
use Spryker\Zed\CategoryStorage\CategoryStorageDependencyProvider as SprykerCategoryStorageDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CategoryExtendStorageDependencyProvider extends SprykerCategoryStorageDependencyProvider
{
    public const PLUGIN_ENTITY_EXPANDER = 'PLUGIN_ENTITY_EXPANDER';

    public const PLUGIN_STORAGE_EXPANDER = 'PLUGIN_STORAGE_EXPANDER';

    public const STORE = 'STORE';
    public const FACADE_STORE = 'FACADE_STORE';

    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
//        $container = $this->addEntityPluginExpander($container);
//        $container = $this->addStoragePluginExpander($container);
//        $container = $this->addStore($container);
        $container = $this->addStoreFacade($container);

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
            new StoreEntityExpanderPlugin(),
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

    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = function (Container $container) {
            return $container->getLocator()->store()->facade();
        };

        return $container;
    }
}
