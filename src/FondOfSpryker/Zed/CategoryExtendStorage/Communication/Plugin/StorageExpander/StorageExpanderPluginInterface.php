<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;

interface StorageExpanderPluginInterface
{
    /**
     * @param  \Generated\Shared\Transfer\CategoryNodeStorageTransfer  $categoryNodeStorageTransfer
     * @param  \Orm\Zed\Category\Persistence\SpyCategoryNode  $categoryNode
     */
    public function expand(CategoryNodeStorageTransfer $categoryNodeStorageTransfer, SpyCategoryNode $categoryNode): void;
}
