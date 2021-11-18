<?php

namespace CPSIT\Persons\Unit\Service;

use CPSIT\Persons\Service\ImageService;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Core\Imaging\ImageManipulation\Area;
use TYPO3\CMS\Core\Imaging\ImageManipulation\CropVariantCollection;
use TYPO3\CMS\Core\Resource\File;
use TYPO3\CMS\Core\Resource\FileInterface;
use TYPO3\CMS\Core\Resource\ProcessedFile;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2017 Dirk Wenzel <wenzel@cps-it.de>
 *  All rights reserved
 *
 * The GNU General Public License can be found at
 * http://www.gnu.org/copyleft/gpl.html.
 * A copy is found in the text file GPL.txt and important notices to the license
 * from the author is found in LICENSE.txt distributed with these scripts.
 * This script is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 * This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class ImageServiceTest extends UnitTestCase
{
    /**
     * @var ImageService|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * set up subject
     */
    public function setUp()
    {
        $this->subject = $this->getMockBuilder(ImageService::class)
            ->disableOriginalConstructor()
            ->setMethods(['callStatic', 'applyProcessingInstructions'])->getMock();
    }

    /**
     * @param $referenceProperties
     * @return \PHPUnit_Framework_MockObject_MockObject|FileReference
     */
    protected function mockFileReference($referenceProperties = [])
    {
        $mockFile = $this->getMockBuilder(File::class)
            ->disableOriginalConstructor()
            ->setMethods(['getReferenceProperties'])->getMock();
        $mockCoreFileReference = $this->getMockBuilder(\TYPO3\CMS\Core\Resource\FileReference::class)
            ->disableOriginalConstructor()
            ->setMethods(['getOriginalFile', 'getReferenceProperties'])
            ->getMock();
        $mockCoreFileReference->expects($this->any())
            ->method('getOriginalFile')
            ->will($this->returnValue($mockFile));
        $mockCoreFileReference->expects($this->any())
            ->method('getReferenceProperties')
            ->will($this->returnValue($referenceProperties));

        /** @var FileReference|\PHPUnit_Framework_MockObject_MockObject $mockFileReference */
        $mockFileReference = $this->getMockBuilder(FileReference::class)
            ->disableOriginalConstructor()
            ->setMethods(['getOriginalResource'])
            ->getMock();
        $mockFileReference->expects($this->any())
            ->method('getOriginalResource')
            ->will($this->returnValue($mockCoreFileReference));
        return $mockFileReference;
    }

    /**
     * @return \PHPUnit_Framework_MockObject_MockObject|Area
     */
    protected function mockCropArea()
    {
        $mockCropArea = $this->getMockBuilder(Area::class)
            ->disableOriginalConstructor()
            ->getMock();
        $mockCropVariantsCollection = $this->getMockBuilder(CropVariantCollection::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCropArea'])->getMock();
        $this->subject->expects($this->once())
            ->method('callStatic')
            ->will($this->returnValue($mockCropVariantsCollection));

        $mockCropVariantsCollection->expects($this->any())
            ->method('getCropArea')
            ->willReturn($mockCropArea);

        return $mockCropArea;
    }

    /**
     * @test
     */
    public function getProcessingConfigurationReturnsDefaultConfiguration()
    {
        $defaultConfiguration = [
            'width' => 'm200',
            'height' => 'm200',
            'minWidth' => 50,
            'minHeight' => 50,
            'maxWidth' => 200,
            'maxHeight' => 200,
            'cropVariant' => 'default',
            'absoluteUri' => false
        ];

        $this->assertSame(
            $defaultConfiguration,
            $this->subject->getProcessingConfiguration()
        );
    }

    /**
     * @test
     */
    public function processingConfigurationCanBeSet()
    {
        $processingConfiguration = ['foo'];
        $this->subject->setProcessingConfiguration($processingConfiguration);

        $this->assertSame(
            $processingConfiguration,
            $this->subject->getProcessingConfiguration()
        );
    }

    /**
     * @test
     */
    public function getProcessedFileCreatesCropVariantsWithDefaultCropString()
    {
        $expectedCropString = '';
        $referenceProperties = [];

        $mockFileReference = $this->mockFileReference($referenceProperties);
        $mockCropVariantsCollection = $this->getMockBuilder(CropVariantCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subject->expects($this->once())
            ->method('callStatic')
            ->with(
                CropVariantCollection::class,
                'create',
                $expectedCropString
            )
            ->will($this->returnValue($mockCropVariantsCollection));

        $this->subject->getProcessedFile($mockFileReference);
    }

    /**
     * @test
     */
    public function getProcessedFileCreatesCropVariantsWithCropStringFromReferenceProperties()
    {
        $expectedCropString = 'bar';
        $referenceProperties = [
            'crop' => $expectedCropString
        ];

        $mockFileReference = $this->mockFileReference($referenceProperties);
        $mockCropVariantsCollection = $this->getMockBuilder(CropVariantCollection::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subject->expects($this->once())
            ->method('callStatic')
            ->with(
                CropVariantCollection::class,
                'create',
                $expectedCropString
            )
            ->will($this->returnValue($mockCropVariantsCollection));
        $this->subject->getProcessedFile($mockFileReference);
    }

    /**
     * @test
     */
    public function getProcessedFileGetsDefaultCropArea()
    {
        $expectedVariant = 'default';
        $referenceProperties = [];

        $mockFileReference = $this->mockFileReference($referenceProperties);

        $mockCropVariantsCollection = $this->getMockBuilder(CropVariantCollection::class)
            ->disableOriginalConstructor()
            ->setMethods(['getCropArea'])->getMock();
        $this->subject->expects($this->once())
            ->method('callStatic')
            ->will($this->returnValue($mockCropVariantsCollection));

        $mockCropVariantsCollection->expects($this->once())
            ->method('getCropArea')
            ->with($expectedVariant);

        $this->subject->getProcessedFile($mockFileReference);
    }

    /**
     * @test
     */
    public function getProcessedFileAppliesDefaultProcessingInstructionsAndReturnsProcessedFile()
    {
        $processedFile = $this->getMockBuilder(ProcessedFile::class)
            ->disableOriginalConstructor()->getMock();

        $expectedProcessingInstructions = [
            'width' => 'm200',
            'height' => 'm200',
            'minWidth' => 50,
            'minHeight' => 50,
            'maxWidth' => 200,
            'maxHeight' => 200,
            'crop' => null
        ];

        $mockFileReference = $this->mockFileReference();

        $this->mockCropArea();

        $this->subject->expects($this->once())
            ->method('applyProcessingInstructions')
            ->with($this->isInstanceOf(FileInterface::class), $expectedProcessingInstructions)
            ->willReturn($processedFile);

        $this->assertSame(
            $processedFile,
            $this->subject->getProcessedFile($mockFileReference)
        );
    }

    /**
     * Provides data for testing of valid processing configuration overwrite
     */
    public function validOverwriteProcessingConfigurationDataProvider()
    {
        return [
            'width, string' => [
                ['width' => '70']
            ],
            'height, string' => [
                ['height' => '70']
            ],
            'minWidth, integer' => [
                ['minWidth' => 70]
            ],
            'minHeigth, integer' => [
                ['minHeight' => 70]
            ],
            'maxWidth, integer' => [
                ['maxWidth' => 70]
            ],
            'maxHeight, integer' => [
                ['maxHeight' => 70]
            ],
            'cropVariant, string' => [
                ['cropVariant' => 'foo']
            ],
            'absoluteUri, boolean' => [
                ['absoluteUri' => true]
            ],
            'multiple values' => [
                [
                    'width' => '70',
                    'height' => '70',
                    'maxWidth' => 70,
                    'absoluteUri' => true
                ]
            ]
        ];
    }

    /**
     * @test
     * @dataProvider validOverwriteProcessingConfigurationDataProvider
     * @param array $configuration
     */
    public function overwriteProcessingConfigurationSetsValidValues(array $configuration)
    {
        $initialConfiguration = [];
        $this->subject->setProcessingConfiguration($initialConfiguration);

        $this->subject->overwriteProcessingConfiguration($configuration);
        $resultingConfiguration = $this->subject->getProcessingConfiguration();
        foreach ($configuration as $key => $value) {
            $this->assertArrayHasKey($key, $resultingConfiguration);
            $this->assertSame(
                $value,
                $resultingConfiguration[$key]
            );
        }
    }

    /**
     * @test
     */
    public function overwriteProcessingConfigurationDoesNotSetInvalidValues()
    {
        $initialConfiguration = [];
        $invalidKey = 'baz';

        $invalidConfiguration = [
            $invalidKey => 'foo'
        ];
        $this->subject->setProcessingConfiguration($initialConfiguration);

        $this->subject->overwriteProcessingConfiguration($invalidConfiguration);
        $resultingConfiguration = $this->subject->getProcessingConfiguration();

        $this->assertArrayNotHasKey($invalidKey, $resultingConfiguration);
        $this->assertSame(
            $initialConfiguration,
            $resultingConfiguration
        );
    }
}

