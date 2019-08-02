<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\EntityExpander;

use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;

interface EntityExpanderPluginInterface
{
    /**
     * @param \Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage $categoryNodeStorageEntity
     *
     * @return void
     */
    public function expand(SpyCategoryNodeStorage $categoryNodeStorageEntity): void;
}
