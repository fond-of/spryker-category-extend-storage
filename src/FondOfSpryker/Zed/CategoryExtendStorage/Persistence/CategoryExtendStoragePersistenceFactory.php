<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Persistence;

use FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageDependencyProvider;
use FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface;
use Spryker\Zed\CategoryStorage\Persistence\CategoryStoragePersistenceFactory as SprykerCategoryStoragePersistenceFactory;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageConfig getConfig()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Persistence\CategoryExtendStorageQueryContainer getQueryContainer()
 */
class CategoryExtendStoragePersistenceFactory extends SprykerCategoryStoragePersistenceFactory
{
}
