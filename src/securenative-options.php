<?php

class SecureNativeOptions
{
  private $apiUrl = 'https://api.securenative.com/collector/api/v1';
  private $interval = 1000;
  private $maxEvents = 1000;
  private $timeout = 1500;
  private $autoSend = true;
  private $debugMode = true;

  public function getApiUrl()
  {
      return $this->apiUrl;
  }

  public function setApiUrl($apiUrl)
  {
      $this->apiUrl = $apiUrl;
      return $this;
  }

  public function getInterval()
  {
      return $this->interval;
  }

  public function setInterval($interval)
  {
      $this->interval = $interval;
      return $this;
  }

  public function getMaxEvents()
  {
      return $this->maxEvents;
  }

  public function setMaxEvents($maxEvents)
  {
      $this->maxEvents = $maxEvents;
      return $this;
  }

  public function getTimeout()
  {
      return $this->timeout;
  }

  public function setTimeout($timeout)
  {
      $this->timeout = $timeout;
      return $this;
  }

  public function getAutoSend()
  {
      return $this->autoSend;
  }

  public function setAutoSend($autoSend)
  {
      $this->autoSend = (bool)$autoSend;
      return $this;
  }

  public function getDebugMode()
  {
      return $this->debugMode;
  }

  public function setDebugMode($debugMode)
  {
      $this->debugMode = (bool)$debugMode;
      return $this;
  }
}
