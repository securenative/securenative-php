<?php

namespace SecureNative\sdk;

class SecureNativeOptions
{
    private $apiKey = null;
    private $apiUrl = 'https://api.securenative.com/collector/api/v1';
    private $interval = 1000;
    private $maxEvents = 1000;
    private $timeout = 30000;
    private $autoSend = true;
    private $disable = false;
    private $logLevel = 'fatal';
    private $failoverStrategy = 'fail-open';

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

}
