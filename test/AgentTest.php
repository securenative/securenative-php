<?php

use SecureNative\sdk\EventTypes;
use SecureNative\sdk\SecureNative;
use SecureNative\sdk\SecureNativeContext;
use SecureNative\sdk\SecureNativeOptions;

final class AgentTest extends PHPUnit\Framework\TestCase
{
    const TEST_API_KEY = 'sample_key';
    /**
     * @before
     */
    public static function initSDK()
    {
        SecureNative::init(TEST_API_KEY, new SecureNativeOptions());
    }

    public function testApiKeyException()
    {
        $context = SecureNativeContext::fromRequest();

        SecureNative::track(array(
            'event' => EventTypes::LOG_IN,
            'context' => $context,
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
        ));
    }

}
