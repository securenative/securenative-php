<?php

namespace SecureNative\sdk;

class SecurenativeEvent
{
  public $rid;
  public $eventType;
  public $userId;
  public $userTraits;
  public $request;
  public $properties;
  public $timestamp;

    /**
     * SecurenativeEvent constructor.
     * @param $rid
     * @param $eventType
     * @param $userId
     * @param $userTraits
     * @param $request
     * @param array $properties
     * @param $timestamp
     */
    public function __construct($rid, $eventType, $userId, $userTraits, $request, $properties, $timestamp)
    {
        $this->rid = $rid;
        $this->eventType = $eventType;
        $this->userId = $userId;
        $this->userTraits = $userTraits;
        $this->request = $request;
        $this->properties = $properties;
        $this->timestamp = $timestamp;
    }
}
