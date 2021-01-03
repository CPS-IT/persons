<?php
defined('TYPO3_MODE') or die();

call_user_func(function ($extensionKey) {
    /**
     * register plugin
     */
    /** @var \TYPO3\CMS\Core\Information\Typo3Version $t3Version */
    $t3Version = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Information\Typo3Version::class);
    $pluginExtensionName = 'Persons';
    if ($t3Version->getMajorVersion() < 10) {
        $pluginExtensionName = 'CPSIT.Persons';
    }
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::registerPlugin(
        $pluginExtensionName,
        'Persons',
        'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_be.xlf:plugin.persons.title'
    );
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_excludelist'][$extensionKey . '_persons'] = 'recursive,select_key';
    $GLOBALS['TCA']['tt_content']['types']['list']['subtypes_addlist'][$extensionKey . '_persons'] = 'pi_flexform';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPiFlexFormValue(
        $extensionKey . '_persons',
        'FILE:EXT:' . $extensionKey . '/Configuration/FlexForms/flexform_persons.xml'
    );
}, 'persons');
