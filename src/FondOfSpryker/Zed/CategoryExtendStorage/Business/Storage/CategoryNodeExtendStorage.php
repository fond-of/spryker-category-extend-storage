<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage;

use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\Business\Storage\CategoryNodeStorage as SprykerCategoryNodeStorage;
use Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface;
use Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class CategoryNodeExtendStorage extends SprykerCategoryNodeStorage
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @param \Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface $utilSanitize
     * @param \Spryker\Shared\Kernel\Store $store
     * @param $isSendingToQueue
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     */
    public function __construct(
        CategoryStorageQueryContainerInterface $queryContainer,
        CategoryStorageToUtilSanitizeServiceInterface $utilSanitize,
        Store $store,
        $isSendingToQueue,
        StoreFacadeInterface $storeFacade
    ) {
        parent::__construct($queryContainer, $utilSanitize, $store, $isSendingToQueue);
        $this->storeFacade = $storeFacade;
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
     * @return void
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
     * @throws \Propel\Runtime\Exception\PropelException
     */
    protected function storeDataSet(
        CategoryNodeStorageTransfer $categoryNodeStorageTransfer,
        $localeName,
        ?SpyCategoryNodeStorage $spyCategoryNodeStorageEntity = null
    ): void
    {
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
}
