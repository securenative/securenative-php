<?php

namespace SecureNative\sdk;


class SecureNativeOptions
{
    private $apiKey;
    private $apiUrl;
    private $interval;
    private $maxEvents;
    private $timeout;
    private $autoSend;
    private $disable;
    private $logLevel;
    private $failoverStrategy;

    // Needed for option merging
    private $default = array(
        "apiKey" => null,
        "apiUrl" => "https://api.securenative.com/collector/api/v1",
        "interval" => 1000,
        "maxEvents" => 1000,
        "timeout" => 30000,
        "autoSend" => true,
        "disable" => false,
        "logLevel" => 'fatal',
        "failoverStrategy" => 'fail-open',
    );

    public function __construct($apiKey = null, $apiUrl = null, $interval = null, $maxEvents = null, $timeout = null, $autoSend = null, $disable = null, $logLevel = null)
    {
        $this->apiKey = isset($apiKey) ? $apiKey : $this->default["apiKey"];
        $this->apiUrl = isset($apiUrl) ? $apiUrl : $this->default["apiUrl"];
        $this->interval = isset($interval) ? $interval : $this->default["interval"];
        $this->maxEvents = isset($maxEvents) ?$maxEvents : $this->default["maxEvents"];
        $this->timeout = isset($timeout) ? $timeout : $this->default["timeout"];
        $this->autoSend = isset($autoSend) ? $autoSend : $this->default["autoSend"];
        $this->disable = isset($disable) ? $disable : $this->default["disable"];
        $this->logLevel = isset($logLevel) ? $logLevel : $this->default["logLevel"];
    }

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * @param string $apiKey
     * @return SecureNativeOptions
     */
    public function setApiKey(string $apiKey)
    {
        $this->apiKey = $apiKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getApiUrl(): string
    {
        return $this->apiUrl;
    }

    /**
     * @param string $apiUrl
     * @return SecureNativeOptions
     */
    public function setApiUrl(string $apiUrl): SecureNativeOptions
    {
        $this->apiUrl = $apiUrl;
        return $this;
    }

    /**
     * @return int
     */
    public function getInterval(): int
    {
        return $this->interval;
    }

    /**
     * @param int $interval
     * @return SecureNativeOptions
     */
    public function setInterval(int $interval): SecureNativeOptions
    {
        $this->interval = $interval;
        return $this;
    }

    /**
     * @return int
     */
    public function getMaxEvents(): int
    {
        return $this->maxEvents;
    }

    /**
     * @param int $maxEvents
     * @return SecureNativeOptions
     */
    public function setMaxEvents(int $maxEvents): SecureNativeOptions
    {
        $this->maxEvents = $maxEvents;
        return $this;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @param int $timeout
     * @return SecureNativeOptions
     */
    public function setTimeout(int $timeout): SecureNativeOptions
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAutoSend(): bool
    {
        return $this->autoSend;
    }

    /**
     * @param bool $autoSend
     * @return SecureNativeOptions
     */
    public function setAutoSend(bool $autoSend): SecureNativeOptions
    {
        $this->autoSend = $autoSend;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDisable(): bool
    {
        return $this->disable;
    }

    /**
     * @param bool $disable
     * @return SecureNativeOptions
     */
    public function setDisable(bool $disable): SecureNativeOptions
    {
        $this->disable = $disable;
        return $this;
    }

    /**
     * @return string
     */
    public function getLogLevel(): string
    {
        return $this->logLevel;
    }

    /**
     * @param string $logLevel
     * @return SecureNativeOptions
     */
    public function setLogLevel(string $logLevel): SecureNativeOptions
    {
        $this->logLevel = $logLevel;
        return $this;
    }

    /**
     * @return string
     */
    public function getFailoverStrategy(): string
    {
        return $this->failoverStrategy;
    }

    /**
     * @param string $failoverStrategy
     * @return SecureNativeOptions
     */
    public function setFailoverStrategy(string $failoverStrategy): SecureNativeOptions
    {
        $this->failoverStrategy = $failoverStrategy;
        return $this;
    }

    /**
     * Merge an existing `SecureNativeOptions` object into an existing one
     * @param SecureNativeOptions $options
     */
    public function mergeOptions(SecureNativeOptions $options) {
        $options->getApiKey() != $this->default["apiKey"] ? $this->setApiKey($options->getApiKey()) : null;
        $options->getApiUrl() != $this->default["apiUrl"] ? $this->setApiUrl($options->getApiUrl()) : null;
        $options->getInterval() != $this->default["interval"] ? $this->setInterval($options->getInterval()) : null;
        $options->getMaxEvents() != $this->default["maxEvents"] ? $this->setMaxEvents($options->getMaxEvents()) : null;
        $options->getTimeout() != $this->default["timeout"] ? $this->setTimeout($options->getTimeout()) : null;
        $options->isAutoSend() != $this->default["autoSend"] ? $this->setAutoSend($options->isAutoSend()) : null;
        $options->isDisable() != $this->default["disable"] ? $this->setDisable($options->isDisable()) : null;
        $options->getLogLevel() != $this->default["logLevel"] ? $this->setLogLevel($options->getLogLevel()) : null;
    }
}
