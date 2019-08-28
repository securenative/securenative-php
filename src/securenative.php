<?php

class SecureNative
{
  public $apiKey;
  private $options; 

  public function __construct($apiKey, SecureNativeOptions $secureNativeOptions)
  {
      if ($apiKey == '') {
        throw new Exception('You must pass your SecureNative api key');
      }

      $this->apiKey = $apiKey;
      $this->options = $secureNativeOptions;
  }

  public static function track(EventOptions $eventOptions)
  {
 
  }

  public static function verify(EventOptions $eventOptions)
  {
 
  }

  public static function flow($flowId, EventOptions $eventOptions)
  {

  }
}





