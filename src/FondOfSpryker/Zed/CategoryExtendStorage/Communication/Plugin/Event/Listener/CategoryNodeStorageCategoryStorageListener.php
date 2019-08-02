<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener;

use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Listener\CategoryNodeCategoryStorageListener as SprykerCategoryNodeCategoryStorageListener;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Communication\CategoryExtendStorageCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Business\CategoryExtendStorageFacadeInterface getFacade()
 */
class CategoryNodeStorageCategoryStorageListener extends SprykerCategoryNodeCategoryStorageListener
{
    /**
     * @api
     *
     * @param \Generated\Shared\Transfer\EventEntityTransfer[] $eventTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventTransfers, $eventName)
    {
        $this->preventTransaction();
        $categoryIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferIds($eventTransfers);
        $categoryNodeIds = $this->getQueryContainer()->queryCategoryNodeIdsByCategoryIds($categoryIds)->find()->getData();

        if ($eventName === CategoryEvents::ENTITY_SPY_CATEGORY_DELETE) {
            $this->getFacade()->unpublish($categoryNodeIds);

            return;
        }

        $this->getFacade()->publish($categoryNodeIds);
    }
}
