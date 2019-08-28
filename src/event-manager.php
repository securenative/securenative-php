<?php

class EventManager
{
  private $apiKey;
  private $httpClient;
  public function __construct($apiKey, SecureNativeOptions $secureNativeOptions)
  {
    $this->apiKey = $apiKey;
    $this->httpClient = new Client($this->apiKey, $this->version, $this->clientOptions);
  }

  public function buildEvent(EventOptions $opts)
  {
     $cookie = Utils::cookieIdFromRequest() || Utils::securHeaderFromRequest();
     $cookieDecoded = Utils::decrypt(cookie, $this->apiKey);
     $clientFP = json_decode(cookieDecoded);
     $eventType = $opts->eventType || EventTypes::LOG_IN;

     $cid = $clientFP['cid'] || '';
     $vid = Utils::generateGuidV4();
     $fp = clientFP['fp'] || '';
     $ip = $opts->ip || Utils::clientIpFromRequest();
     $remoteIP = $opts->remoteIp || Utils::clientIpFromRequest();
     $userAgent =  $opts->userAgent || Utils::userAgentFromRequest();
     $user = $opts->user || new User('anonymous');
     $ts = round(microtime(true) * 1000);
     $device = $opts->device || null;
     $params =$opts->params;

     return new SecurenativeEvent($eventType, $cid, $vid, $fp, $ip, $remoteIP, $userAgent, $user, $ts, $device, $params);
  }
}
