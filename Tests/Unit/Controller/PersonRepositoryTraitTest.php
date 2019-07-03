<?php
namespace CPSIT\Persons\Tests\Controller;

use Nimut\TestingFramework\TestCase\UnitTestCase;
use CPSIT\Persons\Controller\PersonRepositoryTrait;
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
     * @var \CPSIT\Persons\Controller\PersonRepositoryTrait
     */
    protected $subject;

    /**
     * set up
     *
     * @throws \ReflectionException
     */
    public function setUp()
    {
        $this->subject = $this->getMockForTrait(
            PersonRepositoryTrait::class
        );
    }

    /**
     * @test
     */
    public function PersonRepositoryCanBeInjected()
    {
        /** @var PersonRepository|\PHPUnit_Framework_MockObject_MockObject $personRepository */
        $personRepository = $this->getAccessibleMock(
            PersonRepository::class, [], [], '', false
        );

        $this->subject->injectPersonRepository($personRepository);

        $this->assertAttributeSame(
            $personRepository,
            'personRepository',
            $this->subject
        );
    }
}
