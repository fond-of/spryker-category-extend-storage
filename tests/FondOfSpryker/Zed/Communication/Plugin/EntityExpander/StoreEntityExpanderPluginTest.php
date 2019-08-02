<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\EntityExpander;

use Codeception\Test\Unit;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Spryker\Shared\Kernel\Store;

class StoreEntityExpanderPluginTest extends Unit
{
    /**
     * @var \Spryker\Shared\Kernel\Store|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeMock;

    /**
     * @var \Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $categoryNodeStorageEntityMock;

    protected function _before()
    {
        $this->storeMock = $this->getMockBuilder(Store::class)
            ->disableOriginalConstructor()
            ->setMethods(['getStoreName'])
            ->getMock();

        $this->categoryNodeStorageEntityMock = $this->getMockBuilder(SpyCategoryNodeStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['setStore'])
            ->getMock();
    }

    public function testExpandSuccess()
    {
        $this->categoryNodeStorageEntityMock->expects($this->atLeastOnce())
            ->method('setStore');

        $storeEntityExpanderPlugin = new StoreEntityExpanderPlugin($this->storeMock);
        $storeEntityExpanderPlugin->expand($this->categoryNodeStorageEntityMock);
    }
}
