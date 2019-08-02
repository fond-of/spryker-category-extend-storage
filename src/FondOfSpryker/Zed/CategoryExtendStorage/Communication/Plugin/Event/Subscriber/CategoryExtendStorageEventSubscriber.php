<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener\CategoryNodeExtendStorageListener;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener\CategoryNodeStorageCategoryStorageListener;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener\CategoryTreeExtendStorageListener;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener\CategoryTreeStoreStorageListener;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener\CategoryNodeStoreStorageListener;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Subscriber\CategoryStorageEventSubscriber as SprykerCategoryStorageEventSubscriber;
use Spryker\Zed\Event\Dependency\EventCollectionInterface;

class CategoryExtendStorageEventSubscriber extends SprykerCategoryStorageEventSubscriber
{
    use LoggerTrait;

    /**
     * @api
     *
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return \Spryker\Zed\Event\Dependency\EventCollectionInterface
     */
    public function getSubscribedEvents(EventCollectionInterface $eventCollection)
    {
        $this->addCategoryTreeEvents($eventCollection);

        $this->addCategoryNodePublishListener($eventCollection);
        $this->addCategoryNodeUnpublishListener($eventCollection);
        $this->addCategoryNodeCreateListener($eventCollection);
        $this->addCategoryNodeUpdateListener($eventCollection);
        $this->addCategoryNodeDeleteListener($eventCollection);
        $this->addCategoryCreateListener($eventCollection);
        $this->addCategoryUpdateListener($eventCollection);
        $this->addCategoryDeleteListener($eventCollection);
        $this->addCategoryAttributeUpdateListener($eventCollection);
        $this->addCategoryAttributeCreateListener($eventCollection);
        $this->addCategoryAttributeDeleteListener($eventCollection);
        $this->addCategoryTemplateCreateListener($eventCollection);
        $this->addCategoryTemplateUpdateListener($eventCollection);
        $this->addCategoryTemplateDeleteListener($eventCollection);

        return $eventCollection;
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryTreeEvents(EventCollectionInterface $eventCollection)
    {
        $this->addCategoryTreePublishListener($eventCollection);
        $this->addCategoryTreeUnpublishListener($eventCollection);
        $this->addCategoryCreateForTreeListener($eventCollection);
        $this->addCategoryUpdateForTreeListener($eventCollection);
        $this->addCategoryDeleteForTreeListener($eventCollection);
        $this->addCategoryNodeCreateForTreeListener($eventCollection);
        $this->addCategoryNodeUpdateForTreeListener($eventCollection);
        $this->addCategoryNodeDeleteForTreeListener($eventCollection);
        $this->addCategoryAttributeCreateForTreeListener($eventCollection);
        $this->addCategoryAttributeUpdateForTreeListener($eventCollection);
        $this->addCategoryAttributeDeleteForTreeListener($eventCollection);
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     *
     */
    protected function addCategoryNodePublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_PUBLISH, new CategoryNodeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUnpublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_UNPUBLISH, new CategoryNodeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_CREATE, new CategoryNodeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_UPDATE, new CategoryNodeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeDeleteListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_DELETE, new CategoryNodeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryTreePublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_TREE_PUBLISH, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryTreeUnpublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_TREE_UNPUBLISH, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryCreateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_CREATE, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryUpdateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_UPDATE, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryDeleteForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_DELETE, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCreateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_CREATE, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUpdateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_UPDATE, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeDeleteForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_DELETE, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryAttributeCreateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_CREATE, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryAttributeUpdateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_UPDATE, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryAttributeDeleteForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_DELETE, new CategoryTreeExtendStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_CREATE, new CategoryNodeStorageCategoryStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_UPDATE, new CategoryNodeStorageCategoryStorageListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryDeleteListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_DELETE, new CategoryNodeStorageCategoryStorageListener());
    }
}
