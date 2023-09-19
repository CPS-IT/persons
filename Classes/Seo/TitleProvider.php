<?php

declare(strict_types=1);

namespace CPSIT\Persons\Seo;

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
use TYPO3\CMS\Core\PageTitle\AbstractPageTitleProvider;

class TitleProvider extends AbstractPageTitleProvider
{
    private ?Person $person = null;

    public function setPerson(Person $person): void
    {
        $this->person = $person;
        $this->title = $person->getFirstName() . ' ' . $person->getLastName();
    }
}
