<?php

namespace SecureNative\sdk;


class Logger
{
    private static $debugEnabled = false;

    public static function init(SecureNativeOptions $options) {
        if ($options->getDebugMode()) {
            self::$debugEnabled = true;
        }
    }

    private static function baseMessage($message, ...$args) {
        // TODO: Add log library
        echo "\n" . $message . " " . json_encode($args);
    }

    public static function debug($message, ...$args) {
        if (self::$debugEnabled) {
            self::baseMessage($message, $args);
        }
    }

    public static function info($message, ...$args) {
        self::baseMessage($message, $args);
    }
}