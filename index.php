<?php

use UPSS\Config;
use UPSS\Preprocessing\RequestHandler;

include 'vendor/autoload.php';
include 'mock_params.php';

new Config('settings.php');

RequestHandler::setTypeDetector(Config::getInstance()->get('type_detector'));
$entityCollection = RequestHandler::createFromGlobals();