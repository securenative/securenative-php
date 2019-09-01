<?php

//

require "event-manager.php";
require "middleware.php";
require "Models/event-options.php";
require "Models/verify-result.php";
require "Enums/risk-levels.php";

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
        throw new Exception('You must pass your SecureNative api key');
      }

      self::$apiKey = $apiKey;
      self::$options = $secureNativeOptions;
      self::$eventManager = new EventManager($apiKey, self::$options);
      self::$middleware = new Middleware($apiKey);
  }

  public static function track(Array $attributes)
  {
    $opts = new EventOptions(json_encode($attributes));
    if (count($opts->params) > MAX_CUSTOM_PARAMS) {
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
    
    if($result == null){
      return new VerifyResult();
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
}
