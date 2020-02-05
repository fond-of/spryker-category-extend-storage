<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication;

use FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageDependencyProvider;
use Spryker\Zed\CategoryStorage\Communication\CategoryStorageCommunicationFactory as SprykerCategoryStorageCommunicationFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageConfig getConfig()
 * @method CategoryExtendStorageQueryContainer getQueryContainer()
 */
class CategoryExtendStorageCommunicationFactory extends SprykerCategoryStorageCommunicationFactory
{
    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     * @throws \Spryker\Zed\Kernel\Exception\Container\ContainerKeyNotFoundException
     */
    public function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(CategoryExtendStorageDependencyProvider::FACADE_STORE);
    }
}
