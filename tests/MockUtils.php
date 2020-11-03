<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use SecureNative\sdk\EventTypes;
use SecureNative\sdk\SecureNative;
use SecureNative\sdk\SecureNativeOptions;

function getClient($fail = false)
{
    $mock = new MockHandler([
        new Response($fail ? 500 : 200, [], '{ "success": "ok" }'),
        new Response($fail ? 400 : 202, ['Content-Length' => 0]),
        new Response($fail ? 500 : 200, [], '{ "success": "ok" }'),
        new Response($fail ? 400 : 202, ['Content-Length' => 0]),
        new Response($fail ? 500 : 200, [], '{ "success": "ok" }'),
        new Response($fail ? 400 : 202, ['Content-Length' => 0]),
        new Response($fail ? 500 : 200, [], '{ "success": "ok" }'),
        new Response($fail ? 400 : 202, ['Content-Length' => 0]),
    ]);

    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);
    return $client;
}

function mock_track_object($context = null)
{
    $options = new SecureNativeOptions();
    return array(
        'event' => EventTypes::LOG_IN,
        'context' => isset($context) ? $context : SecureNative::fromRequest($options),
        'userId' => '556595',
        'userTraits' => (object)[
            'name' => 'Your name',
            'email' => 'test@test.com'
        ],
        // Custom properties
        'properties' => (object)[
            "prop1" => "test",
            "prop2" => 3
        ]
    );
}