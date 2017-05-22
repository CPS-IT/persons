<?php

namespace CPSIT\Persons\Tests\Unit\Domain\Model\Dto;

/**
 * This file is part of the "Persons" project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Test case for class \CPSIT\Persons\Domain\Model\Dto\AbstractDemand.
 */
class AbstractDemandTest extends \Nimut\TestingFramework\TestCase\UnitTestCase
{

    /**
     * @var \CPSIT\Persons\Domain\Model\Dto\AbstractDemand
     */
    protected $fixture;

    public function setUp()
    {
        $this->fixture = new \CPSIT\Persons\Domain\Model\Dto\AbstractDemand();
    }

    public function tearDown()
    {
        unset($this->fixture);
    }

    /**
     * @test
     * @covers ::getLimit
     */
    public function getLimitReturnsInitialValueForInteger()
    {
        $this->assertSame(100, $this->fixture->getLimit());
    }

    /**
     * @test
     * @covers ::setLimit
     */
    public function setLimitForIntegerSetsLimit()
    {
        $this->fixture->setLimit(3);
        $this->assertSame(3, $this->fixture->getLimit());
    }

    /**
     * @test
     * @covers ::setLimit
     */
    public function setLimitCastsStringToInteger()
    {
        $this->fixture->setLimit('2');
        $this->assertInternalType(
            'int',
            $this->fixture->getLimit()
        );
    }

    /**
     * @test
     * @covers ::setLimit
     */
    public function setLimitValidatesLimitGreaterThanZero()
    {
        $this->fixture->setLimit(-1);
        $this->assertSame(
            100,
            $this->fixture->getLimit()
        );
    }

    /**
     * @test
     * @covers ::getOffset
     */
    public function getOffsetReturnsInitialNull()
    {
        $this->assertNull($this->fixture->getOffset());
    }

    /**
     * @test
     * @covers ::setOffset
     */
    public function setOffsetSetsDefaultValueZeroForInteger()
    {
        $this->fixture->setOffset();
        $this->assertSame(
            0,
            $this->fixture->getOffset());
    }

    /**
     * @test
     * @covers ::setOffset
     */
    public function setOffsetSetsOffsetForInteger()
    {
        $this->fixture->setOffset(99);
        $this->assertSame(
            99,
            $this->fixture->getOffset());
    }

    /**
     * @test
     * @covers ::getSortDirection
     */
    public function getSortDirectionReturnsInitialNull()
    {
        $this->assertNull($this->fixture->getSortDirection());
    }

    /**
     * @test
     * @covers ::setSortDirection
     */
    public function setSortDirectionForStringSetsSort()
    {
        $this->fixture->setSortDirection('baz');
        $this->assertSame(
            'baz',
            $this->fixture->getSortDirection()
        );
    }

    /**
     * @test
     * @covers ::getSortBy
     */
    public function getSortByReturnsInitiallyNull()
    {
        $this->assertNull($this->fixture->getSortBy());
    }

    /**
     * @test
     * @covers ::setSortBy
     */
    public function setSortByForStringSetsSortBy()
    {
        $this->fixture->setSortBy('my.sort.string.with.dots');
        $this->assertSame(
            'my.sort.string.with.dots',
            $this->fixture->getSortBy()
        );
    }

    /**
     * @test
     * @covers ::getStoragePages
     */
    public function getStoragePagesReturnsInitialNull()
    {
        $this->assertNull($this->fixture->getStoragePages());
    }

    /**
     * @test
     * @covers ::setStoragePages
     */
    public function setStoragePagesForStringSetsStoragePages()
    {
        $this->fixture->setStoragePages('15,78,39');
        $this->assertSame('15,78,39', $this->fixture->getStoragePages());
    }

    /**
     * @test
     * @covers ::getUidList
     */
    public function getUidListReturnsInitialNull()
    {
        $this->assertNull($this->fixture->getUidList());
    }

    /**
     * @test
     * @covers ::setUidList
     */
    public function setUidListForStringSetsUidList()
    {
        $this->fixture->setUidList('1,3,5');
        $this->assertSame('1,3,5', $this->fixture->getUidList());
    }

    /**
     * @test
     * @covers ::getCategoryConjunction
     */
    public function getCategoryConjunctionReturnsInitialNull()
    {
        $this->assertEquals(
            NULL,
            $this->fixture->getCategoryConjunction()
        );
    }

    /**
     * @test
     * @covers ::setCategoryConjunction
     */
    public function setCategoryConjunctionForStringSetsCategoryConjunction()
    {
        $this->fixture->setCategoryConjunction('asc');

        $this->assertSame(
            'asc',
            $this->fixture->getCategoryConjunction()
        );
    }

    /**
     * @test
     * @covers ::getConstraintsConjunction
     */
    public function getConstraintsConjunctionReturnsInitialNull()
    {
        $this->assertEquals(
            NULL,
            $this->fixture->getConstraintsConjunction()
        );
    }

    /**
     * @test
     * @covers ::setConstraintsConjunction
     */
    public function setConstraintsConjunctionForStringSetsConstraintsConjunction()
    {
        $conjunction = 'foo';
        $this->fixture->setConstraintsConjunction($conjunction);

        $this->assertSame(
            $conjunction,
            $this->fixture->getConstraintsConjunction()
        );
    }

    /**
     * @test
     * @covers ::getOrder
     */
    public function getOrderReturnsInitialNull()
    {
        $this->assertEquals(
            NULL,
            $this->fixture->getOrder()
        );
    }

    /**
     * @test
     * @covers ::setOrder
     */
    public function setOrderForStringSetsCategoryConjunction()
    {
        $order = 'fieldA|asc,fieldB|desc';
        $this->fixture->setOrder($order);

        $this->assertSame(
            $order,
            $this->fixture->getOrder()
        );
    }
}