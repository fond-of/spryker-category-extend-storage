<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\StorageExpander;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;

interface StorageExpanderPluginInterface
{
    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param \FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\StorageExpander\SpyCategoryNode $categoryNode
     *
     * @return void
     */
    public function expand(CategoryNodeStorageTransfer $categoryNodeStorageTransfer, SpyCategoryNode $categoryNode): void;
}
