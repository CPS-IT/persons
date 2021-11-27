<?php
defined('TYPO3_MODE') || die('Access denied.');

call_user_func(
    function () {
        \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
            'CPSIT.Persons',
            'Persons',
            [
                'Person' => 'list, show, showSelected,filter'
            ],
            // non-cacheable actions
            [
                'Person' => ''
            ]
        );

        if (TYPO3_MODE === 'BE') {
            $icons = [
                'ext-persons-wizard-icon' => 'icon-persons.svg',
            ];
            $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
            foreach ($icons as $identifier => $path) {
                $iconRegistry->registerIcon(
                    $identifier,
                    \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
                    ['source' => 'EXT:persons/Resources/Public/Icons/' . $path]
                );
            }
        }

        // wizards
        \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
            '@import "EXT:persons/Configuration/TSconfig/ContentElementWizard.tsconfig"');

        // connect slots to signals
        /** @var \TYPO3\CMS\Extbase\SignalSlot\Dispatcher $signalSlotDispatcher */
        $signalSlotDispatcher = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Extbase\SignalSlot\Dispatcher::class);
        $signalSlotDispatcher->connect(
            \CPSIT\Persons\Controller\PersonController::class,
            \CPSIT\Persons\Controller\PersonController::SIGNAL_FILTER_ACTION_BEFORE_ASSIGN,
            \CPSIT\Persons\Slot\PersonControllerSlot::class,
            \CPSIT\Persons\Slot\PersonControllerSlot::SLOT_FILTER_ACTION_BEFORE_ASSIGN
        );
        $signalSlotDispatcher->connect(
            \CPSIT\Persons\Controller\PersonController::class,
            \CPSIT\Persons\Controller\PersonController::SIGNAL_LIST_ACTION_BEFORE_ASSIGN,
            \CPSIT\Persons\Slot\PersonControllerSlot::class,
            \CPSIT\Persons\Slot\PersonControllerSlot::SLOT_LIST_ACTION_BEFORE_ASSIGN
        );
    }

);
