<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use SecureNative\sdk\EventManager;
use SecureNative\sdk\EventOptions;
use SecureNative\sdk\EventTypes;
use SecureNative\sdk\SecureNative;
use SecureNative\sdk\SecureNativeContext;
use SecureNative\sdk\SecureNativeOptions;
use SecureNative\sdk\VerifyResult;


function getClient($fail = false)
{
    $mock = new MockHandler([
        new Response($fail ? 500 : 200, [], '{ "success": "ok" }'),
        new Response($fail ? 400 : 202, ['Content-Length' => 0]),
    ]);

    $handlerStack = HandlerStack::create($mock);
    $client = new Client(['handler' => $handlerStack]);
    return $client;
}

function mock_track_object($context = null)
{
    return array(
        'event' => EventTypes::LOG_IN,
        'context' => isset($context) ? $context : SecureNative::getRequestContext(),
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

final class EventManagerTest extends PHPUnit\Framework\TestCase
{
    const TEST_API_KEY = 'sample_key';

    public function testEventOptions() {
        $mock = mock_track_object();
        $opt = new EventOptions($mock);

        $this->assertNotNull($opt);
        $this->assertEquals($mock['event'], $opt->event);
        $this->assertEquals($mock['userId'], $opt->userId);
        $this->assertEquals($mock['userTraits']->name, $opt->userTraits->name);
        $this->assertEquals($mock['userTraits']->email, $opt->userTraits->email);
        $this->assertObjectHasAttribute('context', $opt);
        $this->assertObjectHasAttribute('clientToken', $opt->context);
        $this->assertObjectHasAttribute('ip', $opt->context);
        $this->assertObjectHasAttribute('headers', $opt->context);
        $this->assertObjectHasAttribute('properties', $opt);
        $this->assertEquals($mock['properties']->prop1, $opt->properties['prop1']);
        $this->assertEquals($mock['properties']->prop2, $opt->properties['prop2']);
    }

    public function testBuildEvent() {
        $mock = mock_track_object();
        $snOptions = new SecureNativeOptions(self::TEST_API_KEY, "http://testushim.com");
        $opt = new EventOptions($mock);

        $eventManager = new EventManager(self::TEST_API_KEY, $snOptions, getClient());
        $event = $eventManager->buildEvent($opt);

        $this->assertNotNull($event);
        $this->assertNotEmpty($event->rid);
        $this->assertEquals($mock['event'], $event->eventType);
        $this->assertEquals($mock['userId'], $event->userId);
        $this->assertEquals($mock['userTraits']->name, $event->userTraits->name);
        $this->assertEquals($mock['userTraits']->email, $event->userTraits->email);
        $this->assertObjectHasAttribute('request', $event);
        $this->assertObjectHasAttribute('url', $event->request);
        $this->assertObjectHasAttribute('ip', $event->request);
        $this->assertObjectHasAttribute('headers', $event->request);
        $this->assertObjectHasAttribute('properties', $event);
        $this->assertEquals($mock['properties']->prop1, $event->properties['prop1']);
        $this->assertEquals($mock['properties']->prop2, $event->properties['prop2']);
    }

    public function testSendSync()
    {
        $options = new SecureNativeOptions(self::TEST_API_KEY, "http://testushim.com");
        $eventManager = new EventManager(self::TEST_API_KEY, $options, getClient());
        SecureNative::init(self::TEST_API_KEY, $options, $eventManager);
        $mock = mock_track_object();
        $opt = new EventOptions($mock);

        $event = $eventManager->buildEvent($opt);
        $response = $eventManager->sendSync($event, 'request dfsf');

        $this->assertNotNull($response);
        $this->assertIsObject($response);
        $this->assertObjectHasAttribute("success", $response);
    }

    // Should send sync event and fail when status code 401
    public function testSendFailSync()
    {
        $options = new SecureNativeOptions(self::TEST_API_KEY, "http://testushim.com");
        $eventManager = new EventManager(self::TEST_API_KEY, $options, getClient(true));
        SecureNative::init(self::TEST_API_KEY, $options, $eventManager);
        $mock = mock_track_object();
        $opt = new EventOptions($mock);

        $event = $eventManager->buildEvent($opt);
        $response = $eventManager->sendSync($event, 'request dfsf');

        // Error response should be null
        $this->assertNull($response);
    }

    public function testAsyncShouldRetry() {
        $options = new SecureNativeOptions(self::TEST_API_KEY, "http://testushim.com");
        $eventManager = new EventManager(self::TEST_API_KEY, $options, getClient(true));
        $mock = mock_track_object();
        $opt = new EventOptions($mock);

        $event = $eventManager->buildEvent($opt);

        $callbackRes = null;
        $eventManager->sendAsync($event, 'URL', function ($params) use (&$callbackRes) {
            $callbackRes = $params;
        });

        $eventsQueue = $eventManager->getEventsQueue();

        $this->assertNotEmpty($eventsQueue, 'Queue should be empty on success');
        $this->assertNull($callbackRes, 'Track callback should not be called');
    }


    public function testSendAsync()
    {
        $options = new SecureNativeOptions(self::TEST_API_KEY, "http://testushim.com");
        $eventManager = new EventManager(self::TEST_API_KEY, $options, getClient());
        $mock = mock_track_object();
        $opt = new EventOptions($mock);

        $event = $eventManager->buildEvent($opt);

        $callbackRes = null;
        $eventManager->sendAsync($event, 'URL', function ($params) use (&$callbackRes) {
            $callbackRes = $params;
        });

        $eventsQueue = $eventManager->getEventsQueue();

        $this->assertEmpty($eventsQueue, 'Queue should be empty on success');
        $this->assertNotNull($callbackRes, 'Track callback should be called');
        $this->assertNotEmpty($callbackRes->{'rid'});
        $this->assertEquals($callbackRes->{'eventType'}, $mock['event']);
        $this->assertEquals($callbackRes->{'userId'}, $mock['userId']);
        $this->assertObjectHasAttribute('request', $callbackRes);
        $this->assertObjectHasAttribute('name', $callbackRes->{'userTraits'});
        $this->assertObjectHasAttribute('email', $callbackRes->{'userTraits'});
        $this->assertObjectHasAttribute('prop1', $callbackRes->{'properties'});
        $this->assertObjectHasAttribute('prop2', $callbackRes->{'properties'});
    }

}
