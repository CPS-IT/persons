<?php


namespace CPSIT\Persons\Listener;

use CPSIT\Persons\CallStaticTrait;
use CPSIT\Persons\Event\PersonsHandleFilterBeforeAssignEvent;
use CPSIT\Persons\Event\PersonsHandleListBeforeAssignEvent;
use CPSIT\Persons\Utility\LocalizationUtility;
use TYPO3\CMS\Core\SingletonInterface;
use TYPO3\CMS\Core\Utility\ArrayUtility;

class PersonControllerListener implements SingletonInterface
{
    use CallStaticTrait;

    private const CONFIGURATION_KEY = 'configuration';
    private const OPTIONS_KEY = 'options';
    private const LOCALLANG_KEY = 'locallang';

    private const TRANSFER_KEYS_FILTER_ACTION = [
        'categories', 'visible', 'selected',
        'languageParam',
        'languageUid'
    ];
    private const TRANSFER_KEYS_LIST_ACTION = [
        'categories',
        'detailPid',
        'languageParam',
        'languageUid',
        'detailPid',
        'detailUrlPage',
        'detailUrlPerson',
        'detailUrlAction'
    ];

    /**
     * @param PersonsHandleFilterBeforeAssignEvent $event
     */
    public function handleFilterBeforeAssign(PersonsHandleFilterBeforeAssignEvent $event): void
    {
        $data = $event->getData();
        $data[static::CONFIGURATION_KEY] = $this->getConfiguration($data, static::TRANSFER_KEYS_FILTER_ACTION);
        $event->setData($data);
    }

    /**
     * @param PersonsHandleListBeforeAssignEvent $event
     */
    public function handleListBeforeAssign(PersonsHandleListBeforeAssignEvent $event): void
    {
        $data = $event->getData();
        $data[static::CONFIGURATION_KEY] = $this->getConfiguration($data, static::TRANSFER_KEYS_LIST_ACTION);
        $event->setData($data);
    }

    /**
     * @param array $params
     * @param array $keys
     * @return array
     */
    protected function getConfiguration(array $params, array $keys): array
    {
        $additionalConfiguration = [
            static::OPTIONS_KEY => [],
            static::LOCALLANG_KEY => $this->callStatic(LocalizationUtility::class, 'getCurrentLanguageKeys')
        ];
        foreach ($keys as $item) {
            if (isset($params['settings'][$item])) {
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