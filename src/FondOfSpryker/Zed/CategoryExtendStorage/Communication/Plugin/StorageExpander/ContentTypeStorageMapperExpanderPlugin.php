<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryAttribute;
use Orm\Zed\Category\Persistence\SpyCategoryNode;

class ContentTypeStorageMapperExpanderPlugin implements StorageExpanderPluginInterface
{
    /**
     * @param CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param SpyCategoryNode $categoryNode
     * @param SpyCategoryAttribute|null $categoryAttribute
     *
     * @return void
     */
    public function expand(
        CategoryNodeStorageTransfer $categoryNodeStorageTransfer,
        SpyCategoryNode $categoryNode,
        ?SpyCategoryAttribute $categoryAttribute
    ): void
    {
        $categoryNodeStorageTransfer->setContentType($categoryNode->getCategory()->getContentType());
    }
}
