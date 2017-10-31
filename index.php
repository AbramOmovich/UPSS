<?php

use UPSS\Config;
use UPSS\Controller\MainController;
use UPSS\Postprocessing\ExceptionHandler;
use UPSS\Postprocessing\ResponseHandler;
use UPSS\Preprocessing\RequestHandler;
use UPSS\Storage\FileStorage;

include 'vendor/autoload.php';
include 'mock_params.php';

$config = new Config('settings.php');
$responseHandler = new ResponseHandler();
$exceptionHandler = new ExceptionHandler($responseHandler);

$type_detector = $config->get('type_detector');
RequestHandler::setTypeDetector(new $type_detector);
$entityCollection = RequestHandler::createFromGlobals();

$storageSettings = $config->get('storage');
$components = $config->get('components');
$controller = new MainController($entityCollection, $components);
$entityCollection = $controller->handle();
$responseHandler->setData($entityCollection);
echo $responseHandler->send();

