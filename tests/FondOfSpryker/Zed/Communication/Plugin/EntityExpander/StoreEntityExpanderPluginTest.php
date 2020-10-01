<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\EntityExpander;

use Codeception\Test\Unit;
use FondOfSpryker\Zed\CategoryExtendStorage\Communication\CategoryExtendStorageCommunicationFactory;
use FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeBridge;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage;
use Spryker\Shared\Kernel\Store;

class StoreEntityExpanderPluginTest extends Unit
{
    /**
     * @var \Spryker\Shared\Kernel\Store|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeMock;

    /**
     * @var \FondOfSpryker\Zed\CategoryExtendStorage\Communication\CategoryExtendStorageCommunicationFactory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $communicationFactoryMock;

    /**
     * @var \Generated\Shared\Transfer\StoreTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeTransferMock;

    /**
     * @var \FondOfSpryker\Zed\CategoryExtendStorage\Dependency\Facade\CategoryExtendStorageToStoreFacadeBridge|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $storeFacadeMock;

    /**
     * @var \Orm\Zed\CategoryStorage\Persistence\SpyCategoryNodeStorage|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $categoryNodeStorageEntityMock;

    /**
     * @var \FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\EntityExpander\StoreEntityExpanderPlugin
     */
    protected $storeEntityExpanderPlugin;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->communicationFactoryMock = $this->getMockBuilder(CategoryExtendStorageCommunicationFactory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeFacadeMock = $this->getMockBuilder(CategoryExtendStorageToStoreFacadeBridge::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->storeTransferMock = $this->getMockBuilder(StoreTransfer::class)
            ->disableOriginalConstructor()
            ->setMethods(['getName'])
            ->getMock();

        $this->storeMock = $this->getMockBuilder(Store::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->categoryNodeStorageEntityMock = $this->getMockBuilder(SpyCategoryNodeStorage::class)
            ->disableOriginalConstructor()
            ->setMethods(['setStore'])
            ->getMock();

        $this->storeEntityExpanderPlugin = new StoreEntityExpanderPlugin();
        $this->storeEntityExpanderPlugin->setFactory($this->communicationFactoryMock);
    }

    /**
     * @return void
     */
    public function testExpandSuccess()
    {
        $this->categoryNodeStorageEntityMock->expects($this->once())
            ->method('setStore');

        $this->communicationFactoryMock->expects($this->once())
            ->method('getStoreFacade')
            ->willReturn($this->storeFacadeMock);

        $this->storeFacadeMock->expects($this->once())
            ->method('getCurrentStore')
            ->willReturn($this->storeTransferMock);

        $this->storeTransferMock->expects($this->once())
            ->method('getName')
            ->willReturn('MY_STORE');

        $this->storeEntityExpanderPlugin->expand($this->categoryNodeStorageEntityMock);
    }
}
