<?php
/*
 * Data supplied example structure
 *
 */

$params = [
    'objects' => [
        ['speed' => 220, 'size' => '3360', 'weight' => 891],
        ['speed' => 240, 'size' => '2450', 'weight' => 750],
        ['speed' => 250, 'size' => '3670', 'weight' => 777],
        ['speed' => 230, 'size' => '2870', 'weight' => 812],
        ['speed' => 180, 'size' => '2990', 'weight' => 784],
    ],
    'preferences' => [
        'speed' =>
            [
                'direction' => '1', // 1 stands for max, 0 for min
                'weight' => 0.5   // Less important param has less weight
            ],
        'size' =>
            [
                'direction' => 0,
                'weight' => 0.1
            ],
    ]
];