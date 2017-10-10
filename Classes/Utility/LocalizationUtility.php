<?php

namespace CPSIT\Persons\Utility;

/**
 * Class LocalizationUtility
 */
class LocalizationUtility extends \TYPO3\CMS\Extbase\Utility\LocalizationUtility
{
    static protected $translatedKeys = [];

    /**
     * Gets all language keys for a given extension
     *
     * @return array
     */
    public static function getAllLanguageKeys($extensionName = 'persons') {
        self::initializeLocalization($extensionName);
        if (empty(self::$translatedKeys[$extensionName]) && !empty(self::$LOCAL_LANG[$extensionName])) {
            foreach (self::$LOCAL_LANG[$extensionName] as $languageKey => $languageEntries) {
                foreach ($languageEntries as $entryKey => $entryValue) {
                    self::$translatedKeys[$extensionName][$languageKey][$entryKey] = self::translate($entryKey, $extensionName);
                }
            }
        }
        
        return self::$translatedKeys[$extensionName];
    }
}
