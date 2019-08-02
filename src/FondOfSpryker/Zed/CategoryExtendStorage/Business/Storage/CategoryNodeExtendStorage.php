<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Orm\Zed\Category\Persistence\SpyCategoryNodeQuery;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Orm\Zed\Store\Persistence\SpyStoreQuery;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\Business\Storage\CategoryNodeStorage as SprykerCategoryNodeStorage;
use Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface;
use Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface;

class CategoryNodeExtendStorage extends SprykerCategoryNodeStorage
{
    /**
     * @var \FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\EntityExpander\EntityExpanderPluginInterface[]
     */
    protected $entityExpanderPlugins;

    /**
     * @var \FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\StorageExpander\StorageExpanderPluginInterface
     */
    protected $storageMapperExpanderPlugins;

    /**
     * CategoryNodeStorage constructor.
     *
     * @param \Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface $utilSanitize
     * @param \Spryker\Shared\Kernel\Store $store
     * @param $isSendingToQueue
     * @param array $entityExpanderPlugins
     * @param array $storageMapperExpanderPlugins
     */
    public function __construct(
        CategoryStorageQueryContainerInterface $queryContainer,
        CategoryStorageToUtilSanitizeServiceInterface $utilSanitize,
        Store $store,
        $isSendingToQueue,
        array $entityExpanderPlugins,
        array $storageMapperExpanderPlugins
    ) {
        parent::__construct($queryContainer, $utilSanitize, $store, $isSendingToQueue);

        $this->entityExpanderPlugins = $entityExpanderPlugins;
        $this->storageMapperExpanderPlugins = $storageMapperExpanderPlugins;
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param string $localeName
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage|null $spyCategoryNodeStorageEntity
     *
     * @throws
     *
     * @return void
     */
    protected function storeDataSet(CategoryNodeStorageTransfer $categoryNodeStorageTransfer, $localeName, ?SpyCategoryNodeStorage $spyCategoryNodeStorageEntity = null)
    {
        $categoryNodeStorageTransfer->getNodeId();

        if ($spyCategoryNodeStorageEntity === null) {
            $spyCategoryNodeStorageEntity = new SpyCategoryNodeStorage();
        }

        if (!$categoryNodeStorageTransfer->getIsActive()) {
            if (!$spyCategoryNodeStorageEntity->isNew()) {
                $spyCategoryNodeStorageEntity->delete();
            }

            return;
        }

        $categoryNodeNodeData = $this->utilSanitize->arrayFilterRecursive($categoryNodeStorageTransfer->toArray());
        $spyCategoryNodeStorageEntity->setFkCategoryNode($categoryNodeStorageTransfer->getNodeId());
        $spyCategoryNodeStorageEntity->setData($categoryNodeNodeData);
        $spyCategoryNodeStorageEntity->setLocale($localeName);
        $spyCategoryNodeStorageEntity->setIsSendingToQueue($this->isSendingToQueue);

        foreach ($this->entityExpanderPlugins as $plugin) {
            $plugin->expand($spyCategoryNodeStorageEntity);
        }

        $spyCategoryNodeStorageEntity->save();
    }

    /**
     * @param array $categoryNodes
     * @param \Orm\Zed\Category\Persistence\SpyCategoryNode $categoryNode
     * @param bool $includeChildren
     * @param bool $includeParents
     *
     * @throws
     *
     * @return \Generated\Shared\Transfer\CategoryNodeStorageTransfer
     */
    protected function mapToCategoryNodeStorageTransfer(array $categoryNodes, SpyCategoryNode $categoryNode, $includeChildren = true, $includeParents = true): CategoryNodeStorageTransfer
    {
        $categoryNodeStorageTransfer = parent::mapToCategoryNodeStorageTransfer($categoryNodes, $categoryNode, $includeChildren, $includeParents);

        foreach ($this->storageMapperExpanderPlugins as $plugin) {
            $plugin->expand($categoryNodeStorageTransfer, $categoryNode);
        }

        return $categoryNodeStorageTransfer;
    }

    /**
     * Retreieve Store Name
     *
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     *
     * @throws
     *
     * @return string
     */
    protected function getStoreName(CategoryNodeStorageTransfer $categoryNodeStorageTransfer)
    {
        $categoryNodeEntity = SpyCategoryNodeQuery::create()
            ->filterByIdCategoryNode($categoryNodeStorageTransfer->getNodeId())
            ->findOne();

        $storeEntity = SpyStoreQuery::create()
            ->filterByIdStore($categoryNodeEntity->getFkStore())
            ->findOne();

        return $storeEntity->getName();
    }
}
