<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Asset Object Storage related variables
    |--------------------------------------------------------------------------
    |
    */

    'media' => env('MEDIA'),
    'media_domain' => env('DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [
        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL') . '/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
        ],

        'spaces' => [
            'driver' => 's3',
            'key' => env('DO_SPACES_KEY'),
            'secret' => env('DO_SPACES_SECRET'),
            'endpoint' => env('DO_SPACES_ENDPOINT'),
            'region' => env('DO_SPACES_REGION'),
            'bucket' => env('DO_SPACES_BUCKET'),
        ],

        // ADDITIONAL DRIVERS

        /*
         * repo is a generic storage space for storing various non-static artefacts
         * related to the application. Examples, are templates, modules etc. This
         * folder is version controlled.
         */
        'repo' => [
            'driver' => 'local',
            'root' => storage_path('repo'),
        ],

        /*
         * backup is used to store/generate site backup. This is
         * not-version controlled.
         */
        'backup' => [
            'driver' => 'local',
            'root' => storage_path('backup'),
        ],

        /*
         * "templates" is used to store the local copies of the template. This is
         * not-version controlled.
         */
        'templates' => [
            'driver' => 'local',
            'root' => resource_path('views/templates'),
        ],

        /*
         * "active" folder is used to store the actual blade files that are
         * used for the live site. This folder is not version-controlled.
         */
        'active' => [
            'driver' => 'local',
            'root' => resource_path('views/active'),
        ],
    ],
];
