<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryAttribute;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\CategoryExtendStorageConfig getConfig()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Persistence\CategoryExtendStorageQueryContainerInterface getQueryContainer()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Business\CategoryExtendStorageFacadeInterface getFacade()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Communication\CategoryExtendStorageCommunicationFactory getFactory()
 */
class ContentfulHeroStorageMapperExpanderPlugin extends AbstractPlugin implements StorageExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $categoryNode
     * @param \Orm\Zed\Category\Persistence\SpyCategoryAttribute|null $categoryAttribute
     *
     * @return void
     */
    public function expand(
        CategoryNodeStorageTransfer $categoryNodeStorageTransfer,
        SpyCategoryNode $categoryNode,
        ?SpyCategoryAttribute $categoryAttribute
    ): void {
        $categoryNodeStorageTransfer->setContentfulHero($categoryNode->getCategory()->getContentfulHero());
    }
}
