<?php

use Monolog\Logger;

require_once __DIR__ . '/../vendor/autoload.php';

// create a log channel
$log = new Logger('Pricer');
$log->pushProcessor(new \Monolog\Processor\PsrLogMessageProcessor());
$log->pushProcessor(new \Monolog\Processor\WebProcessor());

$handler = new \Monolog\Handler\ErrorLogHandler();
$output = "[%datetime%] [%level_name%] [%channel%] %message% %context% %extra%\n";
$handler->setFormatter(new \Monolog\Formatter\LineFormatter($output, DATE_ATOM));

$log->pushHandler($handler);

if($_SERVER['APP_ENV'] === 'dev') {
    $loggerClient = new \Fei\Service\Logger\Client\Logger();

    $log->pushHandler(new \Fei\Logger\Handler\LoggerApiHandler($loggerClient));
    $log->pushProcessor(new \Monolog\Processor\GitProcessor());
    $log->pushProcessor(new \Monolog\Processor\IntrospectionProcessor());
}

// add records to the log
$log->warning('Unable to send a file: "{reason}" please try again', [
    'reason' => '500 Internal Server Error',
    'fileId' => 123,
]);

$log->info('Successfully enqueued mail', [
    'subject'   => '[Caught] CALLER: : RG1710EDA7 : WARSAW - ALMAZORA ()',
    'from'      => 'customerservice.de@flash-global.net',
    'to'        => 'testit@flash-global.net'
]);
