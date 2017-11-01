<?php
/*
 * Data supplied example structure
 *
 */


$params = [
    'data' => [
        'objects' => [
            [
                'speed' => 1000,
                'size' => '2780',
                'name' => '123',
                'weight' => 891,
            ],
            [
                'speed' => 1000,
                'size' => '3670',
                [
                    [
                        'speed' => 700,
                        'size' => '4670',
                        'name' => 'car3',
                        'weight' => 777,
                    ],
                    'size' => '4670',
                    'name' => 'car3',
                    'weight' => 777,
                ],
                'name' => 'car3',
                'weight' => 777,
            ],
            [
              'speed' => 1100,
              'size' => '2870',
              'name' => 'car3',
              'weight' => 777,
            ],
             [

                'name' => 'car',
                'weight' => 8122,
             ],
             [
                'speed' => 300,
                'size' => '2990',
                'name' => '123',
                'weight' => 784,
            ],
        ],
        'preferences' => [
            'speed' =>
                [
                    'direction' => 1, // 1 stands for max, 0 for min
                    'weight' => 1   // Less important param has less weight
                ],
            'size' =>
                [
                    'direction' => 1,
                    'weight' => 0.1,
                ],
            'name' =>
                [
                    'match' => 'car',
                    'weight' => 0.5
                ]

        ],
    ],
];


//XML data
/*$params = [
  'data' => file_get_contents( 'mock_data/mock.xml'),
  'format' => 'xml'
];*/


/*//JSON data
$params = [
  'data' => file_get_contents( 'mock_data/mock.json'),
  'format' => 'json'
];*/


if (!isset($_SERVER['REQUEST_METHOD'])) {
    $_SERVER['REQUEST_METHOD'] = 'CLI';
}

$GLOBALS['_'.$_SERVER['REQUEST_METHOD']] = $params;