<?php

use Fei\Cache\CacheManager;
use Fei\Cache\FifoCollection;
use Zend\Cache\Storage\Adapter\BlackHole;

class LoggerApiHandlerTest extends PHPUnit_Framework_TestCase
{
    public function testCanStore()
    {
        $loggerClient = $this->getMockBuilder(\Fei\Service\Logger\Client\Logger::class)->getMock();

        $handler = new \Fei\Logger\Handler\LoggerApiHandler($loggerClient);
    }
}
