<?php
declare(strict_types=1);

use GuzzleHttp\Exception\RequestException;
use PHPUnit\Framework\TestCase;
use SecureNative\sdk\SecureNative;
use SecureNative\sdk\SecureNativeOptions;
use SecureNative\sdk\Utils;
use SecureNative\sdk\VerifyResult;

const TEST_API_KEY = 'sample_key';

final class SecureNativeTest extends TestCase
{

    /**
     * @before
     */
    public static function initSDK()
    {
        SecureNative::init(TEST_API_KEY, new SecureNativeOptions());
    }

    public function testApiKeyException()
    {
        $this->expectException(Error::class);

        SecureNative::init('', new SecureNativeOptions());
    }

    public function testInitWorks()
    {
        $this->assertEquals(TEST_API_KEY, SecureNative::getApiKey());
    }

    public function testEmptyTrackAttributes()
    {
        $this->expectException(Error::class);

        // Should throw exception (http) - should try to send http request
        SecureNative::track(array());
    }

    public function testBasicTrack()
    {
        $this->expectException(RequestException::class);

        // Should throw exception (http) - should try to send http request
        SecureNative::track(array('ip' => '1.1.1.1'));
    }

    public function testBasicVerify()
    {
        $response = SecureNative::verify(array());

        // Response equals default verify results
        $this->assertEquals($response, new VerifyResult());
    }

    public function testDecryption()
    {
        $cookie = "821cb59a6647f1edf597956243e564b00c120f8ac1674a153fbd707da0707fb236ea040d1665f3d294aa1943afbae1b26b2b795a127f883ec221c10c881a147bb8acb7e760cd6f04edc21c396ee1f6c9627d9bf1315c484a970ce8930c2ed1011af7e8569325c7edcdf70396f1abca8486eabec24567bf215d2e60382c40e5c42af075379dacdf959cb3fef74f9c9d15";
        $apikey = "6EA4915349C0AAC6F6572DA4F6B00C42DAD33E75";
        $d = Utils::decrypt($cookie, $apikey);
        $e = "{\"cid\":\"198a41ff-a10f-4cda-a2f3-a9ca80c0703b\",\"fp\":\"6d8cabd95987f8318b1fe01593d5c2a5.24700f9f1986800ab4fcc880530dd0ed\"}";
        $this->assertEquals($e, $d);
    }

    public function testEncrypt()
    {
        $api_key = '6EA4915349C0AAC6F6572DA4F6B00C42DAD33E75';
        $data = "{\"cid\":\"198a41ff-a10f-4cda-a2f3-a9ca80c0703b\",\"fp\":\"6d8cabd95987f8318b1fe01593d5c2a5.24700f9f1986800ab4fcc880530dd0ed\"}";
        $enc = Utils::encrypt($data, $api_key);
        $dec = Utils::decrypt($enc, $api_key);
        $this->assertEquals($data, $dec);
    }
}