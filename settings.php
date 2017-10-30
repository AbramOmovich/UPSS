<?php

use UPSS\Components\Analyzers\EntityWeightAnalyzer;
use UPSS\Components\Modifiers\EntityWeightRanker;
use UPSS\Preprocessing\TypeDetector\MockTypeDetector;
use UPSS\Preprocessing\Validator\EntityPropertiesValidator;

return [
    'validator' => EntityPropertiesValidator::class,
    'type_detector' => MockTypeDetector::class,
    'storage' => [
        'folder' => __DIR__ . DIRECTORY_SEPARATOR . 'storage'
    ],
    'components' => [
        'analyzers' => [
            EntityWeightAnalyzer::class,
        ],
        'modifiers' => [
            EntityWeightRanker::class,
        ],
    ],
];