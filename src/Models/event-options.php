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
  const EVENT_IP = 'ip';
  const EVENT_USER_AGENT = 'userAgent';
  const EVENT_EVENT_TYPE = 'eventType';
  const EVENT_REMOTE_IP = 'remoteIp';
  const EVENT_USER = 'user';
  const EVENT_USER_ID = 'user';
  const EVENT_USER_NAME= 'user';
  const EVENT_USER_EMAIL = 'user';
  const EVENT_DEVICE = 'device';
  const EVENT_PARAMS = 'params';

  public $ip;
  public $userAgent;
  public $eventType;
  public $remoteIp;
  public $user;
  public $device;
  public $params = array();

  public function __construct($json = false) {
    if ($json) $this->set(json_decode($json, true));
  }

  private function set($data) {
      foreach ($data AS $key => $value) {
          if (is_array($value)) {
              $sub = new JSONObject;
              $sub->set($value);
              $value = $sub;
          }
          $this->{$key} = $value;
      }
  }
}
