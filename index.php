<?php

use UPSS\Application;
use UPSS\Controller\MainController;
use UPSS\Postprocessing\ExceptionHandler;
use UPSS\Postprocessing\ResponseHandler;
use UPSS\Preprocessing\RequestHandler;
use UPSS\Storage\FileStorage;

include 'vendor/autoload.php';
include 'mock_params.php';

$app = new Application('settings.php');
$app->initialize(new RequestHandler(), new ResponseHandler(), new ExceptionHandler());
$app->process();

