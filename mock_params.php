<?php
/*
 * Data supplied example structure
 *
 */
$params = [];

//PHP Array
//$params = include 'mock_data/mock_.php';

//Generated preferences
//$params['preferences'] = file_get_contents('mock_data/mock_preferences.json');

//XML data
/*$params = [
  'data' => file_get_contents( 'mock_data/mock.xml'),
  'format' => 'xml'
];*/


//JSON data
$params = [
  'data' => file_get_contents( 'mock_data/mock.json'),
  'format' => 'json'
];


if (!isset($_SERVER['REQUEST_METHOD'])) {
    $_SERVER['REQUEST_METHOD'] = 'CLI';
}

$GLOBALS['_'.$_SERVER['REQUEST_METHOD']] = $params;