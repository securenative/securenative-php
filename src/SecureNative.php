<?php

namespace SecureNative\sdk;


const MAX_CUSTOM_PARAMS = 6;

class SecureNative
{
    private static bool $isInitialized = false;
    private static $apiKey;
    private static SecureNativeOptions $options;
    private static EventManager $eventManager;
    private static $middleware;

    public static function init($apiKey = '', SecureNativeOptions $secureNativeOptions = null, EventManager $eventManager = null)
    {
        if (self::$isInitialized) {
            Logger::warning("Already initialized, exiting");
            return;
        }

        $fileOptions = ConfigurationManager::getConfig();
        // Adds the ability to get api-key from configuration file
        if ($apiKey == '' && $fileOptions->getApiKey() != '') {
            $apiKey = $fileOptions->getApiKey();
        }

        if ($apiKey == '') {
            throw new \Exception('You must pass your SecureNative api key');
        }
        self::$isInitialized = true;

        Logger::init($secureNativeOptions);

        $fileOptions->mergeOptions($secureNativeOptions);

        self::$apiKey = $apiKey;
        self::$options = $fileOptions;
        self::$eventManager = isset($eventManager) ? $eventManager : new EventManager($apiKey, self::$options);
        self::$middleware = new Middleware($apiKey);
    }

    public static function track(Array $attributes, callable $callbackFn = null)
    {
        if (!self::$isInitialized) {
            throw new \Exception("Call `init()` before running this function");
        }

        $opts = new EventOptions($attributes);

        if ($attributes == null || count($attributes) == 0) {
            throw new \Exception("Can't send empty attributes");
        }

        if (isset($opts->properties) && count($opts->properties) > MAX_CUSTOM_PARAMS) {
            throw new \Exception(sprintf('You can only specify maximum of %d properties', MAX_CUSTOM_PARAMS));
        }

        $requestUrl = sprintf('%s/track', self::$options->getApiUrl());
        $event = self::$eventManager->buildEvent($opts);
        self::$eventManager->sendAsync($event, $requestUrl, $callbackFn);
    }

    public static function verify(Array $attributes)
    {
        if (!self::$isInitialized) {
            throw new \Exception("Call `init()` before running this function");
        }

        $opts = new EventOptions($attributes);
        $requestUrl = sprintf('%s/verify', self::$options->getApiUrl());
        $event = self::$eventManager->buildEvent($opts);
        $result = self::$eventManager->sendSync($event, $requestUrl);

        if ($result == null) {
            Logger::debug("Verify result arrived empty, using default results");
            return new VerifyResult();
        } else {
            echo  'verify result: ';
            print_r($result);
            Logger::debug("Verify result successfuly arrived", $result);
        }

        return $result;
    }

    public static function flow($flowId, Array $attributes)
    {
        if (!self::$isInitialized) {
            throw new \Exception("Call `init()` before running this function");
        }

        $opts = new EventOptions($attributes);
        $requestUrl = sprintf('%s/flow/%s', self::$options->getApiUrl(), $flowId);
        $event = self::$eventManager->buildEvent($opts);
        return self::$eventManager->sendSync($event, $requestUrl);
    }

    public static function getRequestContext()
    {
        return SecureNativeContext::fromRequest();
    }

    /**
     * @deprecated use `getRequestContext()` instead
     * @return SecureNativeContext
     */
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

    /**
     * Destroy object after use
     */
    public static function destroy() {
        self::$isInitialized = false;
    }
}
