<?php
/**
 * Created by PhpStorm.
 * User: leiyu
 * Date: 2017/8/4
 * Time: 14:41
 */

$config['debug'] = true;

$config['url'] = 'http://dev.ylf.com';
$config['paths'] = [
    'api' => 'api',
    'admin' => 'admin',
];

//前台路由配置
$config['routes']['front'] = [
    ['/', 'IndexController@index'],
    ['/google/recaptcha', 'GoogleController@google'],
    ['/user/{id:\d+}', 'UserController@user']
];

//api路由配置
$config['routes']['api'] = [
    ['/', 'IndexController@index'],
    ['/user/{id:\d+}', 'UserController@user']
];

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

$config['cache'] = [

    /*
    |--------------------------------------------------------------------------
    | Default Cache Store
    |--------------------------------------------------------------------------
    |
    | This option controls the default cache connection that gets used while
    | using this caching library. This connection is used when another is
    | not explicitly specified when executing a given caching function.
    |
    | Supported: "apc", "array", "database", "file", "memcached", "redis"
    |
    */

    'default' => 'file',

    /*
    |--------------------------------------------------------------------------
    | Cache Stores
    |--------------------------------------------------------------------------
    |
    | Here you may define all of the cache "stores" for your application as
    | well as their drivers. You may even define multiple stores for the
    | same cache driver to group types of items stored in your caches.
    |
    */

    'stores' => [

        'apc' => [
            'driver' => 'apc',
        ],

        'array' => [
            'driver' => 'array',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'cache',
            'connection' => null,
        ],

        'file' => [
            'driver' => 'file',
            'path' => storage_path('cache'),
        ],

        'memcached' => [
            'driver' => 'memcached',
            'persistent_id' => 'MEMCACHED_PERSISTENT_ID',
            'sasl' => [
                'MEMCACHED_USERNAME',
                'MEMCACHED_PASSWORD',
            ],
            'options' => [
                // Memcached::OPT_CONNECT_TIMEOUT  => 2000,
            ],
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Key Prefix
    |--------------------------------------------------------------------------
    |
    | When utilizing a RAM based store such as APC or Memcached, there might
    | be other applications utilizing the same cache. So, we'll specify a
    | value to get prefixed to all our keys so we can avoid collisions.
    |
    */

    'prefix' => 'ylf',

];


return $config;