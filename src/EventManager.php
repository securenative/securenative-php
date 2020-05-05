<?php

namespace SecureNative\sdk;

use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use phpDocumentor\Reflection\Types\Array_;

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
        $cookie  = $opts->context->clientToken;
        $cookieDecoded = Utils::decrypt($cookie, $this->apiKey);
        $clientToken = json_decode($cookieDecoded);

        $rid = Utils::generateGuidV4();
        $eventType = $opts->event ? $opts->event : EventTypes::LOG_IN;
        $userId = $opts->userId ? $opts->userId : '';
        $userTraits = $opts->userTraits ? $opts->userTraits : new UserTraits('anonymous');
        $cid = $clientToken && $clientToken->cid ? $clientToken->cid : '';
        $vid = $clientToken && $clientToken->vid ? $clientToken->vid : '';
        $fp = $clientToken && $clientToken->fp ? $clientToken->fp : '';
        $ip =  $opts->context->ip ? $opts->context->ip : '';
        $remoteIp =  $opts->context->remoteIp ? $opts->context->remoteIp :  '';
        $method = $opts->context->method ? $opts->context->method :  '';
        $url = $opts->context->url ? $opts->context->url :  '';
        $headers =$opts->context->headers ? $opts->context->headers : null;
        $request = new Request($cid, $vid, $fp, $ip, $remoteIp, $method, $url, $headers);
        $properties = $opts->properties;
        $timestamp = $opts->timestamp ? $opts->timestamp : (new DateTime("now", new DateTimeZone("UTC")))->format(DateTime::ISO8601);

        $event = new SecurenativeEvent($rid, $eventType, $userId, $userTraits, $request, $properties, $timestamp);

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
