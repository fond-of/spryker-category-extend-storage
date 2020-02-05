<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use Orm\Zed\Category\Persistence\SpyCategory;
use Orm\Zed\Category\Persistence\SpyCategoryNode;

class CategoryKeyStorageMapperExpanderPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CategoryNodeStorageTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $categoryNodeStorageTransfer;

    /**
     * @var \Orm\Zed\Category\Persistence\SpyCategoryNode|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spyCategoryNode;

    /**
     * @var \Orm\Zed\Category\Persistence\SpyCategory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spyCategory;
    
    /**
     * @return void
     */
    protected function _before()
    {
        $this->categoryNodeStorageTransfer = $this->getMockBuilder(CategoryNodeStorageTransfer::class)
            ->disableOriginalConstructor()
            ->setMethods(['setCategoryKey'])
            ->getMock();

        $this->spyCategoryNode = $this->getMockBuilder(SpyCategoryNode::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCategory'])
            ->getMock();

        $this->spyCategory = $this->getMockBuilder(SpyCategory::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCategoryKey', 'fromArray'])
            ->getMock();
    }

    /**
     * @return void
     */
    public function testExpandSuccess()
    {
        $this->spyCategory->fromArray(['categoryKey' => 'TEST_KEY'], true);
        $categoryNodeStorageTransferData = [];

        $this->categoryNodeStorageTransfer->expects($this->atLeastOnce())
            ->method('setCategoryKey')
            ->willReturnSelf();
        
        $this->spyCategoryNode->expects($this->atLeastOnce())
            ->method('getCategory')
            ->willReturn($this->spyCategory);

        $this->spyCategory->expects($this->atLeastOnce())
            ->method('getCategoryKey')
            ->willReturn('TEST_KEY');

        $this->assertEquals('TEST_KEY', $this->spyCategory->getCategoryKey());

        $categoryKeyStorageMapperExpanderPlugin = new CategoryKeyStorageMapperExpanderPlugin();
        $categoryKeyStorageMapperExpanderPlugin->expand($this->categoryNodeStorageTransfer, $this->spyCategoryNode);
    }
}
