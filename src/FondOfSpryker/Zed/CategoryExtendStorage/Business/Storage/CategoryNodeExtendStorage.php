<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage;

use FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface;
use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\Business\Storage\CategoryNodeStorage as SprykerCategoryNodeStorage;
use Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface;
use Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface;

class CategoryNodeExtendStorage extends SprykerCategoryNodeStorage
{
    /**
     * @var \FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface 
     */
    protected $storeFacade;

    /**
     * @var \FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\StorageExpanderPluginInterface[]
     */
    protected $storageMapperExpanderPlugins;

    /**
     * @param \Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface $utilSanitize
     * @param \Spryker\Shared\Kernel\Store $store
     * @param bool $isSendingToQueue
     * @param \FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface $storeFacade
     * @param array|\FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\StorageExpanderPluginInterface[] $storageMapperExpanderPlugins
     */
    public function __construct(
        CategoryStorageQueryContainerInterface $queryContainer,
        CategoryStorageToUtilSanitizeServiceInterface $utilSanitize,
        Store $store,
        bool $isSendingToQueue,
        CategoryExtendStorageToStoreFacadeInterface $storeFacade,
        array $storageMapperExpanderPlugins
    ) {
        parent::__construct($queryContainer, $utilSanitize, $store, $isSendingToQueue);
        $this->storeFacade = $storeFacade;
        $this->storageMapperExpanderPlugins = $storageMapperExpanderPlugins;
    }

    /**
     * @return void
     */
    public function publish(array $categoryNodeIds): void
    {
        $categoryNodeIds = $this->reduceCategoryNodeIdsByStore($categoryNodeIds);

        $categoryNodes = $this->getCategoryNodes($categoryNodeIds);
        $spyCategoryNodeStorageEntities = $this->findCategoryNodeStorageEntitiesByCategoryNodeIds($categoryNodeIds);

        if (!$categoryNodes) {
            $this->deleteStorageData($spyCategoryNodeStorageEntities);
        }

        $this->storeData($categoryNodes, $spyCategoryNodeStorageEntities);
    }

    /**
     * @return void
     */
    public function unpublish(array $categoryNodeIds): void
    {
        $categoryNodeIds = $this->reduceCategoryNodeIdsByStore($categoryNodeIds);

        parent::unpublish($categoryNodeIds);
    }

    /**
     * @return array
     */
    protected function reduceCategoryNodeIdsByStore(array $categoryNodeIds): array
    {
        $currentStore = $this->storeFacade->getCurrentStore();
        $categoryNodeIdsByStoreQuery = $this->queryContainer
            ->queryCategoryNodeByIds($categoryNodeIds)
            ->filterByFkStore($currentStore->getIdStore());
        $categoryNodeIdsByStore = $categoryNodeIdsByStoreQuery->find()->getColumnValues('idCategoryNode');

        return $categoryNodeIdsByStore;
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer $categoryNodeStorageTransfer
     * @param string $localeName
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage|null $spyCategoryNodeStorageEntity
     *
     * @return void
     */
    protected function storeDataSet(
        CategoryNodeStorageTransfer $categoryNodeStorageTransfer,
        $localeName,
        ?SpyCategoryNodeStorage $spyCategoryNodeStorageEntity = null
    ): void {
        if ($spyCategoryNodeStorageEntity === null) {
            $spyCategoryNodeStorageEntity = new SpyCategoryNodeStorage();
        }

        $storeName = $this->storeFacade->getCurrentStore()->getName();
        $spyCategoryNodeStorageEntity->setStore($storeName);

        parent::storeDataSet(
            $categoryNodeStorageTransfer,
            $localeName,
            $spyCategoryNodeStorageEntity
        );
    }

    /**
     * @param  array  $categoryNodes
     * @param  \Orm\Zed\Category\Persistence\SpyCategoryNode  $categoryNode
     * @param  bool  $includeChildren
     * @param  bool  $includeParents
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
}
