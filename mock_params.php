<?php
/*
 * Data supplied example structure
 *
 */
$params = [];

//PHP Array
//$params = include 'mock_data/mock_.php';

//XML data
/*$params = [
  'data' => file_get_contents( 'mock_data/mock.xml'),
  'format' => 'xml'
];*/

//another XML data
/*$params = [
    'data' => file_get_contents( 'http://www.nbrb.by/Services/XmlExRates.aspx'),
    //'format' => 'xml'
];*/

//JSON data
/*$params = [
  'data' => file_get_contents( 'mock_data/mock.json'),
  'format' => 'json'
];*/

//another JSON

$params = [
    'data' => file_get_contents( 'https://students.bsuir.by/api/v1/specialities'),
];


//Generated preferences
$params['preferences'] = file_get_contents('mock_data/mock_preferences.json');


if (!isset($_SERVER['REQUEST_METHOD'])) {
    $_SERVER['REQUEST_METHOD'] = 'CLI';
}

$GLOBALS['_'.$_SERVER['REQUEST_METHOD']] = $params;