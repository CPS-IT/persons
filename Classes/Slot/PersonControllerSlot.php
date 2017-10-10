<?php

namespace CPSIT\Persons\Slot;

use CPSIT\Persons\CallStaticTrait;
use CPSIT\Persons\Utility\LocalizationUtility;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;

/***************************************************************
 *  Copyright notice
 *  (c) 2016 Dirk Wenzel <dirk.wenzel@cps-it.de>
 *  All rights reserved
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
class PersonControllerSlot implements SingletonInterface
{
    use CallStaticTrait;

    /**
     * Slot method name for signal PersonController::SIGNAL_FILTER_ACTION_BEFORE_ASSIGN
     */
    const SLOT_FILTER_ACTION_BEFORE_ASSIGN = 'handleFilterBeforeAssignSlot';

    /**
     * Slot method name for signal PersonController::SIGNAL_FILTER_ACTION_BEFORE_ASSIGN
     */
    const SLOT_LIST_ACTION_BEFORE_ASSIGN = 'handleListBeforeAssignSlot';

    const CONFIGURATION_KEY = 'configuration';
    const OPTIONS_KEY = 'options';
    const LOCALLANG_KEY = 'locallang';

    /**
     * Settings keys which should be transferred from TypoScript in filter action
     * @var array
     */
    static protected $settingsKeyToTransferInFilterAction = [
        'categories', 'visible', 'selected',
        'languageParam',
        'languageUid'
    ];

    /**
     * Settings keys which should be transferred from TypoScript in list action
     * @var array
     */
    static protected $settingsKeyToTransferInListAction = [
        'categories',
        'detailPid',
        'languageUid',
        'detailPid',
        'detailUrlPage',
        'detailUrlPerson',
        'detailUrlAction'
    ];


    /**
     * Returns keys which should be transferred from settings to options in filter action
     * @return array
     */
    static public function getKeysToTransferInFilterAction()
    {
        return static::$settingsKeyToTransferInFilterAction;
    }

    /**
     * Returns keys which should be transferred from settings to options in list action
     * @return array
     */
    static public function getKeysToTransferInListAction()
    {
        return static::$settingsKeyToTransferInListAction;
    }

    /**
     * Slot method for CPSIT\Persons\Controller\PersonController signal SIGNAL_FILTER_ACTION_BEFORE_ASSIGN
     *
     * @param array $params
     * @return array
     */
    public function handleFilterBeforeAssignSlot(array $params)
    {

        $params[static::CONFIGURATION_KEY] = $this->getConfiguration($params, static::$settingsKeyToTransferInFilterAction);

        return [$params];
    }

    /**
     * Slot method for CPSIT\Persons\Controller\PersonController signal SIGNAL_LIST_ACTION_BEFORE_ASSIGN
     *
     * @param array $params
     * @return array
     */
    public function handleListBeforeAssignSlot(array $params)
    {
        $params[static::CONFIGURATION_KEY] = $this->getConfiguration($params, static::$settingsKeyToTransferInListAction);

        return [$params];
    }

    /**
     * @param array $params
     * @return array
     */
    protected function getConfiguration(array $params, array $keys): array
    {
        $additionalConfiguration = [
            static::OPTIONS_KEY => [],
            static::LOCALLANG_KEY => $this->callStatic(LocalizationUtility::class, 'getAllLanguageKeys')
        ];
        foreach ($keys as $item) {
            if (!empty($params['settings'][$item])) {
                $additionalConfiguration[static::OPTIONS_KEY][$item] = $params['settings'][$item];
            }
        }

        $configuration = [];

        if (isset($params[static::CONFIGURATION_KEY]) && is_array($params[static::CONFIGURATION_KEY])) {
            $configuration = $params[static::CONFIGURATION_KEY];
        }

        ArrayUtility::mergeRecursiveWithOverrule($configuration, $additionalConfiguration);

        return $configuration;
    }
}
