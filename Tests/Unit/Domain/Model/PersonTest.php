<?php
namespace CPSIT\Persons\Tests\Unit\Domain\Model;

use CPSIT\Persons\Domain\Model\Content;
use CPSIT\Persons\Domain\Model\Person;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Extbase\Domain\Model\Category;
use TYPO3\CMS\Extbase\Domain\Model\FileReference;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

/**
 * Test case.
 *
 * @author Dirk Wenzel <wenzel@cps-it.de>
 */
class PersonTest extends UnitTestCase
{
    /**
     * @var Person
     */
    protected $subject = null;

    protected function setUp()
    {
        parent::setUp();
        $this->subject = new Person();
    }

    protected function tearDown()
    {
        parent::tearDown();
    }

    /**
     * @test
     */
    public function getGenderReturnsInitialValueForInt()
    {
        $this->assertSame(
            Person::GENDER_UNKNOWN,
            $this->subject->getGender()
        );
    }

    /**
     * @test
     */
    public function setGenderForIntSetsGender()
    {
        $this->subject->setGender(Person::GENDER_FEMALE);
        $this->assertSame(
            Person::GENDER_FEMALE,
            $this->subject->getGender()
        );
    }

    /**
     * @test
     */
    public function getTitleReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function setTitleForStringSetsTitle()
    {
        $this->subject->setTitle('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getTitle()
        );
    }

    /**
     * @test
     */
    public function getFirstNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFirstName()
        );
    }

    /**
     * @test
     */
    public function setFirstNameForStringSetsFirstName()
    {
        $this->subject->setFirstName('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getFirstName()
        );
    }

    /**
     * @test
     */
    public function getLastNameReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getLastName()
        );
    }

    /**
     * @test
     */
    public function setLastNameForStringSetsLastName()
    {
        $this->subject->setLastName('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getLastName()
        );
    }

    /**
     * @test
     */
    public function getPositionReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPosition()
        );
    }

    /**
     * @test
     */
    public function setPositionForStringSetsPosition()
    {
        $this->subject->setPosition('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getPosition()
        );
    }

    /**
     * @test
     */
    public function getAddressReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getAddress()
        );
    }

    /**
     * @test
     */
    public function setAddressForStringSetsAddress()
    {
        $this->subject->setAddress('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getAddress()
        );
    }

    /**
     * @test
     */
    public function getZipReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getZip()
        );
    }

    /**
     * @test
     */
    public function setZipForStringSetsZip()
    {
        $this->subject->setZip('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getZip()
        );
    }

    /**
     * @test
     */
    public function getWwwReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getWww()
        );
    }

    /**
     * @test
     */
    public function setWwwForStringSetsWww()
    {
        $this->subject->setWww('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getWww()
        );
    }

    /**
     * @test
     */
    public function getCityReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getCity()
        );
    }

    /**
     * @test
     */
    public function setCityForStringSetsCity()
    {
        $this->subject->setCity('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getCity()
        );
    }

    /**
     * @test
     */
    public function getPhoneReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getPhone()
        );
    }

    /**
     * @test
     */
    public function setPhoneForStringSetsPhone()
    {
        $this->subject->setPhone('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getPhone()
        );
    }

    /**
     * @test
     */
    public function getFaxReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getFax()
        );
    }

    /**
     * @test
     */
    public function setFaxForStringSetsFax()
    {
        $this->subject->setFax('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getFax()
        );
    }

    /**
     * @test
     */
    public function getEmailReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function setEmailForStringSetsEmail()
    {
        $this->subject->setEmail('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getEmail()
        );
    }

    /**
     * @test
     */
    public function getBiographyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getBiography()
        );
    }

    /**
     * @test
     */
    public function setBiographyForStringSetsBiography()
    {
        $this->subject->setBiography('Conceived at T3CON10');

        self::assertSame(
            'Conceived at T3CON10',
            $this->subject->getBiography()
        );
    }

    /**
     * @test
     */
    public function getShortBiographyReturnsInitialValueForString()
    {
        self::assertSame(
            '',
            $this->subject->getShortBiography()
        );
    }

    /**
     * @test
     */
    public function setShortBiographyForStringSetsShortBiography()
    {
        $value = 'foo';
        $this->subject->setShortBiography($value);

        self::assertSame(
            $value,
            $this->subject->getShortBiography()
        );
    }

    /**
     * @test
     */
    public function getImageReturnsInitialValueForFileReference()
    {
        self::assertEquals(
            null,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function setImageForFileReferenceSetsImage()
    {
        $fileReferenceFixture = new FileReference();
        $this->subject->setImage($fileReferenceFixture);

        self::assertEquals(
            $fileReferenceFixture,
            $this->subject->getImage()
        );
    }

    /**
     * @test
     */
    public function getContentElementsReturnsInitialValueForContentElement()
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getContentElements()
        );
    }

    /**
     * @test
     */
    public function setContentElementsForObjectStorageContainingContentElementSetsContentElement()
    {
        $contentElement = new Content();
        $objectStorageHoldingExactlyOneContentElement = new ObjectStorage();
        $objectStorageHoldingExactlyOneContentElement->attach($contentElement);
        $this->subject->setContentElements($objectStorageHoldingExactlyOneContentElement);

        self::assertEquals(
            $objectStorageHoldingExactlyOneContentElement,
            $this->subject->getContentElements()
        );
    }

    /**
     * @test
     */
    public function addContentElementToObjectStorageHoldingContentElement()
    {
        $contentElement = new Content();
        $contentElementObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $contentElementObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($contentElement));
        $this->inject($this->subject, 'contentElements', $contentElementObjectStorageMock);

        $this->subject->addContentElement($contentElement);
    }

    /**
     * @test
     */
    public function removeContentElementFromObjectStorageHoldingContentElement()
    {
        $contentElement = new Content();
        $contentElementObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $contentElementObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($contentElement));
        $this->inject($this->subject, 'contentElements', $contentElementObjectStorageMock);

        $this->subject->removeContentElement($contentElement);
    }

    /**
     * @test
     */
    public function getCategoriesReturnsInitialValueForCategory()
    {
        $newObjectStorage = new ObjectStorage();
        self::assertEquals(
            $newObjectStorage,
            $this->subject->getCategories()
        );
    }

    /**
     * @test
     */
    public function setCategoriesForObjectStorageContainingCategorySetsCategories()
    {
        $category = new Category();
        $objectStorageHoldingExactlyOneCategory = new ObjectStorage();
        $objectStorageHoldingExactlyOneCategory->attach($category);
        $this->subject->setCategories($objectStorageHoldingExactlyOneCategory);

        self::assertEquals(
            $objectStorageHoldingExactlyOneCategory,
            $this->subject->getCategories()
        );
    }

    /**
     * @test
     */
    public function addCategoryToObjectStorageHoldingCategories()
    {
        $category = new Category();
        $categoriesObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['attach'])
            ->disableOriginalConstructor()
            ->getMock();

        $categoriesObjectStorageMock->expects(self::once())->method('attach')->with(self::equalTo($category));
        $this->inject($this->subject, 'categories', $categoriesObjectStorageMock);

        $this->subject->addCategory($category);
    }

    /**
     * @test
     */
    public function removeCategoryFromObjectStorageHoldingCategories()
    {
        $category = new Category();
        $categoriesObjectStorageMock = $this->getMockBuilder(ObjectStorage::class)
            ->setMethods(['detach'])
            ->disableOriginalConstructor()
            ->getMock();

        $categoriesObjectStorageMock->expects(self::once())->method('detach')->with(self::equalTo($category));
        $this->inject($this->subject, 'categories', $categoriesObjectStorageMock);

        $this->subject->removeCategory($category);
    }
}
