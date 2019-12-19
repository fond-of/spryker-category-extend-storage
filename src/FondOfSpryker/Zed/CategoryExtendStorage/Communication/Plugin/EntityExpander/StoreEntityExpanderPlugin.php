<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\EntityExpander;

use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Business\CategoryExtendStorageFacade getFacade()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Communication\CategoryExtendStorageCommunicationFactory getFactory()
 */
class StoreEntityExpanderPlugin extends AbstractPlugin implements EntityExpanderPluginInterface
{
    /**
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage $categoryNodeStorageEntity
     *
     * @return void
     */
    public function expand(SpyCategoryNodeStorage $categoryNodeStorageEntity): void
    {
        $categoryNodeStorageEntity->setStore($this->store->getStoreName());
    }
}
