<?php


class User
{
    public $id;
    public $name;
    public $email;

    public function __construct($id, $name = null, $email = null)
    {
        $this->id = $id;
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
    const EVENT_USER_ID = 'id';
    const EVENT_USER_NAME = 'name';
    const EVENT_USER_EMAIL = 'email';
    const EVENT_DEVICE = 'device';
    const EVENT_PARAMS = 'params';

    public $ip;
    public $userAgent;
    public $eventType;
    public $remoteIp;
    public $user;
    public $device;
    public $params = array();

    public function __construct($json = false)
    {
        if ($json) $this->set(json_decode($json, true));
    }

    private function set($data)
    {
        $user = $data[self::EVENT_USER];

        $this->user = new User(
            isset($user[self::EVENT_USER_ID]) ? $user[self::EVENT_USER_ID] : '',
            isset($user[self::EVENT_USER_NAME]) ? $user[self::EVENT_USER_NAME] : '',
            isset($user[self::EVENT_USER_EMAIL]) ? $user[self::EVENT_USER_EMAIL] : ''
        );
        $this->device = isset($data[self::EVENT_DEVICE]) ? $data[self::EVENT_DEVICE] : null;
        $this->ip = isset($data[self::EVENT_IP]) ? $data[self::EVENT_IP] : null;
        $this->userAgent = isset($data[self::EVENT_USER_AGENT]) ? $data[self::EVENT_USER_AGENT] : null;
        $this->eventType = isset($data[self::EVENT_EVENT_TYPE]) ? $data[self::EVENT_EVENT_TYPE] : null;
        $this->remoteIp = isset($data[self::EVENT_REMOTE_IP]) ? $data[self::EVENT_REMOTE_IP] : null;
        $this->params = isset($data[self::EVENT_PARAMS]) ? $data[self::EVENT_PARAMS] : array();
    }

//    private function set($data)
//    {
//        foreach ($data AS $key => $value) {
//            if (is_array($value)) {
//                //$sub = new JSONObject;
//                // TODO: Ask Alex what type of object is correct here
//                $sub = new EventOptions;
//                $sub->set($value);
//                $value = $sub;
//            }
//            $this->{$key} = $value;
//        }
//    }
}
