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

    'default' => env('DB_CONNECTION', 'mysql'),

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
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],
        'other' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),
            'database' => env('DB_DATABASE_OTHER', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
        'Daibany' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_DAIBANY', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],
        'BokreahAli' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),
            //'database' => 'Daibany',
            'database' => env('DB_DATABASE_BOKREAH', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],'Elmaleh' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),
            //'database' => 'Daibany',
            'database' => env('DB_DATABASE_ELMALEH', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],'BenTaher' => [
        'driver' => 'sqlsrv',
        'url' => env('DATABASE_URL_OTHER'),
        'host' => env('DB_HOST_OTHER', 'localhost'),
        'port' => env('DB_PORT_OTHER', '1433'),
        //'database' => 'Daibany',
        'database' => env('DB_DATABASE_BENTAHER', 'forge'),
        'username' => env('DB_USERNAME_OTHER', 'forge'),
        'password' => env('DB_PASSWORD_OTHER', ''),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'trust_server_certificate' => true,
        // 'encrypt' => env('DB_ENCRYPT', 'yes'),
        // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
      ],'Bentaher2' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),
            //'database' => 'Daibany',
            'database' => env('DB_DATABASE_BENTAHER2', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],'Shaheen' => [
        'driver' => 'sqlsrv',
        'url' => env('DATABASE_URL_OTHER'),
        'host' => env('DB_HOST_OTHER', 'localhost'),
        'port' => env('DB_PORT_OTHER', '1433'),
        //'database' => 'Daibany',
        'database' => env('DB_DATABASE_SHAHEEN', 'forge'),
        'username' => env('DB_USERNAME_OTHER', 'forge'),
        'password' => env('DB_PASSWORD_OTHER', ''),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'trust_server_certificate' => true,
      ],'Motahedon' => [
        'driver' => 'sqlsrv',
        'url' => env('DATABASE_URL_OTHER'),
        'host' => env('DB_HOST_OTHER', 'localhost'),
        'port' => env('DB_PORT_OTHER', '1433'),
        //'database' => 'Daibany',
        'database' => env('DB_DATABASE_Motahedon', 'forge'),
        'username' => env('DB_USERNAME_OTHER', 'forge'),
        'password' => env('DB_PASSWORD_OTHER', ''),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'trust_server_certificate' => true,
      ],
        'Malah' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),
            //'database' => 'Daibany',
            'database' => env('DB_DATABASE_Malah', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],

      'Sohol' => [
        'driver' => 'sqlsrv',
        'url' => env('DATABASE_URL_OTHER'),
        'host' => env('DB_HOST_OTHER', 'localhost'),
        'port' => env('DB_PORT_OTHER', '1433'),
        //'database' => 'Daibany',
        'database' => env('DB_DATABASE_Sohol', 'forge'),
        'username' => env('DB_USERNAME_OTHER', 'forge'),
        'password' => env('DB_PASSWORD_OTHER', ''),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'trust_server_certificate' => true,
      ],

        'Safoa' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),
            //'database' => 'Daibany',
            'database' => env('DB_DATABASE_Safoa', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
        'Boseed' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Boseed', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
        'Ryada' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Ryada', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
      'Elzawy' => [
        'driver' => 'sqlsrv',
        'url' => env('DATABASE_URL_OTHER'),
        'host' => env('DB_HOST_OTHER', 'localhost'),
        'port' => env('DB_PORT_OTHER', '1433'),

        'database' => env('DB_DATABASE_Elzawy', 'forge'),
        'username' => env('DB_USERNAME_OTHER', 'forge'),
        'password' => env('DB_PASSWORD_OTHER', ''),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'trust_server_certificate' => true,
      ],
        'Mekkawi' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Mekkawi', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
        'Madaria' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Madaria', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
        'Boshlak' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Boshlak', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
      'Almajd' => [
        'driver' => 'sqlsrv',
        'url' => env('DATABASE_URL_OTHER'),
        'host' => env('DB_HOST_OTHER', 'localhost'),
        'port' => env('DB_PORT_OTHER', '1433'),

        'database' => env('DB_DATABASE_Almajd', 'forge'),
        'username' => env('DB_USERNAME_OTHER', 'forge'),
        'password' => env('DB_PASSWORD_OTHER', ''),
        'charset' => 'utf8',
        'prefix' => '',
        'prefix_indexes' => true,
        'trust_server_certificate' => true,
      ],
        'Boshlak2' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Boshlak2', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
        'Boshlak3' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Boshlak3', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
        'Verona' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Verona', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
        'Elshobky' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Elshobky', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
        ],
        'Eltaeb' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL_OTHER'),
            'host' => env('DB_HOST_OTHER', 'localhost'),
            'port' => env('DB_PORT_OTHER', '1433'),

            'database' => env('DB_DATABASE_Eltaeb', 'forge'),
            'username' => env('DB_USERNAME_OTHER', 'forge'),
            'password' => env('DB_PASSWORD_OTHER', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'trust_server_certificate' => true,
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
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
