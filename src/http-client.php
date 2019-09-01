<?php

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;

class HttpClient extends Client
{
    public function __construct($apiKey, SecureNativeOptions $options)
    {
        $defaultOptions = [
            'handler' => $this->getHandlerStack(),
            'base_uri' => $options->getApiUrl(),
            'timeout' => $options->getTimeout() / 1000,
            'headers' => [
                'User-Agent' => 'SecureNative-PHP',
                'SN-Version' => '1.0.0',
                'Authorization' => $apiKey,
                'Content-Type' => 'application/json',
            ]
        ];

//        $eventOptions = array_merge($defaultOptions, $options);
        $eventOptions = $defaultOptions; // TODO: Combine options
        parent::__construct($eventOptions);
    }

    protected function getHandlerStack()
    {
        $handlerStack = HandlerStack::create($this->getHandler());

        return $handlerStack;
    }

    protected function getHandler()
    {
        return null;
    }
}