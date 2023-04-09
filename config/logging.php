<?php

use Monolog\Handler\NullHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;
use Monolog\Processor\PsrLogMessageProcessor;

return [

    /*
    |--------------------------------------------------------------------------
    | Default Log Channel
    |--------------------------------------------------------------------------
    |
    | This option defines the default log channel that gets used when writing
    | messages to the logs. The name specified in this option should match
    | one of the channels defined in the "channels" configuration array.
    |
    */

    'default' => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Deprecations Log Channel
    |--------------------------------------------------------------------------
    |
    | This option controls the log channel that should be used to log warnings
    | regarding deprecated PHP and library features. This allows you to get
    | your application ready for upcoming major versions of dependencies.
    |
    */

    'deprecations' => [
        'channel' => env('LOG_DEPRECATIONS_CHANNEL', 'null'),
        'trace' => false,
    ],

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => [
        'stack' => [
            'driver' => 'stack',
            'channels' => ['single'],
            'ignore_exceptions' => false,
        ],

        'single' => [
            'driver' => 'single',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        'daily' => [
            'driver' => 'daily',
            'path' => storage_path('logs/laravel.log'),
            'level' => env('LOG_LEVEL', 'debug'),
            'days' => 14,
            'replace_placeholders' => true,
        ],

        'slack' => [
            'driver' => 'slack',
            'url' => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Laravel Log',
            'emoji' => ':boom:',
            'level' => env('LOG_LEVEL', 'critical'),
            'replace_placeholders' => true,
        ],

        'papertrail' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => env('LOG_PAPERTRAIL_HANDLER', SyslogUdpHandler::class),
            'handler_with' => [
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
                'connectionString' => 'tls://'.env('PAPERTRAIL_URL').':'.env('PAPERTRAIL_PORT'),
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'stderr' => [
            'driver' => 'monolog',
            'level' => env('LOG_LEVEL', 'debug'),
            'handler' => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with' => [
                'stream' => 'php://stderr',
            ],
            'processors' => [PsrLogMessageProcessor::class],
        ],

        'syslog' => [
            'driver' => 'syslog',
            'level' => env('LOG_LEVEL', 'debug'),
            'facility' => LOG_USER,
            'replace_placeholders' => true,
        ],

        'errorlog' => [
            'driver' => 'errorlog',
            'level' => env('LOG_LEVEL', 'debug'),
            'replace_placeholders' => true,
        ],

        'null' => [
            'driver' => 'monolog',
            'handler' => NullHandler::class,
        ],

        'emergency' => [
            'path' => storage_path('logs/laravel.log'),
        ],

        /*
        |--------------------------------------------------------------------------
        | Custom Logging files
        |--------------------------------------------------------------------------
        |
        | This table keeps track of all the migrations that have already run for
        | your application. Using this information, we can determine which of
        | the migrations on disk haven't actually been run in the database.
        |
        */

        'user-logins' => [
            'driver' => 'single',
            'path' => storage_path('logs/user-logins.log'),
            'level' => 'debug',
        ],

        'new-user' => [
            'driver' => 'single',
            'path' => storage_path('logs/new-user.log'),
            'level' => 'debug',
        ],

        'sudo-logins' => [
            'driver' => 'single',
            'path' => storage_path('logs/sudo-logins.log'),
            'level' => 'debug',
        ],

        'password-changes' => [
            'driver' => 'single',
            'path' => storage_path('logs/password-changes.log'),
            'level' => 'debug',
        ],

        'user-roles-updated' => [
            'driver' => 'single',
            'path' => storage_path('logs/user-roles-updated.log'),
            'level' => 'debug',
        ],

        'sms-sent' => [
            'driver' => 'single',
            'path' => storage_path('logs/sms-sent.log'),
            'level' => 'debug',
        ],

        'sms-not-sent' => [
            'driver' => 'single',
            'path' => storage_path('logs/sms-not-sent.log'),
            'level' => 'debug',
        ],

        'test-queue' => [
            'driver' => 'single',
            'path' => storage_path('logs/test-queue.log'),
            'level' => 'debug',
        ],

        'mail-log' => [
            'driver' => 'single',
            'path' => storage_path('logs/mail-log.log'),
            'level' => 'debug',
        ],

        'custom-emails' => [
            'driver' => 'single',
            'path' => storage_path('logs/custom-emails.log'),
            'level' => 'debug',
        ],

        'emails-sent' => [
            'driver' => 'single',
            'path' => storage_path('logs/emails-sent.log'),
            'level' => 'debug',
        ],

        'emails-received' => [
            'driver' => 'single',
            'path' => storage_path('logs/emails-received.log'),
            'level' => 'debug',
        ],

        'user-account-status' => [
            'driver' => 'single',
            'path' => storage_path('logs/user-account-status.log'),
            'level' => 'debug',
        ],

        'bash-commands' => [
            'driver' => 'single',
            'path' => storage_path('logs/bash-commands.log'),
            'level' => 'debug',
        ],

        'payments-log' => [
            'driver' => 'single',
            'path' => storage_path('logs/payments-log.log'),
            'level' => 'debug',
        ],

        'scheduler' => [
            'driver' => 'single',
            'path' => storage_path('logs/scheduler.log'),
            'level' => 'debug',
        ],
    ],

];
