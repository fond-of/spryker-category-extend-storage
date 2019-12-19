<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage;

use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\Business\Storage\CategoryTreeStorage as SprykerCategoryTreeStorage;
use Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface;
use Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface;
use Spryker\Zed\Store\Business\StoreFacadeInterface;

class CategoryTreeExtendStorage extends SprykerCategoryTreeStorage
{
    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * CategoryTreeExtendStorage constructor.
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
    ){
        parent::__construct($queryContainer, $utilSanitize, $store, $isSendingToQueue);
        $this->storeFacade = $storeFacade;
    }

    /**
     * @return array
     */
    protected function findCategoryStorageEntities(): array
    {
        $storeName = $this->storeFacade->getCurrentStore()->getName();

        $spyCategoryStorageEntities = $this->queryContainer->queryCategoryStorage()->filterByStore($storeName)->find();
        $categoryStorageEntitiesByLocale = [];
        foreach ($spyCategoryStorageEntities as $spyCategoryStorageEntity) {
            $categoryStorageEntitiesByLocale[$spyCategoryStorageEntity->getLocale()] = $spyCategoryStorageEntity;
        }

        return $categoryStorageEntitiesByLocale;
    }
}
