<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Subscriber;

use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener\CategoryExtendNodeCategoryTemplateStoragePublishListener;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener\CategoryExtendNodeStorageParentPublishListener;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener\CategoryExtendNodeStoragePublishListener;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\Event\Listener\CategoryExtendTreeStoragePublishListener;
use Spryker\Shared\Log\LoggerTrait;
use Spryker\Zed\Category\Dependency\CategoryEvents;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Listener\CategoryNodeCategoryAttributeStorageUnpublishListener;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Listener\CategoryNodeCategoryStoragePublishListener;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Listener\CategoryNodeCategoryStorageUnpublishListener;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Listener\CategoryNodeCategoryTemplateStorageUnpublishListener;
use Spryker\Zed\CategoryStorage\Communication\Plugin\Event\Listener\CategoryNodeStorageUnpublishListener;
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
     */
    protected function addCategoryNodePublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_PUBLISH, new CategoryExtendNodeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodePublishParentListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_PUBLISH, new CategoryExtendNodeStorageParentPublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUnpublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_UNPUBLISH, new CategoryNodeStorageUnpublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUnpublishParentListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_NODE_UNPUBLISH, new CategoryExtendNodeStorageParentPublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_CREATE, new CategoryExtendNodeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCreateParentListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_CREATE, new CategoryExtendNodeStorageParentPublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_UPDATE, new CategoryExtendNodeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUpdateParentListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_UPDATE, new CategoryExtendNodeStorageParentPublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeDeleteParentListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_DELETE, new CategoryExtendNodeStorageParentPublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_CREATE, new CategoryNodeCategoryStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_UPDATE, new CategoryNodeCategoryStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryDeleteListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_DELETE, new CategoryNodeCategoryStorageUnpublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryAttributeUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_UPDATE, new CategoryExtendNodeCategoryAttributeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryAttributeCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_CREATE, new CategoryExtendNodeCategoryAttributeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryAttributeDeleteListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_DELETE, new CategoryNodeCategoryAttributeStorageUnpublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryTemplateCreateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_TEMPLATE_CREATE, new CategoryExtendNodeCategoryTemplateStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryTemplateUpdateListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_TEMPLATE_UPDATE, new CategoryExtendNodeCategoryTemplateStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryTemplateDeleteListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_TEMPLATE_DELETE, new CategoryNodeCategoryTemplateStorageUnpublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryTreePublishListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::CATEGORY_TREE_PUBLISH, new CategoryExtendTreeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryCreateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_CREATE, new CategoryExtendTreeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryUpdateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_UPDATE, new CategoryExtendTreeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryDeleteForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_DELETE, new CategoryExtendTreeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeCreateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_CREATE, new CategoryExtendTreeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeUpdateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_UPDATE, new CategoryExtendTreeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryNodeDeleteForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_NODE_DELETE, new CategoryExtendTreeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryAttributeCreateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_CREATE, new CategoryExtendTreeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryAttributeUpdateForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_UPDATE, new CategoryExtendTreeStoragePublishListener());
    }

    /**
     * @param \Spryker\Zed\Event\Dependency\EventCollectionInterface $eventCollection
     *
     * @return void
     */
    protected function addCategoryAttributeDeleteForTreeListener(EventCollectionInterface $eventCollection)
    {
        $eventCollection->addListenerQueued(CategoryEvents::ENTITY_SPY_CATEGORY_ATTRIBUTE_DELETE, new CategoryExtendTreeStoragePublishListener());
    }
}
