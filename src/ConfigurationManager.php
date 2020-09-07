<?php

namespace SecureNative\sdk;

function getConfigMap() {
    return (object)[
        'SECURENATIVE_API_KEY' => (object)[ 'name' => 'apiKey', 'type' => 'string' ],
        'SECURENATIVE_APP_NAME' => (object)[ 'name' => 'appName', 'type' => 'string' ],
        'SECURENATIVE_API_URL' => (object)[ 'name' => 'apiUrl', 'type' => 'string' ],
        'SECURENATIVE_INTERVAL' => (object)[ 'name' => 'interval', 'type' => 'integer' ],
        'SECURENATIVE_MAX_EVENTS' => (object)[ 'name' => 'maxEvents', 'type' => 'integer' ],
        'SECURENATIVE_TIMEOUT' => (object)[ 'name' => 'timeout', 'type' => 'integer' ],
        'SECURENATIVE_AUTO_SEND' => (object)[ 'name' => 'autoSend', 'type' => 'boolean' ],
        'SECURENATIVE_DISABLE' => (object)[ 'name' => 'disable', 'type' => 'boolean' ],
        'SECURENATIVE_LOG_LEVEL' => (object)[ 'name' => 'logLevel', 'type' => 'string' ],
        'SECURENATIVE_FAILOVER_STRATEGY' => (object)[ 'name' => 'failoverStrategy', 'type' => 'string' ],
    ];
}

function getConfigMapItem($key) {
    return getConfigMap()->{$key};
}

class ConfigurationManager
{
    const CONFIG_FILE = 'securenative.json';

    public static SecureNativeOptions $config;

    static function readConfigFile($configFilePath = null)
    {
        $configMap = getConfigMap();
        $validConfigValues = array();
        $path = isset($configFilePath) ? $configFilePath : join('/', array(trim(getcwd(), '/'), self::CONFIG_FILE));

        try {
            $file = file_get_contents($path);
            $json = json_decode($file);

            if (is_array($json) || is_object($json)) {
                foreach ($json as $key => $val) {
                    // If config item exists
                    if (property_exists($configMap, $key)) {
                        $mapItem = $configMap->{$key};
                        // Prop type matches desired type
                        if ($mapItem->type == gettype($val)) {
                            $validConfigValues[$mapItem->name] = $val;
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // TODO: Testing error (logger not initialized)
            //Logger::error("Error loading configuration file");
        }

        return $validConfigValues;
    }

    static function setConfigKey($key, $val)
    {
        if (isset(self::$config)) {
            self::$config[$key] = $val;
        }
    }

    static function getConfigKey($key)
    {
        return self::$config[$key];
    }

    private static function loadConfig($configFilePath = null)
    {
        $fileConfig = self::readConfigFile($configFilePath);

        // Returns config item value -> if not found returns env value -> if not found -> null
        $getConfigOrEnv = function ($configKey, $envKey) use($fileConfig) {
            $type = getConfigMapItem($envKey)->type;
            $envVal = getenv($envKey) ? getenv($envKey) : null;

            if (isset($envVal)) {
                if ($type == "integer") {
                    $envVal = intval($envVal);
                } else if ($type == "boolean") {
                    $envVal = boolval($envVal);
                }
            }

            return isset($fileConfig[$configKey]) ? $fileConfig[$configKey] : $envVal;
        };

        self::$config = new SecureNativeOptions(
            $getConfigOrEnv('apiKey', 'SECURENATIVE_API_KEY'),
            $getConfigOrEnv('apiUrl', 'SECURENATIVE_API_URL'),
            $getConfigOrEnv('interval', 'SECURENATIVE_INTERVAL'),
            $getConfigOrEnv('maxEvents', 'SECURENATIVE_MAX_EVENTS'),
            $getConfigOrEnv('timeout', 'SECURENATIVE_TIMEOUT'),
            $getConfigOrEnv('autoSend', 'SECURENATIVE_AUTO_SEND'),
            $getConfigOrEnv('disable', 'SECURENATIVE_DISABLE'),
            $getConfigOrEnv('logLevel', 'SECURENATIVE_LOG_LEVEL'),
            $getConfigOrEnv('failoverStrategy', 'SECURENATIVE_FAILOVER_STRATEGY'),
        );
    }

    static function getConfig($configFilePath = null): SecureNativeOptions
    {
        if (!isset(self::$config)) {
            self::loadConfig($configFilePath);
        }
        return self::$config;
    }


}