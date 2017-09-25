<?php

use UPSS\App\Application;
use UPSS\App\Request;

include 'vendor/autoload.php';
include 'params.php';

$app = new Application();
$response = $app->handleRequest(Request::create($params));
echo $response->send();

