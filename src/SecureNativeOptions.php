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
    private $proxyHeaders;
    private $piiHeaders;
    private $piiRegexPattern;

    // Needed for option merging
    private $default = array(
        "apiKey" => "",
        "apiUrl" => "https://api.securenative.com/collector/api/v1",
        "interval" => 1000,
        "maxEvents" => 1000,
        "timeout" => 30000,
        "autoSend" => true,
        "disable" => false,
        "logLevel" => 'fatal',
        "failoverStrategy" => 'fail-open',
        "proxyHeaders" => array(),
        "piiHeaders" => array(),
        "piiRegexPattern" => ""
    );

    public function __construct($apiKey = null, $apiUrl = null, $interval = null, $maxEvents = null, $timeout = null, $autoSend = null, $disable = null, $logLevel = null, $failoverStrategy = null, $proxyHeaders = null, $piiHeaders = null, $piiRegex = null)
    {
        $this->apiKey = isset($apiKey) ? $apiKey : $this->default["apiKey"];
        $this->apiUrl = isset($apiUrl) ? $apiUrl : $this->default["apiUrl"];
        $this->interval = isset($interval) ? $interval : $this->default["interval"];
        $this->maxEvents = isset($maxEvents) ?$maxEvents : $this->default["maxEvents"];
        $this->timeout = isset($timeout) ? $timeout : $this->default["timeout"];
        $this->autoSend = isset($autoSend) ? $autoSend : $this->default["autoSend"];
        $this->disable = isset($disable) ? $disable : $this->default["disable"];
        $this->logLevel = isset($logLevel) ? $logLevel : $this->default["logLevel"];
        $this->failoverStrategy = isset($failoverStrategy) ? $failoverStrategy : $this->default["failoverStrategy"];
        $this->proxyHeaders = isset($proxyHeaders) ? $proxyHeaders : $this->default["proxyHeaders"];
        $this->piiHeaders = isset($piiHeaders) ? $piiHeaders : $this->default["piiHeaders"];
        $this->piiRegexPattern = isset($piiRegexPattern) ? $piiRegexPattern : $this->default["piiRegexPattern"];
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
     * @return array
     */
    public function getProxyHeaders(): array
    {
        return $this->proxyHeaders;
    }

    /**
     * @param array $proxyHeaders
     * @return SecureNativeOptions
     */
    public function setProxyHeaders(array $proxyHeaders): SecureNativeOptions
    {
        $this->proxyHeaders = $proxyHeaders;
        return $this;
    }

    /**
     * @return array
     */
    public function getPiiHeaders(): array
    {
        return $this->piiHeaders;
    }

    /**
     * @param array $piiHeaders
     * @return SecureNativeOptions
     */
    public function setPiiHeaders(array $piiHeaders): SecureNativeOptions
    {
        $this->piiHeaders = $piiHeaders;
        return $this;
    }

    /**
     * @return string
     */
    public function getPiiRegexPattern(): string
    {
        return $this->piiRegexPattern;
    }

    /**
     * @param string $piiRegexPattern
     * @return SecureNativeOptions
     */
    public function setPiiRegexPattern(string $piiRegexPattern): SecureNativeOptions
    {
        $this->piiRegexPattern = $piiRegexPattern;
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
        $options->getFailoverStrategy() != $this->default["failoverStrategy"] ? $this->setFailoverStrategy($options->getFailoverStrategy()) : null;
        $options->getProxyHeaders() != $this->default["proxyHeaders"] ? $this->setProxyHeaders($options->getProxyHeaders()) : null;
        $options->getPiiHeaders() != $this->default["piiHeaders"] ? $this->setPiiHeaders($options->getPiiHeaders()) : null;
        $options->getPiiRegexPattern() != $this->default["piiRegexPattern"] ? $this->setPiiRegexPattern($options->getPiiRegexPattern()) : null;
    }
}
