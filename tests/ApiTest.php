<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use SecureNative\sdk\EventManager;
use SecureNative\sdk\EventTypes;
use SecureNative\sdk\SecureNative;
use SecureNative\sdk\SecureNativeContext;
use SecureNative\sdk\SecureNativeOptions;
use SecureNative\sdk\VerifyResult;


function getClient()
{
    $mock = new MockHandler([
        new Response(200, [], 'Yo Body stuff'),
        new Response(202, ['Content-Length' => 0]),
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

final class AgentTest extends PHPUnit\Framework\TestCase
{
    const TEST_API_KEY = 'sample_key';

    /**
     * @before
     */
    public static function initSDK()
    {

    }

    public function testTrack()
    {
        $options = new SecureNativeOptions("http://testushim.com");
        $eventManager = new EventManager(self::TEST_API_KEY, $options, getClient());
        SecureNative::init(self::TEST_API_KEY, $options, $eventManager);
        $trackObject = mock_track_object();


        $callbackRes = null;
        SecureNative::track($trackObject, function ($params) use (&$callbackRes) {
            $callbackRes = $params;
        });

        $eventsQueue = $eventManager->getEventsQueue();

        $this->assertEmpty($eventsQueue, 'Queue should be empty on success');
        $this->assertNotNull($callbackRes, 'Track callback should be called');
        $this->assertNotEmpty($callbackRes->{'rid'});
        $this->assertEquals($callbackRes->{'eventType'}, $trackObject['event']);
        $this->assertEquals($callbackRes->{'userId'}, $trackObject['userId']);
        $this->assertObjectHasAttribute('request', $callbackRes);
        $this->assertObjectHasAttribute('name', $callbackRes->{'userTraits'});
        $this->assertObjectHasAttribute('email', $callbackRes->{'userTraits'});
        $this->assertObjectHasAttribute('prop1', $callbackRes->{'properties'});
        $this->assertObjectHasAttribute('prop2', $callbackRes->{'properties'});
    }

    public function testTrackCustomContext()
    {
        $options = new SecureNativeOptions("http://testushim.com");
        $eventManager = new EventManager(self::TEST_API_KEY, $options, getClient());
        SecureNative::init(self::TEST_API_KEY, $options, $eventManager);
        $context = new SecureNativeContext("123ABC123ABC123ABC123ABC123ABC123ABC123ABC123ABC", "12.12.12.1", "33.33.33.33", ["User-Agent" => "Amit"], "yo.com");
        $trackObject = mock_track_object($context);


        $callbackRes = null;
        SecureNative::track($trackObject, function ($params) use (&$callbackRes) {
            $callbackRes = $params;
        });

        $eventsQueue = $eventManager->getEventsQueue();

        $this->assertEmpty($eventsQueue, 'Queue should be empty on success');
        $this->assertNotNull($callbackRes, 'Track callback should be called');
        $this->assertObjectHasAttribute('request', $callbackRes);
        $this->assertEquals($callbackRes->{'request'}->ip, $trackObject['context']->ip);
        $this->assertEquals($callbackRes->{'request'}->remoteIp, $trackObject['context']->remoteIp);
        $this->assertEquals($callbackRes->{'request'}->url, $trackObject['context']->url);
        $this->assertObjectHasAttribute('headers', $callbackRes->{'request'});
        $this->assertObjectHasAttribute('User-Agent', $callbackRes->{'request'}->headers);
    }

    public function testVerify()
    {
        $options = new SecureNativeOptions("http://testushim.com");
        $eventManager = new EventManager(self::TEST_API_KEY, $options, getClient());
        SecureNative::init(self::TEST_API_KEY, $options, $eventManager);
        $trackObject = mock_track_object();

        $response = SecureNative::verify($trackObject);

        $this->assertEquals($response, new VerifyResult(), 'Result should be equal to empty verify result');
    }

}
