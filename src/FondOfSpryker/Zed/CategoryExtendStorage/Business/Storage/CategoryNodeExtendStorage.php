<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage;

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
    private $storeFacade;

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
    public function publish(array $categoryNodeIds)
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
    public function unpublish(array $categoryNodeIds)
    {
        $categoryNodeIds = $this->reduceCategoryNodeIdsByStore($categoryNodeIds);

        parent::unpublish($categoryNodeIds);
    }

    /**
     * @return void
     */
    protected function reduceCategoryNodeIdsByStore(array $categoryNodeIds): array
    {
        $store = $this->storeFacade->getCurrentStore();
        $this->queryContainer->queryCategoryNodeByIds($categoryNodeIds)->filterByFkStore($store->getIdStore());
    }
}
