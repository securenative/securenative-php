<?php

use SecureNative\sdk\ConfigurationManager;
use SecureNative\sdk\SecureNativeOptions;

function get_mock_config($filename = 'securenative.json')
{
    $cwd = getcwd();
    $basePath = $cwd . (strpos($cwd, '/tests') === false ?  '/tests/assets/' : '/assets/');
    return $basePath . $filename;
}

final class ConfigurationManagerTest extends PHPUnit\Framework\TestCase
{
    /**
     * @before
     */
    public static function init()
    {
        ConfigurationManager::clearConfig();
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
        $options = ConfigurationManager::getConfig(get_mock_config());

        $this->assertNotEmpty($options);
        $this->assertObjectHasAttribute('apiKey', $options);
        $this->assertObjectHasAttribute('apiUrl', $options);
        $this->assertObjectHasAttribute('interval', $options);
        $this->assertEquals('SOME_API_KEY', $options->getApiKey());
        $this->assertEquals('SOME_API_URL', $options->getApiUrl());
        $this->assertEquals(1000, $options->getInterval());
    }

    private function getConfigTestKeys()
    {
        return (object)[
            'SECURENATIVE_API_KEY' => (object)['name' => 'getApiKey', 'value' => 'TEST_KEY'],
            'SECURENATIVE_API_URL' => (object)['name' => 'getApiUrl', 'value' => 'http://url'],
            'SECURENATIVE_INTERVAL' => (object)['name' => 'getInterval', 'value' => 100],
            'SECURENATIVE_MAX_EVENTS' => (object)['name' => 'getMaxEvents', 'value' => 30],
            'SECURENATIVE_TIMEOUT' => (object)['name' => 'getTimeout', 'value' => 2500],
            'SECURENATIVE_AUTO_SEND' => (object)['name' => 'isAutoSend', 'value' => true],
            'SECURENATIVE_DISABLE' => (object)['name' => 'isDisable', 'value' => false],
            'SECURENATIVE_LOG_LEVEL' => (object)['name' => 'getLogLevel', 'value' => 'log'],
            'SECURENATIVE_FAILOVER_STRATEGY' => (object)['name' => 'getFailoverStrategy', 'value' => 'failush'],
        ];
    }

    // Should get config via env variables
    public function testEnvironmentVariables()
    {
        $testKeys = $this->getConfigTestKeys();

        // Set env for each ovject item
        foreach ($testKeys as $key => $item) {
            putenv("$key=" . $item->value);
        }

        $options = ConfigurationManager::getConfig();

        $this->assertNotEmpty($options);

        // Assert options value equals env value
        foreach ($testKeys as $key => $item) {
            $this->assertEquals($item->value, call_user_func(array($options, $item->name)));
            // Clear env variables after test
            putenv($key);
        }
    }

    // Should get default config when config file and env variables are missing
    public function testDefaultParams() {
        $options = ConfigurationManager::getConfig();

        $snOptions = new SecureNativeOptions();
        $testKeys = $this->getConfigTestKeys();

        foreach ($testKeys as $key => $item) {
            $this->assertEquals(call_user_func(array($snOptions, $item->name)), call_user_func(array($options, $item->name)));
        }
    }

    // Should overwrite env variables with values from config file
    public function testEnvironmentVariablesOverride()
    {
        $testKeys = $this->getConfigTestKeys();

        // Set env for each ovject item
        foreach ($testKeys as $key => $item) {
            putenv("$key=" . $item->value);
        }

        $options = ConfigurationManager::getConfig(get_mock_config());

        $this->assertNotEmpty($options);

        $this->assertEquals('SOME_API_KEY', $options->getApiKey());
        $this->assertEquals('SOME_API_URL', $options->getApiUrl());
        $this->assertEquals(1000, $options->getInterval());
        $this->assertEquals(100, $options->getMaxEvents());
        $this->assertEquals(1500, $options->getTimeout());
        $this->assertEquals(true, $options->isAutoSend());
        $this->assertEquals(false, $options->isDisable());
        $this->assertEquals("fatal", $options->getLogLevel());

        foreach ($testKeys as $key => $item) {
            // Clear env variables after test
            putenv($key);
        }
    }

}