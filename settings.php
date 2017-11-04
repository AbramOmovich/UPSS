<?php

use UPSS\Components\Analyzers\EntityNumericPropertyAnalyzer;
use UPSS\Components\Analyzers\EntityStringPropertiesAnalyzer;
use UPSS\Components\Modifiers\EntityWeightRanker;
use UPSS\Components\Modifiers\WeightSummator;
use UPSS\Controller\MainController;
use UPSS\Postprocessing\ResponseHandler;
use UPSS\Preprocessing\TypeDetector\MockTypeDetector;
use UPSS\Preprocessing\Validator\CollectionValidator;
use UPSS\Storage\FileStorage;

return [
    'exception_processor' => ResponseHandler::class,
    'validator' => CollectionValidator::class,
    'type_detector' => MockTypeDetector::class,
    'storage' => [
        'class' => FileStorage::class,
        'folder' => __DIR__ . DIRECTORY_SEPARATOR . 'storage'
    ],
    'controller' => MainController::class,

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