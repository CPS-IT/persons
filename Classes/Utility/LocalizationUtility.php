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
     * @param string $extensionName
     * @return array
     */
    public static function getAllLanguageKeys($extensionName = 'persons') {
        self::initializeLocalization(self::getLanguageFilePath($extensionName), $extensionName, self::getLanguageKeys()['alternativeLanguageKeys']);
        if (empty(self::$translatedKeys[$extensionName]) && !empty(self::$LOCAL_LANG[$extensionName])) {
            foreach (self::$LOCAL_LANG[$extensionName] as $languageKey => $languageEntries) {
                foreach ($languageEntries as $entryKey => $entryValue) {
                    self::$translatedKeys[$extensionName][$languageKey][$entryKey] = self::translate($entryKey, $extensionName);
                }
            }
        }

        return self::$translatedKeys[$extensionName];
    }

    /**
     * Gets language keys for current language for a given extension
     *
     * @param string $extensionName
     * @return array
     */
    public static function getCurrentLanguageKeys($extensionName = 'persons') {
        $allKeys = self::getAllLanguageKeys($extensionName);
        $currentKeys = [];
        $languageKey = static::getLanguageKey();
        if (isset($allKeys[$languageKey])) {
            $currentKeys = $allKeys[$languageKey];
        } elseif (isset($allKeys['default'])) {
            $currentKeys = $allKeys['default'];
        }

        return $currentKeys;
    }

    /**
     * Returns the current language key
     * @return string
     */
    public static function getLanguageKey() {
        return self::getLanguageKeys()['languageKey'];
    }
}
