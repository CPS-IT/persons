<?php
declare(strict_types=1);
namespace CPSIT\Persons\Tests\Unit\Controller;

use CPSIT\Persons\Controller\PersonRepositoryTrait;
use CPSIT\Persons\Domain\Repository\PersonRepository;

/**
 * Trait PersonRepositoryTraitHelper
 *
 * @author Elias Häußler <e.haeussler@familie-redlich.de>
 */
class MockClassUsingPersonRepositoryTrait
{
    use PersonRepositoryTrait;

    /**
     * @return PersonRepository
     */
    public function getPersonRepository(): PersonRepository
    {
        return $this->personRepository;
    }
}