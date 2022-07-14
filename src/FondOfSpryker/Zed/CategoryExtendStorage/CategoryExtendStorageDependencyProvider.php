<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage;

use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\CategoryKeyStorageMapperExpanderPlugin;
use FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeBridge;
use Spryker\Zed\CategoryStorage\CategoryStorageDependencyProvider as SprykerCategoryStorageDependencyProvider;
use Spryker\Zed\Kernel\Container;

class CategoryExtendStorageDependencyProvider extends SprykerCategoryStorageDependencyProvider
{
    public const FACADE_STORE = 'FACADE_STORE';

    public const PLUGIN_STORAGE_EXPANDER = 'PLUGIN_STORAGE_EXPANDER';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container): Container
    {
        $container = parent::provideBusinessLayerDependencies($container);
        $container = $this->addStoreFacade($container);
        $container = $this->addStoragePluginExpander($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);
        $container = $this->addStoreFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function providePersistenceLayerDependencies(Container $container): Container
    {
        $container = parent::providePersistenceLayerDependencies($container);
        $container = $this->addStoreFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addStoreFacade(Container $container): Container
    {
        $container[static::FACADE_STORE] = function (Container $container) {
            return new CategoryExtendStorageToStoreFacadeBridge($container->getLocator()->store()->facade());
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
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\StorageExpanderPluginInterface[]
     */
    protected function createStoragePluginExpander(): array
    {
        return [
            new CategoryKeyStorageMapperExpanderPlugin(),
        ];
    }
}
