<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use org\bovigo\vfs\vfsStream;
use Orm\Zed\Category\Persistence\SpyCategory;
use Orm\Zed\Category\Persistence\SpyCategoryAttribute;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Spryker\Shared\Config\Config;

class CategoryKeyStorageMapperExpanderPluginTest extends Unit
{
    /**
     * @var \Generated\Shared\Transfer\CategoryNodeStorageTransfer|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $categoryNodeStorageTransferMock;

    /**
     * @var \Orm\Zed\Category\Persistence\SpyCategoryNode|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spyCategoryNodeMock;

    /**
     * @var \Orm\Zed\Category\Persistence\SpyCategory|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spyCategoryMock;

    /**
     * @var \Orm\Zed\Category\Persistence\SpyCategoryAttribute|\PHPUnit\Framework\MockObject\MockObject
     */
    protected $spyCategoryAttributeMock;

    /**
     * @return void
     */
    protected function _before()
    {
        $this->vfsStreamDirectory = vfsStream::setup('root', null, [
            'config' => [
                'Shared' => [
                    'stores.php' => file_get_contents(codecept_data_dir('stores.php')),
                    'config_default.php' => file_get_contents(codecept_data_dir('empty_config_default.php')),
                ],
            ],
        ]);

        $this->categoryNodeStorageTransferMock = $this->getMockBuilder(CategoryNodeStorageTransfer::class)
            ->disableOriginalConstructor()
            ->setMethods(['setCategoryKey'])
            ->getMock();

        $this->spyCategoryNodeMock = $this->getMockBuilder(SpyCategoryNode::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCategory'])
            ->getMock();

        $this->spyCategoryMock = $this->getMockBuilder(SpyCategory::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCategoryKey', 'fromArray'])
            ->getMock();

        $this->spyCategoryAttributeMock = $this->getMockBuilder(SpyCategoryAttribute::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    /**
     * @return void
     */
    public function testExpand(): void
    {
        $fileUrl = vfsStream::url('root/config/Shared/config_default.php');
        $newFileContent = file_get_contents(codecept_data_dir('config_default.php'));
        file_put_contents($fileUrl, $newFileContent);
        Config::getInstance()->init();

        $this->spyCategoryMock->fromArray(['categoryKey' => 'TEST_KEY'], true);

        $this->categoryNodeStorageTransferMock->expects($this->atLeastOnce())
            ->method('setCategoryKey')
            ->willReturnSelf();

        $this->spyCategoryNodeMock->expects($this->atLeastOnce())
            ->method('getCategory')
            ->willReturn($this->spyCategoryMock);

        $this->spyCategoryMock->expects($this->atLeastOnce())
            ->method('getCategoryKey')
            ->willReturn('TEST_KEY');

        $this->assertEquals('TEST_KEY', $this->spyCategoryMock->getCategoryKey());

        $categoryKeyStorageMapperExpanderPlugin = new CategoryKeyStorageMapperExpanderPlugin();
        $categoryKeyStorageMapperExpanderPlugin->expand(
            $this->categoryNodeStorageTransferMock,
            $this->spyCategoryNodeMock,
            $this->spyCategoryAttributeMock
        );
    }
}
