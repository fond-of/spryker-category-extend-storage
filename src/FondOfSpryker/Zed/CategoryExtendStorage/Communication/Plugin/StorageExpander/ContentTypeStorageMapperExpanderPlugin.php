<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;

class ContentTypeStorageMapperExpanderPlugin implements StorageExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $categoryNode
     *
     * @return void
     */
    public function expand(CategoryNodeStorageTransfer $categoryNodeStorageTransfer, SpyCategoryNode $categoryNode): void
    {
        $categoryNodeStorageTransfer->setContentType($categoryNode->getCategory()->getContentType());
    }
}
