<?php
declare(strict_types = 1);

return [
    \CPSIT\Persons\Domain\Model\Content::class => [
        'tableName' => 'tt_content',
        'properties' => [
            'altText' => [
                'fieldName' => 'altText'
            ],
            'titleText' => [
                'fieldName' => 'titleText'
            ],
            'colPos' => [
                'fieldName' => 'colPos'
            ],
            'CType' => [
                'fieldName' => 'CType'
            ],
        ],
    ],
];
