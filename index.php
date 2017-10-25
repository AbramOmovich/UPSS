<?php

use UPSS\Config;
use UPSS\Preprocessing\RequestHandler;

include 'vendor/autoload.php';
include 'mock_params.php';

new Config('settings.php');

$type_detector = Config::getInstance()->get('type_detector');
RequestHandler::setTypeDetector(new $type_detector);
$entityCollection = RequestHandler::createFromGlobals();

var_dump($entityCollection);