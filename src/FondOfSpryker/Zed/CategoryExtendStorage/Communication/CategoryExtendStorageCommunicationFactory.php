<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication;

use FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageDependencyProvider;
use FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface;
use Spryker\Zed\CategoryStorage\Communication\CategoryStorageCommunicationFactory as SprykerCategoryStorageCommunicationFactory;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageConfig getConfig()
 * @method CategoryExtendStorageQueryContainer getQueryContainer()
 */
class CategoryExtendStorageCommunicationFactory extends SprykerCategoryStorageCommunicationFactory
{
    /**
     * @return \FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface
     */
    public function getStoreFacade(): CategoryExtendStorageToStoreFacadeInterface
    {
        return $this->getProvidedDependency(CategoryExtendStorageDependencyProvider::FACADE_STORE);
    }
}
