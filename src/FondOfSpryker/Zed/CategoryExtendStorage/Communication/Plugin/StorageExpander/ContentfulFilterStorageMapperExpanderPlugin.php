<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageConfig getConfig()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Persistence\CategoryExtendStorageQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Business\CategoryExtendStorageFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Communication\CategoryExtendStorageCommunicationFactory getFactory()
 */
class ContentfulFilterStorageMapperExpanderPlugin extends AbstractPlugin implements StorageExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $categoryNode
     *
     * @return void
     */
    public function expand(CategoryNodeStorageTransfer $categoryNodeStorageTransfer, SpyCategoryNode $categoryNode): void
    {
        $categoryNodeStorageTransfer->setContentfulFilter($categoryNode->getCategory()->getContentfulFilter());
    }
}