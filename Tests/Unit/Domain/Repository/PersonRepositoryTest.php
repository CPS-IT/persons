<?php
namespace CPSIT\Persons\Tests\Unit\Domain\Repository;

/***
 *
 * This file is part of the "Persons" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2017 Dirk Wenzel <wenzel@cps-it.de>
 *  (c) 2019 Elias Häußler <e.haeussler@familie-redlich.de>
 *
 ***/

use CPSIT\Persons\Domain\Repository\PersonRepository;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use TYPO3\CMS\Core\Database\Query\QueryBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;

/**
 * Class PersonRepositoryTest
 */
class PersonRepositoryTest extends UnitTestCase
{
    /**
     * @var PersonRepository|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject;

    /**
     * set up the subject
     */
    public function setUp()
    {
        $this->subject = $this->getMockBuilder(PersonRepository::class)
            ->disableOriginalConstructor()
            ->setMethods(['createQuery', 'getStoragePageIds', 'getQueryBuilder'])
            ->getMock();

        $storagePageIds = [1, 2];
        $this->subject->method('getStoragePageIds')->will($this->returnValue($storagePageIds));

        $queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $this->subject->method('getQueryBuilder')->will($this->returnValue($queryBuilderMock));
    }

    /**
     * provides data for testing creation of orderings
     */
    public function orderingsDataProvider()
    {
        return [
            // empty value, empty orderings
            ['', []],
            ['foo', ['foo' => QueryInterface::ORDER_ASCENDING]],
            ['foo|dEsC', ['foo' => QueryInterface::ORDER_DESCENDING]],
            ['foo|,bar|asc', ['foo' => QueryInterface::ORDER_ASCENDING, 'bar' => QueryInterface::ORDER_ASCENDING]],
        ];
    }

    /**
     * @test
     * @dataProvider orderingsDataProvider
     * @param string $orderList
     * @param array $expectedOrderings
     */
    public function createOrderingsFromDemandReturnsCorrectValues($orderList, $expectedOrderings)
    {
        $this->assertSame(
            $expectedOrderings,
            $this->subject->createOrderingsFromList($orderList)
        );
    }

    /**
     * @test
     */
    public function findMultipleByUidMatchesIds()
    {
        $this->markTestSkipped('Test not implemented yet.');

        $recordList = '3,5,1';
        $recordItems = GeneralUtility::trimExplode(',', $recordList, true);

        $queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $queryBuilderMock->expects($this->once())->method('add')->with(
            'orderBy',
            'FIELD(' . PersonRepository::TABLE_NAME . '.uid, ' . implode(',', $recordItems) . ')'
        );

        $this->subject->findMultipleByUid($recordList);
    }

    /**
     * @test
     */
    public function findMultipleByUidSetsOrderings()
    {
        $this->markTestSkipped('Test not implemented yet.');

        $recordList = '3,5,1';
        $orderList = 'foo';

        $queryBuilderMock = $this->getMockBuilder(QueryBuilder::class)
            ->disableOriginalConstructor()
            ->getMock();
        $queryBuilderMock->expects($this->once())->method('orderBy')
            ->with('foo', QueryInterface::ORDER_ASCENDING);

        $this->subject->findMultipleByUid($recordList, $orderList);
    }
}
