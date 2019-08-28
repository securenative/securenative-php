<?php

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
 
class HttpClient extends GuzzleClient
{
    public function __construct($apiKey, SecureNativeOptions $options)
    {
        $defaultOptions =   [
          'handler'  => $this->getHandlerStack(),
          'base_uri' => $options->apiUrl,
          'timeout'  => 2,
          'headers'  => [
              'User-Agent'   => 'SecureNative-PHP',
              'SN-Version'=> '1.0.0',
              'Authorization' => $apiKey,
              'Content-Type' => 'application/json',
            ]
        ];

        $eventOptions = array_merge($defaultOptions, $options);
        parent::__construct($eventOptions);
    }

    protected function getHandlerStack()
    {
        $handlerStack = HandlerStack::create($this->getHandler());

        $this->configureHandlerStack($handlerStack);

        return $handlerStack;
    }
}
