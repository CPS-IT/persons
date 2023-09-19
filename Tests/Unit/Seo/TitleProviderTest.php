<?php

declare(strict_types=1);

namespace CPSIT\Persons\Tests\Unit\Seo;

/***
 *
 * This file is part of the "Persons" Extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 *  (c) 2023 Daniel Siepmann <coding@daniel-siepmann.de>
 *
 ***/

use CPSIT\Persons\Domain\Model\Person;
use CPSIT\Persons\Seo\TitleProvider;
use PHPUnit\Framework\TestCase;

/**
 * @covers \CPSIT\Persons\Seo\TitleProvider
 */
final class TitleProviderTest extends TestCase
{
    /**
     * @test
     */
    public function canBeCreated(): void
    {
        $subject = new TitleProvider();

        self::assertInstanceOf(
            TitleProvider::class,
            $subject
        );
    }

    /**
     * @test
     */
    public function returnsDefaultTitle(): void
    {
        $person = $this->createMock(Person::class);
        $person->method('getFirstName')->willReturn('John');
        $person->method('getLastName')->willReturn('Doe');

        $subject = new TitleProvider();
        $subject->setPerson($person);

        self::assertSame('John Doe', $subject->getTitle());
    }

    /**
     * @test
     */
    public function returnsFallbackIfPersonWasNotSet(): void
    {
        $subject = new TitleProvider();

        self::assertSame('', $subject->getTitle());
    }
}
