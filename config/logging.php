<?php

use Monolog\Handler\StreamHandler;
use Monolog\Handler\SyslogUdpHandler;

use function Roots\env;
use function Roots\storage_path;

return array(

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

    'default'  => env('LOG_CHANNEL', 'stack'),

    /*
    |--------------------------------------------------------------------------
    | Log Channels
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log channels for your application. Out of
    | the box, Acorn uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Drivers: "single", "daily", "slack", "syslog",
    |                    "errorlog", "monolog",
    |                    "custom", "stack"
    |
    */

    'channels' => array(
        'stack'      => array(
            'driver'            => 'stack',
            'channels'          => array( 'daily' ),
            'ignore_exceptions' => false,
        ),

        'single'     => array(
            'driver' => 'single',
            'path'   => storage_path('logs/stage.log'),
            'level'  => 'debug',
        ),

        'daily'      => array(
            'driver' => 'daily',
            'path'   => storage_path('logs/stage.log'),
            'level'  => 'debug',
            'days'   => 14,
        ),

        'slack'      => array(
            'driver'   => 'slack',
            'url'      => env('LOG_SLACK_WEBHOOK_URL'),
            'username' => 'Sage Log',
            'emoji'    => ':boom:',
            'level'    => 'critical',
        ),

        'papertrail' => array(
            'driver'       => 'monolog',
            'level'        => 'debug',
            'handler'      => SyslogUdpHandler::class,
            'handler_with' => array(
                'host' => env('PAPERTRAIL_URL'),
                'port' => env('PAPERTRAIL_PORT'),
            ),
        ),

        'stderr'     => array(
            'driver'    => 'monolog',
            'handler'   => StreamHandler::class,
            'formatter' => env('LOG_STDERR_FORMATTER'),
            'with'      => array(
                'stream' => 'php://stderr',
            ),
        ),

        'syslog'     => array(
            'driver' => 'syslog',
            'level'  => 'debug',
        ),

        'errorlog'   => array(
            'driver' => 'errorlog',
            'level'  => 'debug',
        ),
    ),

);
