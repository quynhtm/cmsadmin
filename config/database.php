<?php

use Illuminate\Support\Str;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', \App\Library\AdminFunction\Define::DB_CONNECTION_MYSQL),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
        ],

        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', \App\Library\AdminFunction\Define::DB_HOST),
            'port' => env('DB_PORT', \App\Library\AdminFunction\Define::DB_PORT),
            'database' => env('DB_DATABASE', \App\Library\AdminFunction\Define::DB_DATABASE),
            'username' => env('DB_USERNAME', \App\Library\AdminFunction\Define::DB_USERNAME),
            'password' => env('DB_PASSWORD', \App\Library\AdminFunction\Define::DB_PASSWORD),
            'unix_socket' => env('DB_SOCKET', \App\Library\AdminFunction\Define::DB_SOCKET),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'bpm_customdb' => [
            'driver' => 'mysql',
            'host' => env('DB_CUSTOMDB_HOST', \App\Library\AdminFunction\Define::DB_HOST),
            'port' => env('DB_CUSTOMDB_PORT', \App\Library\AdminFunction\Define::DB_PORT),
            'database' => env('DB_CUSTOMDB_DATABASE', \App\Library\AdminFunction\Define::DB_DATABASE),
            'username' => env('DB_CUSTOMDB_USERNAME', \App\Library\AdminFunction\Define::DB_USERNAME),
            'password' => env('DB_CUSTOMDB_PASSWORD', \App\Library\AdminFunction\Define::DB_PASSWORD),
            'unix_socket' => env('DB_CUSTOMDB_SOCKET', \App\Library\AdminFunction\Define::DB_SOCKET),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => '',
            'strict' => false,
            'engine' => null,
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'host' => env('DB_HOST', \App\Library\AdminFunction\Define::DB_HOST),
            'port' => env('DB_PORT', \App\Library\AdminFunction\Define::DB_PORT),
            'database' => env('DB_DATABASE', \App\Library\AdminFunction\Define::DB_DATABASE),
            'username' => env('DB_USERNAME', \App\Library\AdminFunction\Define::DB_USERNAME),
            'password' => env('DB_PASSWORD', \App\Library\AdminFunction\Define::DB_PASSWORD),
            'charset' => 'utf8',
            'prefix' => '',
            'schema' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'host' => env('DB_HOST', \App\Library\AdminFunction\Define::DB_HOST),
            'port' => env('DB_PORT', \App\Library\AdminFunction\Define::DB_PORT),
            'database' => env('DB_DATABASE', \App\Library\AdminFunction\Define::DB_DATABASE),
            'username' => env('DB_USERNAME', \App\Library\AdminFunction\Define::DB_USERNAME),
            'password' => env('DB_PASSWORD', \App\Library\AdminFunction\Define::DB_PASSWORD),
            'charset' => 'utf8',
            'prefix' => '',
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer set of commands than a typical key-value systems
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [
        'client' => 'predis',
        'default' => [
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'password' => env('REDIS_PASSWORD', null),
            'port' => env('REDIS_PORT', 6379),
            'database' => 0,
        ],

    ],

];
