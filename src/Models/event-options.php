<?php

class User
{
  public $id;
  public $name;
  public $email;

  public function __construct($id, $name = null, $email = null)
  {
    $this->$id = $id;
    $this->name = $name;
    $this->email = $email;
  }  
}

class EventOptions
{
  public $ip;
  public $userAgent;
  public $eventType;
  public $remoteIp;
  public $user;
  public $device;
  public $params = array();
}
