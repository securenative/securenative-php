<?php

use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\RequestException;

class EventManager
{
  private $apiKey;
  private $httpClient;
  private $options;
  private $eventsQueue;

  public function __construct($apiKey, SecureNativeOptions $secureNativeOptions)
  {
    $this->apiKey = $apiKey;
    $this->options = $secureNativeOptions;
    $this->httpClient = new HttpClient($this->apiKey, $this->options);
    $this->eventsQueue = array();
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

  public function sendSync(SecurenativeEvent $event, $requestUrl)
  {
      try {
          $request = new Request('POST', $requestUrl, [], Utils::serialize($event));
          $response = $this->httpClient->send($request);
          return json_decode($response>getBody());
      } catch (RequestException $e) {
          return null;
      }
  }

  public function sendAsync(SecurenativeEvent $event, $requestUrl)
  {
    if (count($this->eventsQueue) >= $this->options->getMaxEvents()) {
      array_shift($$this->eventsQueue);
    }

    $request = new Request('POST', $requestUrl, [], Utils::serialize($event));

    array_push($this->eventsQueue, $request);

    sendEvents();
  }

  private function sendEvents() 
  {
    for ($i = 0; $i < count($this->eventQueue); $i++) {
      $request = $this->eventQueue[$i];

      $promise = $this->httpClient->sendAsync($request);
      $promise->then(
        function (ResponseInterface $res) use ($request) {
          if (($key = array_search($request, $this->eventQueue)) !== false) {
            unset($this->eventQueue[$key]);
          }
        },
        function (RequestException $e) {
 
        });
    } 
  }
  
}
