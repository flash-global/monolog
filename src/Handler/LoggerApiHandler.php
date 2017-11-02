<?php
/**
 * Created by PhpStorm.
 * User: jerome
 * Date: 30/10/2017
 * Time: 14:05
 */

namespace Fei\Logger\Handler;


use Fei\Service\Logger\Client\Logger as LoggerClient;
use Fei\Service\Logger\Entity\Notification;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

class LoggerApiHandler extends AbstractProcessingHandler
{
    /** @var LoggerClient */
    protected $loggerClient;

    const LOG_LEVEL_MAPPING = [
        Logger::DEBUG => Notification::LVL_DEBUG,
        Logger::INFO => Notification::LVL_INFO,
        Logger::WARNING => Notification::LVL_WARNING,
        Logger::ERROR => Notification::LVL_ERROR,
        Logger::ALERT => Notification::LVL_PANIC,
    ];

    public function __construct(LoggerClient $loggerClient, $level = Logger::DEBUG, $bubble = true)
    {
        $this->loggerClient = $loggerClient;
        parent::__construct($level = Logger::DEBUG, $bubble = true);
    }

    /**
     * @return LoggerClient
     */
    public function getLoggerClient()
    {
        return $this->loggerClient;
    }

    /**
     * @param LoggerClient $loggerClient
     */
    public function setLoggerClient($loggerClient)
    {
        $this->loggerClient = $loggerClient;
    }

    /**
     * Writes the record down to the log of the implementing handler
     *
     * @param  array $record
     *
     * @return void
     */
    protected function write(array $record)
    {
        $notification = new Notification();
        $notification->setMessage($record['message']);
        $notification->setLevel(self::LOG_LEVEL_MAPPING[$record['level']]);
        $notification->setContext($record['context']);
        $notification->setNamespace($record['channel']);

        $this->getLoggerClient()->notify($notification);
    }
}
