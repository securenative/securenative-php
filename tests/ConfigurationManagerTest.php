<?php

use SecureNative\sdk\ConfigurationManager;

function get_mock_config($filename = 'securenative.json') {
    return getcwd() .'/assets/' . $filename;
}

final class ConfigurationManagerTest extends PHPUnit\Framework\TestCase
{

    /**
     * @before
     */
    public static function init()
    {
    }

    public function testReadConfigFile()
    {
        $arr = ConfigurationManager::readConfigFile(get_mock_config());

        $this->assertArrayHasKey('apiKey', $arr);
        $this->assertArrayHasKey('apiUrl', $arr);
        $this->assertArrayHasKey('appName', $arr);
        $this->assertArrayHasKey('interval', $arr);
        $this->assertArrayHasKey('maxEvents', $arr);
        $this->assertArrayHasKey('timeout', $arr);
        $this->assertArrayHasKey('autoSend', $arr);
        $this->assertArrayHasKey('disable', $arr);
        $this->assertArrayHasKey('logLevel', $arr);
    }

    public function testUnknownKeys()
    {
        $arr = ConfigurationManager::readConfigFile(get_mock_config('unknown_entries.json'));

        $this->assertArrayHasKey('timeout', $arr);
        $this->assertEquals(1, sizeof($arr));
    }

    public function testInvalidFile()
    {
        $arr = ConfigurationManager::readConfigFile(get_mock_config('invalid.json'));

        $this->assertEmpty($arr);
    }

    public function testInvalidFileEntries()
    {
        $arr = ConfigurationManager::readConfigFile(get_mock_config('invalid_entries.json'));

        $this->assertEquals(1, sizeof($arr), "Incorrect number of options");
        $this->assertArrayHasKey('logLevel', $arr);
    }

    public function testLoadConfig()
    {
        $json = ConfigurationManager::getConfig(get_mock_config());
        print_r($json);
    }

    // TODO: Test environment variables (Should get config via env variables)

    // TODO: Test default params (Should get default config when config file and env variables are missing)

    // TODO: Should overwrite env variables with vales from config file

    // TODO: Should set defaults for invalid enum properties


}