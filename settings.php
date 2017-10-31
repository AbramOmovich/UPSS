<?php

use UPSS\Components\Analyzers\EntityScalarWeightAnalyzer;
use UPSS\Components\Modifiers\EntityWeightRanker;
use UPSS\Preprocessing\TypeDetector\MockTypeDetector;
use UPSS\Preprocessing\Validator\EntityPropertiesValidator;
use UPSS\Storage\FileStorage;

return [
    'validator' => EntityPropertiesValidator::class,
    'type_detector' => MockTypeDetector::class,
    'storage' => [
        'class' => FileStorage::class,
        'folder' => __DIR__ . DIRECTORY_SEPARATOR . 'storage'
    ],
    'components' => [
        'analyzers' => [
            EntityScalarWeightAnalyzer::class,
        ],
        'modifiers' => [
            EntityWeightRanker::class,
        ],
    ],
];