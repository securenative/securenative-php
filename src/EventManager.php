<?php

namespace SecureNative\sdk;

use GuzzleHttp\Psr7\Request;
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
        $cookie = Utils::cookieIdFromRequest() ? Utils::cookieIdFromRequest() : Utils::securHeaderFromRequest();
        $cookieDecoded = Utils::decrypt($cookie, $this->apiKey);
        $clientFP = json_decode($cookieDecoded);
        $eventType = $opts->eventType ? $opts->eventType : EventTypes::LOG_IN;

        $cid = $clientFP->cid ? $clientFP->cid : '';
        $vid = Utils::generateGuidV4();
        $fp = $clientFP->fp ? $clientFP->fp : '';
        $ip = $opts->ip ? $opts->ip : Utils::clientIpFromRequest();
        $remoteIP = $opts->remoteIp ? $opts->remoteIp : Utils::clientIpFromRequest();
        $userAgent = $opts->userAgent ? $opts->userAgent : Utils::userAgentFromRequest();
        $user = $opts->user ? $opts->user : new User('anonymous');
        $ts = round(microtime(true) * 1000);
        $device = $opts->device;
        $params = $opts->params;

        $event = new SecurenativeEvent($eventType, $cid, $vid, $fp, $ip, $remoteIP, $userAgent, $user, $ts, $device, $params);

        Logger::debug('Created event', $event);

        return $event;
    }

    public function sendSync(SecurenativeEvent $event, $requestUrl)
    {
        try {
            $request = new Request('POST', $requestUrl, [], Utils::serialize($event));
            $response = $this->httpClient->send($request);
            $body = $response->getBody();
            Logger::debug('Successfully sent event', $event);
            return json_decode($body);
        } catch (RequestException $e) {
            Logger::debug('Failed to send event', $e->getMessage());
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
        Logger::debug("Added event to queue", $event);

        try {
            $this::sendEvents();
        } catch (Exception $e) {
            Logger::debug("Failed to send queue events", $e->getMessage());
            return;
        }
    }

    private function sendEvents()
    {
        for ($i = 0; $i < count($this->eventsQueue); $i++) {
            $request = $this->eventsQueue[$i];

            $promise = $this->httpClient->sendAsync($request);
            $promise->then(function ($res) use ($request) {
                if (($key = array_search($request, $this->eventsQueue)) !== false) {
                    unset($this->eventsQueue[$key]);
                }
            }, function (RequestException $e) {
                Logger::debug("Failed to send event request", $e->getMessage());
            });
            $promise->wait();
        }
    }

}
