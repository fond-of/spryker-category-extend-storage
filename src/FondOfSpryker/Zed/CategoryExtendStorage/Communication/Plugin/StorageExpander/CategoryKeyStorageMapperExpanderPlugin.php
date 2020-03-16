<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Business\CategoryExtendStorageFacade getFacade()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Communication\CategoryExtendStorageCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageConfig getConfig()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Persistence\CategoryExtendStorageQueryContainerInterface getQueryContainer()
 */
class CategoryKeyStorageMapperExpanderPlugin extends AbstractPlugin implements StorageExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $categoryNode
     *
     * @return void
     */
    public function expand(CategoryNodeStorageTransfer $categoryNodeStorageTransfer, SpyCategoryNode $categoryNode): void
    {
        $categoryNodeStorageTransfer->setCategoryKey($categoryNode->getCategory()->getCategoryKey());
    }
}
