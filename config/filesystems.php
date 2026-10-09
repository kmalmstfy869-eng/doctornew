<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL', 'http://localhost'), '/').'/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],
        // Disk ملفات المرضى. حاليًا local، ولما R2 يجهز نغيّر MEDICAL_FILES_DRIVER=s3 والـ ENV بس، من غير تعديل أي كود.
        // الجذر برّه public/ فمفيش أي رابط مباشر للملفات.
        'medical_files' => [
            'driver' => env('MEDICAL_FILES_DRIVER', 'local'),
            'root' => env('MEDICAL_FILES_ROOT', storage_path('app/medical-files')),
            'key' => env('MEDICAL_FILES_KEY'),
            'secret' => env('MEDICAL_FILES_SECRET'),
            'region' => env('MEDICAL_FILES_REGION', 'auto'),
            'bucket' => env('MEDICAL_FILES_BUCKET'),
            'endpoint' => env('MEDICAL_FILES_ENDPOINT'),
            'use_path_style_endpoint' => env('MEDICAL_FILES_PATH_STYLE', true),
            'throw' => true,
            'report' => false,
        ],

        // Disk النسخ الاحتياطي: credentials ومتغيرات منفصلة تمامًا (MEDICAL_BACKUP_*) لحساب Cloudflare التاني.
        'medical_files_backup' => [
            'driver' => env('MEDICAL_BACKUP_DRIVER', 'local'),
            'root' => env('MEDICAL_BACKUP_ROOT', storage_path('app/medical-files-backup')),
            'key' => env('MEDICAL_BACKUP_KEY'),
            'secret' => env('MEDICAL_BACKUP_SECRET'),
            'region' => env('MEDICAL_BACKUP_REGION', 'auto'),
            'bucket' => env('MEDICAL_BACKUP_BUCKET'),
            'endpoint' => env('MEDICAL_BACKUP_ENDPOINT'),
            'use_path_style_endpoint' => env('MEDICAL_BACKUP_PATH_STYLE', true),
            'throw' => true,
            'report' => false,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
