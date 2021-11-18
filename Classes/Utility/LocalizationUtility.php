<?php

namespace CPSIT\Persons\Utility;

use TYPO3\CMS\Core\Core\Environment;
use TYPO3\CMS\Extbase\Utility\LocalizationUtility as LocalizationUtilityCore;

/**
 * Class LocalizationUtility
 */
class LocalizationUtility extends LocalizationUtilityCore
{
    /**
     * @var array
     */
    protected static $translatedKeys = [];

    /**
     * Gets all language keys for a given extension
     *
     * @param string $extensionName
     * @return array
     */
    public static function getAllLanguageKeys(string $extensionName = 'persons'): array
    {
        self::initializeLocalization(self::getLanguageFilePath($extensionName), $extensionName, self::getLanguageKeys()['alternativeLanguageKeys']);
        return self::extractTranslatedKeysFromConstVars($extensionName);
    }

    /**
     * @param string $extensionName
     * @return array
     */
    private static function extractTranslatedKeysFromConstVars(string $extensionName): array
    {
        if (!empty(self::$translatedKeys[$extensionName])) {
            return self::$translatedKeys[$extensionName];
        }

        foreach (self::$LOCAL_LANG as $keyNames => $fileData) {
            if ($keyNames === $extensionName || strpos($keyNames, 'EXT:' . $extensionName) === 0) {
                foreach ($fileData as $languageKey => $languageEntries) {
                    foreach ($languageEntries as $entryKey => $entryValue) {
                        self::$translatedKeys[$extensionName][$languageKey][$entryKey] = self::translate($entryKey, $extensionName);
                    }
                }
            }
        }

        return self::$translatedKeys[$extensionName]??[];
    }

    /**
     * Gets language keys for current language for a given extension
     *
     * @param string $extensionName
     * @return array
     */
    public static function getCurrentLanguageKeys(string $extensionName = 'persons'): array
    {
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
    public static function getLanguageKey(): string
    {
        return self::getLanguageKeys()['languageKey'];
    }
}
