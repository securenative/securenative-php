<?php

namespace SecureNative\sdk;

use Monolog\Logger as MonoLogger;
use Monolog\Handler\StreamHandler;

class Logger
{
    private static $logger;
    private static $logLevels = [
        'debug'    => MonoLogger::DEBUG,
        'info'     => MonoLogger::INFO,
        'warning'  => MonoLogger::WARNING,
        'error'    => MonoLogger::ERROR,
        'fatal'    => MonoLogger::CRITICAL,
    ];

    public static function init(SecureNativeOptions $options) {
        Logger::$logger = new MonoLogger('securenative-sdk');
        //$logLevel  = Logger::$logLevels[$options->getLogLevel()];
        $logLevel  = Logger::$logLevels['debug'];
        Logger::$logger->pushHandler(new StreamHandler('php://stdout', $level = $logLevel, $bubble = true));
    }

    public static function debug($message, ...$args) {
        Logger::$logger->debug($message, $args);
    }

    public static function info($message, ...$args) {
        Logger::$logger->info($message, $args);
    }

    public static function error($message, ...$args) {
        Logger::$logger->error($message, $args);
    }

    public static function warning($message, ...$args) {
        Logger::$logger->warning($message, $args);
    }

    public static function fatal($message, ...$args) {
        Logger::$logger->critical($message, $args);
    }
}