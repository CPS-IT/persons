<?php

namespace CPSIT\Persons\Tests\Unit\View;

/***
 *
 * This file is part of the "Persons" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Dirk Wenzel <wenzel@cps-it.de>
 *
 ***/
use CPSIT\Persons\Service\ImageService;
use CPSIT\Persons\View\AbstractJsonView;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Mvc\Controller\ControllerContext;
use TYPO3\CMS\Extbase\Persistence\Generic\LazyLoadingProxy;

class MockFileReference
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}

/**
 * Class AbstractJsonViewTest
 */
class AbstractJsonViewTest extends UnitTestCase
{
    /**
     * @var AbstractJsonView|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * @var ControllerContext|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $controllerContext;

    /**
     * @var ImageService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $imageService;

    protected $processedFile;

    /**
     * set up subject
     */
    public function setUp()
    {

        $this->controllerContext = $this->getMockBuilder(ControllerContext::class)
            ->disableOriginalConstructor()->getMock();

        $this->processedFile = $this->getMockBuilder(ProcessedFile::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->imageService = $this->getMockBuilder(ImageService::class)
            ->disableOriginalConstructor()
            ->setMethods(['getProcessedFile', 'getImageUri', 'setProcessingConfiguration'])
            ->getMock();
        $this->imageService->expects($this->any())
            ->method('getProcessedFile')
            ->will($this->returnValue($this->processedFile));
        $this->subject = new AbstractJsonView($this->imageService);
        $this->subject->setControllerContext($this->controllerContext);
    }

    /**
     * @test
     */
    public function renderLoadsRealInstanceOfLazyLoadingProxy()
    {
        $realObject = new \stdClass();
        $lazyObject = $this->getMockBuilder(LazyLoadingProxy::class)->disableOriginalConstructor()
            ->setMethods(['_loadRealInstance'])->getMockForAbstractClass();
        $lazyObject->expects($this->once())
            ->method('_loadRealInstance')
            ->will($this->returnValue($realObject));

        $this->subject->assign('foo', $lazyObject);

        $variablesToRender = ['foo'];
        $configuration = [
            'foo' => ['_descendAll' => []]
        ];
        $this->subject->setVariablesToRender($variablesToRender);
        $this->subject->setConfiguration($configuration);

        $this->subject->render();
    }

    /**
     * @test
     */
    public function renderTransformsFileReference()
    {
        $title = 'bar';
        /** @var \TYPO3\CMS\Core\Resource\FileReference|\PHPUnit_Framework_MockObject_MockObject $originalResource */
        $originalResource = $this->getMockBuilder(MockFileReference::class)
            ->setMethods(['getTitle'])->disableOriginalConstructor()->getMock();


        $object = $this->getMockBuilder(FileReference::class)
            ->disableOriginalConstructor()->setMethods(['getOriginalResource'])->getMock();
        $object->expects($this->atLeastOnce())->method('getOriginalResource')
            ->will($this->returnValue($originalResource));

        $this->subject->assign('foo', $object);

        $variablesToRender = ['foo'];
        $configuration = [
            'foo' => [
                '_exclude' => ['pid', 'uid'],
                '_descend' => [
                    '_only' => ['title']
                ]
            ]
        ];
        $originalResource->expects($this->once())->method('getTitle')
            ->will($this->returnValue($title));

        $expected = json_encode(
            ['title' => $title]
        );
        $this->subject->setVariablesToRender($variablesToRender);
        $this->subject->setConfiguration($configuration);

        $this->assertSame(
            $expected,
            $this->subject->render()
        );
    }

    /**
     * @test
     */
    public function settingsInitiallyIsEmptyArray()
    {
        $expectedSettings = [];

        self::assertSame(
            $expectedSettings,
            $this->subject->getSettings()
        );
    }

    /**
     * @test
     */
    public function settingsCanBeInjected() {
        $expectedSettings = ['foo'];
        $this->subject->injectSettings($expectedSettings);

        self::assertSame(
            $expectedSettings,
            $this->subject->getSettings()
        );
    }

    /**
     * @test
     */
    public function renderProcessesFileReferenceIfEnabledInSettings()
    {
        $settings = [
            AbstractJsonView::IMAGE_PROCESSING_KEY => [
                'non empty configuration'
            ]
        ];
        $originalResource = new \stdClass();
        $expectedUri = 'foo/uri';
        $uriWithLeadingSlash = DIRECTORY_SEPARATOR . $expectedUri;

        $expectedJson = json_encode(['uri' => $expectedUri]);

        $this->subject->injectSettings($settings);
        $object = $this->getMockBuilder(FileReference::class)
            ->disableOriginalConstructor()->setMethods(['getOriginalResource'])->getMock();
        $object->method('getOriginalResource')
            ->willReturn($originalResource);

        $this->subject->assign('foo', $object);

        $variablesToRender = ['foo'];
        $configuration = [
            'foo' => [
                '_exclude' => ['pid', 'uid'],
                '_descend' => [
                    '_only' => ['bar']
                ]
            ]
        ];
        $this->subject->setVariablesToRender($variablesToRender);
        $this->subject->setConfiguration($configuration);

        $this->imageService->expects($this->once())
            ->method('getProcessedFile')
            ->will($this->returnValue($this->processedFile));

        $this->imageService->expects($this->once())
            ->method('getImageUri')
            ->will($this->returnValue($uriWithLeadingSlash));

        $this->assertSame(
            $expectedJson,
            $this->subject->render()
        );
    }
}
