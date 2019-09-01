<?php

class SecurenativeEvent
{
  public $eventType;
  public $cid;
  public $vid;
  public $fp;
  public $ip;
  public $remoteIP;
  public $userAgent;
  public $user;
  public $ts;
  public $device;
  public $params = array();

  
  public function __construct($eventType, $cid, $vid, $fp, $ip, $remoteIP, $userAgent, $user, $ts, $device, $params)
  {
      $this->eventType = $eventType;
      $this->cid = $cid;
      $this->vid = $vid;
      $this->fp = $fp;
      $this->ip = $ip;
      $this->remoteIP = $remoteIP;
      $this->userAgent = $userAgent;
      $this->user = $user;
      $this->ts = $ts;
      $this->device = $device;
      $this->params = $params;
  }
}
