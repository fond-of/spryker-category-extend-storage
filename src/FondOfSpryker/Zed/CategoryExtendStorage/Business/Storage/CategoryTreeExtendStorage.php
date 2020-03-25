<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business\Storage;

use FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryTreeStorage;
use Generated\Shared\Transfer\CategoryTreeStorageTransfer;
use Spryker\Shared\Kernel\Store;
use Spryker\Zed\CategoryStorage\Business\Storage\CategoryTreeStorage as SprykerCategoryTreeStorage;
use Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface;
use Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface;

class CategoryTreeExtendStorage extends SprykerCategoryTreeStorage
{
    /**
     * @var \FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface
     */
    protected $storeFacade;

    /**
     * @param \Spryker\Zed\CategoryStorage\Persistence\CategoryStorageQueryContainerInterface $queryContainer
     * @param \Spryker\Zed\CategoryStorage\Dependency\Service\CategoryStorageToUtilSanitizeServiceInterface $utilSanitize
     * @param \Spryker\Shared\Kernel\Store $store
     * @param bool $isSendingToQueue
     * @param \FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeInterface $storeFacade
     */
    public function __construct(
        CategoryStorageQueryContainerInterface $queryContainer,
        CategoryStorageToUtilSanitizeServiceInterface $utilSanitize,
        Store $store,
        bool $isSendingToQueue,
        CategoryExtendStorageToStoreFacadeInterface $storeFacade
    ) {
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

    /**
     * @return array
     */
    protected function getCategoryTrees()
    {
        $currentStoreId = $this->storeFacade->getCurrentStore()->getIdStore();
        $localeNames = $this->getSharedPersistenceLocaleNames();
        $locales = $this->queryContainer->queryLocalesWithLocaleNames($localeNames)->find();

        $rootCategory = $this->queryContainer->queryCategoryRoot()->findOne();
        $categoryNodeTree = [];
        $this->disableInstancePooling();
        foreach ($locales as $locale) {
            $categoryNodes = $this->queryContainer->queryCategoryNodeTree($locale->getIdLocale())->filterByFkStore($currentStoreId)->find()->getData();
            $categoryNodeTree[$locale->getLocaleName()] = $this->getChildren(
                $rootCategory->getIdCategoryNode(),
                $categoryNodes
            );
        }
        $this->enableInstancePooling();

        foreach ($categoryNodeTree as $key => $data) {
            if (count($data) === 0) {
                unset($categoryNodeTree[$key]);
            }
        }

        return $categoryNodeTree;
    }

    /**
     * @param \Generated\Shared\Transfer\CategoryNodeStorageTransfer[] $categoryNodeStorageTransfers
     * @param string $localeName
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryTreeStorage|null $spyCategoryTreeStorage
     *
     * @return void
     */
    protected function storeDataSet(
        array $categoryNodeStorageTransfers,
        $localeName,
        ?SpyCategoryTreeStorage $spyCategoryTreeStorage = null
    ) {
        if ($spyCategoryTreeStorage === null) {
            $spyCategoryTreeStorage = new SpyCategoryTreeStorage();
        }

        $spyCategoryTreeStorage->setStore($this->storeFacade->getCurrentStore()->getName());
        parent::storeDataSet($categoryNodeStorageTransfers, $localeName, $spyCategoryTreeStorage);
    }

    /**
     * @return string[]
     */
    protected function getSharedPersistenceLocaleNames(): array
    {
        $localeNames = $this->store->getLocales();
        foreach ($this->store->getStoresWithSharedPersistence() as $storeName) {
            foreach ($this->store->getLocalesPerStore($storeName) as $localeName) {
                $localeNames[] = $localeName;
            }
        }

        return array_unique($localeNames);
    }

}
