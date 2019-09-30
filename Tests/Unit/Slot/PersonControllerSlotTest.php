<?php

namespace CPSIT\Persons\Persons\Tests\Unit\Slot;

use CPSIT\Persons\Slot\PersonControllerSlot;
use CPSIT\Persons\Utility\LocalizationUtility;
use Nimut\TestingFramework\TestCase\UnitTestCase;

/**
 * Test case.
 */
class PersonControllerSlotTest extends UnitTestCase
{
    /**
     * @var \CPSIT\Persons\Slot\PersonControllerSlot|\PHPUnit_Framework_MockObject_MockObject
     */
    protected $subject = null;

    protected function setUp()
    {
        $this->subject = $this->getMockBuilder(PersonControllerSlot::class)
            ->setMethods(['callStatic'])->getMock();
    }

    /**
     * @param array $returnValue
     */
    protected function mockLocalizationUtility(array $returnValue = []) {
        $this->subject->expects($this->any())
            ->method('callStatic')
            ->with(LocalizationUtility::class, 'getCurrentLanguageKeys')
            ->willReturn($returnValue);
    }

    /**
     * @test
     */
    public function handleFilterBeforeAssignSlotForEmptyParamsSetsEmptyOptions()
    {
        $languageKeys = ['fooBar'];
        $this->mockLocalizationUtility($languageKeys);

        $params = [];

        $expectedParams = [
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [],
                PersonControllerSlot::LOCALLANG_KEY => $languageKeys
            ]
        ];
        $this->assertSame(
            [$expectedParams],
            $this->subject->handleFilterBeforeAssignSlot($params)
        );
    }

    /**
     * Data provider for valid settings, transferred by
     * handleFilterBeforeAssignSlot method
     * @return array
     */
    public function handleFilterBeforeAssignSlotValidSettingsDataProvider()
    {
        $stringValue = 'foo';
        $integerValue = 4;
        $arrayValue = ['bar'];

        $dataSets = [];
        $allowedKeys = PersonControllerSlot::getKeysToTransferInFilterAction();
        foreach ($allowedKeys as $settingsKey) {
            $dataSets[] = [$settingsKey, $stringValue];
            $dataSets[] = [$settingsKey, $integerValue];
            $dataSets[] = [$settingsKey, $arrayValue];
        }

        return $dataSets;
    }

    /**
     * @test
     * @param string $settingsKey
     * @param $settingsValue
     * @dataProvider handleFilterBeforeAssignSlotValidSettingsDataProvider
     */
    public function handleFilterBeforeAssignSlotTransfersAllowedSettingsKeys($settingsKey, $settingsValue)
    {
        $languageKeys = ['fooBar'];
        $this->mockLocalizationUtility($languageKeys);

        $params = [
            'settings' => [
                $settingsKey => $settingsValue
            ]
        ];

        $expectedParams = [
            'settings' => [
                $settingsKey => $settingsValue
            ],
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [
                    $settingsKey => $settingsValue
                ],
                PersonControllerSlot::LOCALLANG_KEY => $languageKeys
            ]
        ];
        $this->assertSame(
            [$expectedParams],
            $this->subject->handleFilterBeforeAssignSlot($params)
        );
    }

    /**
     * @test
     */
    public function handleFilterBeforeAssignSlotDoesNotTransferInvalidSettingsKeys()
    {
        $languageKeys = ['fooBar'];
        $this->mockLocalizationUtility($languageKeys);

        $settingsKey = 'foo';

        $params = [
            'settings' => [
                $settingsKey => 'bar'
            ]
        ];

        $expectedParams = [
            'settings' => [
                $settingsKey => 'bar'
            ],
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [],
                PersonControllerSlot::LOCALLANG_KEY => $languageKeys
            ]
        ];

        $this->assertSame(
            [$expectedParams],
            $this->subject->handleFilterBeforeAssignSlot($params)
        );
    }

    /**
     * Data provider for valid settings, transferred by
     * handleListBeforeAssignSlot method
     * @return array
     */
    public function handleListBeforeAssignSlotValidSettingsDataProvider()
    {
        $stringValue = 'foo';
        $integerValue = 4;
        $arrayValue = ['bar'];

        $dataSets = [];
        $allowedKeys = PersonControllerSlot::getKeysToTransferInListAction();
        foreach ($allowedKeys as $settingsKey) {
            $dataSets[] = [$settingsKey, $stringValue];
            $dataSets[] = [$settingsKey, $integerValue];
            $dataSets[] = [$settingsKey, $arrayValue];
        }

        return $dataSets;
    }

    /**
     * @test
     * @param string $settingsKey
     * @param $settingsValue
     * @dataProvider handleListBeforeAssignSlotValidSettingsDataProvider
     */
    public function handleListBeforeAssignSlotTransfersAllowedSettingsKeys($settingsKey, $settingsValue)
    {
        $languageKeys = ['fooBar'];
        $this->mockLocalizationUtility($languageKeys);

        $params = [
            'settings' => [
                $settingsKey => $settingsValue
            ]
        ];

        $expectedParams = [
            'settings' => [
                $settingsKey => $settingsValue
            ],
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [
                    $settingsKey => $settingsValue
                ],
                PersonControllerSlot::LOCALLANG_KEY => $languageKeys
            ]
        ];
        $this->assertSame(
            [$expectedParams],
            $this->subject->handleListBeforeAssignSlot($params)
        );
    }

    /**
     * @test
     */
    public function handleListBeforeAssignSlotDoesNotTransferInvalidSettingsKeys()
    {
        $languageKeys = ['fooBar'];
        $this->mockLocalizationUtility($languageKeys);

        $settingsKey = 'foo';

        $params = [
            'settings' => [
                $settingsKey => 'bar'
            ]
        ];

        $expectedParams = [
            'settings' => [
                $settingsKey => 'bar'
            ],
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [
                ],
                PersonControllerSlot::LOCALLANG_KEY => $languageKeys
            ]
        ];

        $this->assertSame(
            [$expectedParams],
            $this->subject->handleListBeforeAssignSlot($params)
        );
    }

    /**
     * @test
     */
    public function handleListBeforeAssignSlotKeepsExistingConfiguration()
    {
        $languageKeys = ['fooBar'];
        $this->mockLocalizationUtility($languageKeys);

        $params = [
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [
                    'bar'
                ],
                PersonControllerSlot::LOCALLANG_KEY => $languageKeys
            ]
        ];

        $expectedParams = $params;

        $this->assertSame(
            [$expectedParams],
            $this->subject->handleListBeforeAssignSlot($params)
        );
    }

    /**
     * @test
     */
    public function handleFilterBeforeAssignSlotKeepsExistingConfiguration()
    {
        $languageKeys = ['fooBar'];
        $this->mockLocalizationUtility($languageKeys);

        $params = [
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [
                    'bar'
                ],
                PersonControllerSlot::LOCALLANG_KEY => $languageKeys
            ]
        ];

        $expectedParams = $params;

        $this->assertSame(
            [$expectedParams],
            $this->subject->handleFilterBeforeAssignSlot($params)
        );
    }

    /**
     * @test
     * @param string $settingsKey
     * @param $settingsValue
     * @dataProvider handleListBeforeAssignSlotValidSettingsDataProvider
     */
    public function handleListBeforeAssignSlotOverwritesAllowedSettingsKeys($settingsKey, $settingsValue)
    {
        $languageKeys = ['fooBar'];
        $this->mockLocalizationUtility($languageKeys);

        $params = [
            'settings' => [
                $settingsKey => $settingsValue
            ],
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [
                    $settingsKey => 'existingValue',
                    'otherKeyWhichShouldBeKept' => 'other Value'
                ]
            ]

        ];

        $expectedParams = [
            'settings' => [
                $settingsKey => $settingsValue
            ],
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [
                    $settingsKey => $settingsValue,
                    'otherKeyWhichShouldBeKept' => 'other Value'
                ],
                PersonControllerSlot::LOCALLANG_KEY => $languageKeys
            ]
        ];
        $this->assertSame(
            [$expectedParams],
            $this->subject->handleListBeforeAssignSlot($params)
        );
    }

    /**
     * @test
     * @param string $settingsKey
     * @param $settingsValue
     * @dataProvider handleFilterBeforeAssignSlotValidSettingsDataProvider
     */
    public function handleFilterBeforeAssignSlotOverwritesAllowedSettingsKeys($settingsKey, $settingsValue)
    {
        $languageKeys = ['fooBar'];
        $this->mockLocalizationUtility($languageKeys);


        $params = [
            'settings' => [
                $settingsKey => $settingsValue
            ],
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [
                    $settingsKey => 'existingValue',
                    'otherKeyWhichShouldBeKept' => 'other Value'
                ]
            ]

        ];

        $expectedParams = [
            'settings' => [
                $settingsKey => $settingsValue
            ],
            PersonControllerSlot::CONFIGURATION_KEY => [
                PersonControllerSlot::OPTIONS_KEY => [
                    $settingsKey => $settingsValue,
                    'otherKeyWhichShouldBeKept' => 'other Value'
                ],
                PersonControllerSlot::LOCALLANG_KEY => $languageKeys
            ]
        ];
        $this->assertSame(
            [$expectedParams],
            $this->subject->handleFilterBeforeAssignSlot($params)
        );
    }

    /**
     * @test
     */
    public function getKeysToTransferInFilterActionReturnsAttribute()
    {
        $this->assertEquals(
            PersonControllerSlot::TRANSFER_KEYS_FILTER_ACTION,
            $this->subject::getKeysToTransferInFilterAction()
        );
    }

    /**
     * @test
     */
    public function getKeysToTransferInListActionReturnsAttribute()
    {
        $this->assertEquals(
            PersonControllerSlot::TRANSFER_KEYS_LIST_ACTION,
            $this->subject::getKeysToTransferInListAction()
        );
    }
}
