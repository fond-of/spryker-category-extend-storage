<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business;

use Spryker\Zed\CategoryStorage\Business\CategoryStorageFacade as SprykerCategoryStorageFacade;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Business\CategoryExtendStorageBusinessFactory getFactory()
 */
class CategoryExtendStorageFacade extends SprykerCategoryStorageFacade
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array $categoryNodeIds
     *
     * @return void
     */
    public function publish(array $categoryNodeIds)
    {
        $this->getFactory()->createCategoryNodeStorage()->publish($categoryNodeIds);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return void
     */
    public function publishCategoryTree()
    {
        $this->getFactory()->createCategoryTreeStorage()->publish();
    }
}
