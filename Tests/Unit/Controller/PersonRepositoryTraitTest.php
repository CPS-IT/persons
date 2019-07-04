<?php
namespace CPSIT\Persons\Tests\Controller;

use CPSIT\Persons\Tests\Unit\Controller\MockClassUsingPersonRepositoryTrait;
use Nimut\TestingFramework\TestCase\UnitTestCase;
use CPSIT\Persons\Domain\Repository\PersonRepository;

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

/**
 * Class PersonRepositoryTraitTest
 */
class PersonRepositoryTraitTest extends UnitTestCase
{
    /**
     * @var MockClassUsingPersonRepositoryTrait
     */
    protected $subject;

    /**
     * set up
     */
    public function setUp()
    {
        $this->subject = new MockClassUsingPersonRepositoryTrait();
    }

    /**
     * @test
     */
    public function PersonRepositoryCanBeInjected()
    {
        /** @var PersonRepository|\PHPUnit_Framework_MockObject_MockObject $personRepository */
        $personRepository = $this->getMockBuilder(PersonRepository::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subject->injectPersonRepository($personRepository);

        self::assertSame(
            $personRepository,
            $this->subject->getPersonRepository()
        );
    }
}
