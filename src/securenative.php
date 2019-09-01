<?php

//

require "event-manager.php";
require "Models/event-options.php";
require "Models/verify-result.php";
require "Enums/risk-levels.php";

const MAX_CUSTOM_PARAMS = 6;

class SecureNative
{
  public $apiKey;
  private $options; 
  private $eventManager;

  public function __construct($apiKey, SecureNativeOptions $secureNativeOptions)
  {
      if ($apiKey == '') {
        throw new Exception('You must pass your SecureNative api key');
      }

      $this->apiKey = $apiKey;
      $this->options = $secureNativeOptions;
      $this->eventManager = new EventManager($apiKey, $this->options);
  }

  public function track(Array $attributes)
  {
    $opts = new EventOptions(json_encode($attributes));
    if (count($opts->params) > MAX_CUSTOM_PARAMS) {
      throw new Exception(sprintf('You can only specify maximum of %d params', MAX_CUSTOM_PARAMS));
    }

    $requestUrl = sprintf('%s/track', $this->options->getApiUrl());
    $event = $this->eventManager->buildEvent($opts);
    $this->eventManager->sendAsync($event, $requestUrl);
  }

  public function verify(Array $attributes)
  {
    $opts = new EventOptions(json_encode($attributes));
    $requestUrl = sprintf('%s/verify', $this->options->getApiUrl());
    $event = $this->eventManager->buildEvent($opts);
    $result = $this->eventManager->sendSync($event, $requestUrl);
    
    if($result == null){
      return new VerifyResult();
    }

    return $result;
  }

  public function flow($flowId, Array $attributes)
  {
    $opts = new EventOptions(json_encode($attributes));
    $requestUrl = sprintf('%s/flow/%s', $this->options->getApiUrl(), $flowId);
    $event = $this->eventManager->buildEvent($opts);
    return $this->eventManager->sendSync($event, $requestUrl);
  }
}
