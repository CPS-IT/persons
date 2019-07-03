<?php
defined('TYPO3_MODE') or die();

call_user_func(function ($extensionKey) {
    $ll = 'LLL:EXT:' . $extensionKey . '/Resources/Private/Language/locallang_db.xlf:';

    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::makeCategorizable(
        $extensionKey,
        'tx_persons_domain_model_person',
        'categories',
        [
            'label' => $ll . 'tx_persons_domain_model_person.categories',
            'exclude' => false,
            'fieldConfiguration' => [
                'treeConfig' => [
                    'appearance' => [
                        'showHeader' => true,
                        'nonSelectableLevels' => 0,
                    ]
                ],
                'size' => 10,
                'foreign_table_where' => ' AND sys_category.sys_language_uid IN (-1, 0) ORDER BY sys_category.title ASC',
            ],
            'l10n_mode' => 'exclude',
            'l10n_display' => 'hideDiff',
        ]
    );
}, 'persons');
