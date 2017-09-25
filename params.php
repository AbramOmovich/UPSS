<?php
/*
 * Data supplied example structure
 *
 */

$params = [
    'objects' => [
        ['speed' => 220, 'size' => '3360'],
        ['speed' => 240, 'size' => '2450'],
        ['speed' => 250, 'size' => '3670'],
        ['speed' => 230, 'size' => '2870'],
        ['speed' => 180, 'size' => '2990'],
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