<?php

use SecureNative\sdk\SecureNative;
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
        $options = new SecureNativeOptions();
        $context = SecureNative::fromRequest($options);

//        SecureNative::track(array(
//            'event' => EventTypes::LOG_IN,
//            'context' => $context,
//            'userId' => '556595',
//            'userTraits' => (object)[
//                'name' => 'Your name',
//                'email' => 'test@test.com'
//            ],
//            // Custom properties
//            'properties' => (object)[
//                "prop1" => "test",
//                "prop2" => 3
//            ]
//        ));

        $this->assertNotNull($context, 'yo');
    }

}
