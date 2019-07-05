<?php

namespace CPSIT\Persons\Controller;

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

use CPSIT\Persons\Domain\Model\Person;
use TYPO3\CMS\Extbase\Configuration\Exception\InvalidConfigurationTypeException;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotException;
use TYPO3\CMS\Extbase\SignalSlot\Exception\InvalidSlotReturnException;

/**
 * PersonController
 */
class PersonController extends ActionController
{
    use PersonRepositoryTrait, SignalTrait;

    const SIGNAL_FILTER_ACTION_BEFORE_ASSIGN = 'filterBeforeAssign';
    const SIGNAL_LIST_ACTION_BEFORE_ASSIGN = 'listBeforeAssign';

    /**
     * action list
     *
     * @throws InvalidSlotException
     * @throws InvalidSlotReturnException
     */
    public function listAction(): void
    {
        $persons = $this->personRepository->findAll();

        $templateVariables = [
            'persons' => $persons,
            'settings' => $this->settings
        ];
        $this->emitSignal(
            __CLASS__,
            static::SIGNAL_LIST_ACTION_BEFORE_ASSIGN,
            $templateVariables
        );
        $this->view->assignMultiple($templateVariables);
    }

    /**
     * action show
     *
     * @param Person $person
     */
    public function showAction(Person $person): void
    {
        $this->view->assign('person', $person);
    }

    /**
     * Action show selected
     * Displays one ore more persons selected in plugin
     *
     * @throws InvalidConfigurationTypeException
     */
    public function showSelectedAction(): void
    {
        $persons = $this->personRepository->findMultipleByUid($this->settings['selectedPersons']);
        $this->view->assign('persons', $persons);
    }

    /**
     * Action filter
     * Display filter for list view
     */
    public function filterAction(): void
    {
        $templateVariables = [
            'categories' => $this->settings['categories'],
            'visible' => $this->settings['visible'],
            'settings' => $this->settings
        ];

        $this->emitSignal(
            __CLASS__,
            static::SIGNAL_FILTER_ACTION_BEFORE_ASSIGN,
            $templateVariables
        );
        $this->view->assignMultiple($templateVariables);
    }
}
