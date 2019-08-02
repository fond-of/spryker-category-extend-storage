<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Business\Plugin\EntityExpander;

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
