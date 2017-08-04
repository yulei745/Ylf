<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/4
 * Time: 14:41
 */

$config['view'] = [
    'paths' => [realpath(base_path('views'))],
    'compiled' => realpath(storage_path('views')),
];

$config['filesystems'] = [
    'default' => 'local',
    'cloud' => 's3',
    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

//        'public' => [
//            'driver' => 'local',
//            'root' => storage_path('app/public'),
//            'url' => env('APP_URL').'/storage',
//            'visibility' => 'public',
//        ],
//
//        's3' => [
//            'driver' => 's3',
//            'key' => env('AWS_KEY'),
//            'secret' => env('AWS_SECRET'),
//            'region' => env('AWS_REGION'),
//            'bucket' => env('AWS_BUCKET'),
//        ],
    ]
];

$config['route'] = [];


return $config;