<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener;

use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Listener\CategoryNodeStorageListener as SprykerCategoryNodeStorageListener;

/**
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Communication\CategoryExtendStorageCommunicationFactory getFactory()
 * @method \FondOfSpryker\Zed\CategoryExtendStorage\Business\CategoryExtendStorageFacadeInterface getFacade()
 */
class CategoryNodeExtendStorageListener extends SprykerCategoryNodeStorageListener
{
    use LoggerTrait;

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
        $categoryNodeIds = $this->getFactory()->getEventBehaviorFacade()->getEventTransferIds($eventTransfers);

        if ($eventName === CategoryEvents::ENTITY_SPY_CATEGORY_NODE_DELETE ||
            $eventName === CategoryEvents::CATEGORY_NODE_UNPUBLISH
        ) {
            $this->getFacade()->unpublish($categoryNodeIds);

            return;
        }

        $this->getFacade()->publish($categoryNodeIds);
    }
}
