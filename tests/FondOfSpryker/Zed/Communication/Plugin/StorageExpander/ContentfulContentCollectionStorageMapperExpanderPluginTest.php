<?php

namespace FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander;

use Codeception\Test\Unit;
use Generated\Shared\Transfer\CategoryNodeStorageTransfer;
use org\bovigo\vfs\vfsStream;
use Orm\Zed\Category\Persistence\SpyCategory;
use Orm\Zed\Category\Persistence\SpyCategoryAttribute;
use Orm\Zed\Category\Persistence\SpyCategoryNode;
use Spryker\Shared\Config\Config;

class ContentfulContentCollectionStorageMapperExpanderPluginTest extends Unit
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
     * @var \FondOfSpryker\Zed\CategoryExtendStorage\Communication\Plugin\StorageExpander\ContentfulContentCollectionStorageMapperExpanderPlugin
     */
    protected $contentfulContentCollectionStorageMapperExpanderPlugin;

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
            ->setMethods(['setContentfulContentCollection'])
            ->getMock();

        $this->spyCategoryNodeMock = $this->getMockBuilder(SpyCategoryNode::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCategory'])
            ->getMock();

        $this->spyCategoryMock = $this->getMockBuilder(SpyCategory::class)
            ->disableOriginalConstructor()
            ->setMethods(['getContentfulContentCollection'])
            ->getMock();

        $this->spyCategoryAttributeMock = $this->getMockBuilder(SpyCategoryAttribute::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->contentfulContentCollectionStorageMapperExpanderPlugin = new ContentfulContentCollectionStorageMapperExpanderPlugin();
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

        $this->categoryNodeStorageTransferMock->expects($this->once())
            ->method('setContentfulContentCollection')
            ->willReturnSelf();

        $this->spyCategoryNodeMock->expects($this->once())
            ->method('getCategory')
            ->willReturn($this->spyCategoryMock);

        $this->spyCategoryMock->expects($this->once())
            ->method('getContentfulContentCollection')
            ->willReturn('CONTENTFUL_ID');

        $this->contentfulContentCollectionStorageMapperExpanderPlugin->expand(
            $this->categoryNodeStorageTransferMock,
            $this->spyCategoryNodeMock,
            $this->spyCategoryAttributeMock
        );
    }
}
