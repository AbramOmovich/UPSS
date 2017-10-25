<?php
/*
 * Data supplied example structure
 *
 */


$params = [
    'data' => [
      'objects' => [
        ['speed' => 220, 'size' => '10000',  'name' => 'car1', 'weight' => 891],
        ['speed' => 240, 'size' => '2450', ['speed' => 220, 'size' => '10000',  'name' => 'car1', 'weight' => ''], 'weight' => 750],
        ['speed' => 250, 'size' => '3670', 'name' => 'car3', 'weight' => 777],
        ['speed' => 230, 'size' => '2870', 'name' => 'car4', 'weight' => 812],
        ['speed' => 300, 'size' => '2990', 'name' => 'car5', 'weight' => 784],
      ],
      'preferences' => [
        'speed' =>
          [
            'direction' => 1, // 1 stands for max, 0 for min
            'weight' => 0.9   // Less important param has less weight
          ],
        'size' =>
          [
            'direction' => 1,
            'weight' => 0.1
          ],
      ]
    ]
];


//XML data
/*$params = [
  'data' => file_get_contents( 'mock_data/mock.xml'),
  'format' => 'xml'
];*/

/*
//JSON data
$params = [
  'data' => file_get_contents( 'mock_data/mock.json'),
  'format' => 'json'
];
*/

if (!isset($_SERVER['REQUEST_METHOD'])){
    $_SERVER['REQUEST_METHOD'] = 'CLI';
}

$GLOBALS['_' . $_SERVER['REQUEST_METHOD']] = $params;