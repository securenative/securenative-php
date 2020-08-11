<?php

namespace SecureNative\sdk;
//

const MAX_CUSTOM_PARAMS = 6;

class SecureNative
{
    private static $apiKey;
    private static $options;
    private static $eventManager;
    private static $middleware;

    public static function init($apiKey, SecureNativeOptions $secureNativeOptions)
    {
        if ($apiKey == '') {
            throw new \Exception('You must pass your SecureNative api key');
        }
        Logger::init($secureNativeOptions);

        self::$apiKey = $apiKey;
        self::$options = $secureNativeOptions;
        self::$eventManager = new EventManager($apiKey, self::$options);
        self::$middleware = new Middleware($apiKey);
    }

    public static function track(Array $attributes)
    {
        $opts = new EventOptions(json_encode($attributes));

        if ($attributes == null || count($attributes) == 0) {
            throw new Exception("Can't send empty attributes");
        }

        if (isset($opts->params) && count($opts->params) > MAX_CUSTOM_PARAMS) {
            throw new Exception(sprintf('You can only specify maximum of %d params', MAX_CUSTOM_PARAMS));
        }

        $requestUrl = sprintf('%s/track', self::$options->getApiUrl());
        $event = self::$eventManager->buildEvent($opts);
        self::$eventManager->sendAsync($event, $requestUrl);
    }

    public static function verify(Array $attributes)
    {
        $opts = new EventOptions(json_encode($attributes));
        $requestUrl = sprintf('%s/verify', self::$options->getApiUrl());
        $event = self::$eventManager->buildEvent($opts);
        $result = self::$eventManager->sendSync($event, $requestUrl);

        if ($result == null) {
            Logger::debug("Verify result arrived empty, using default results");
            return new VerifyResult();
        } else {
            Logger::debug("Verify result successfuly arrived", $result);
        }

        return $result;
    }

    public static function flow($flowId, Array $attributes)
    {
        $opts = new EventOptions(json_encode($attributes));
        $requestUrl = sprintf('%s/flow/%s', self::$options->getApiUrl(), $flowId);
        $event = self::$eventManager->buildEvent($opts);
        return self::$eventManager->sendSync($event, $requestUrl);
    }
    public static function contextFromContext()
    {
        return SecureNativeContext::fromRequest();
    }

    public static function getMiddleware()
    {
        return self::$middleware;
    }

    /**
     * @return mixed
     */
    public static function getApiKey()
    {
        return self::$apiKey;
    }
}
