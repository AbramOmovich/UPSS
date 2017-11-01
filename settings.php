<?php

use UPSS\Components\Analyzers\EntityNumericPropertyAnalyzer;
use UPSS\Components\Analyzers\EntityStringPropertiesAnalyzer;
use UPSS\Components\Modifiers\EntityWeightRanker;
use UPSS\Components\Modifiers\WeightSummator;
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

    //sequence for launching components
    'components' => [
        'analyzers' => [
            EntityNumericPropertyAnalyzer::class,
            EntityStringPropertiesAnalyzer::class
        ],
        'modifiers' => [
            WeightSummator::class,
            EntityWeightRanker::class,
        ],
    ],
];