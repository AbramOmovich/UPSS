<?php
/*
 * Data supplied example structure
 *
 */

$params = [
    'objects' => [
        ['speed' => 220, 'size' => '3360', 'cargo' => 25],
        ['speed' => 240, 'size' => '2450', 'cargo' => 25],
        ['speed' => 250, 'size' => '3670', 'cargo' => 25],
        ['speed' => 230, 'size' => '2870', 'cargo' => 25],
        ['speed' => 180, 'size' => '2990', 'cargo' => 25],
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
                'weight' => 0
            ],
    ]
];