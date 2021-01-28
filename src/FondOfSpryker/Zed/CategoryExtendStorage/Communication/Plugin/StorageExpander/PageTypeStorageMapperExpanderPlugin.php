<?php


namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;


use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryAttribute;
use Orm\Zed\Category\Persistence\SpyCategoryNode;

class PageTypeStorageMapperExpanderPlugin implements StorageExpanderPluginInterface
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
        SpyCategoryNode $categoryNode, ?SpyCategoryAttribute
        $categoryAttribute)
    : void
    {
        $categoryNodeStorageTransfer->setPageType($categoryNode->getCategory()->getPageType());
    }
}
