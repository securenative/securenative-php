<?php

namespace SecureNative\sdk;

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
    const EVENT_PARAMS_ATTR = 'param_';
    const EVENT_PARAMS_COUNT = 6;

    public $ip;
    public $userAgent;
    public $eventType;
    public $remoteIp;
    public $user;
    public $device;
    public $params = null;

    public function __construct($json = false)
    {
        if ($json) $this->set(json_decode($json, true));
    }

    private function set($data)
    {
        if (isset($data[self::EVENT_USER])) {
            $user = $data[self::EVENT_USER];

            $this->user = new User(
                isset($user[self::EVENT_USER_ID]) ? $user[self::EVENT_USER_ID] : '',
                isset($user[self::EVENT_USER_NAME]) ? $user[self::EVENT_USER_NAME] : '',
                isset($user[self::EVENT_USER_EMAIL]) ? $user[self::EVENT_USER_EMAIL] : ''
            );
        }
        $this->device = isset($data[self::EVENT_DEVICE]) ? $data[self::EVENT_DEVICE] : null;
        $this->ip = isset($data[self::EVENT_IP]) ? $data[self::EVENT_IP] : null;
        $this->userAgent = isset($data[self::EVENT_USER_AGENT]) ? $data[self::EVENT_USER_AGENT] : null;
        $this->eventType = isset($data[self::EVENT_EVENT_TYPE]) ? $data[self::EVENT_EVENT_TYPE] : null;
        $this->remoteIp = isset($data[self::EVENT_REMOTE_IP]) ? $data[self::EVENT_REMOTE_IP] : null;

        if (isset($data[self::EVENT_PARAMS])) {
            $this->setParams($data[self::EVENT_PARAMS]);
        }
    }

    private function setParams($params)
    {
        $mappedParams = array();

        if (isset($params)) {
            for ($i = 1; $i <= self::EVENT_PARAMS_COUNT; $i++) {
                // Map param 1 - COUNT if value exists in JSON
                $mappedParams[self::EVENT_PARAMS_ATTR . $i] = isset($params[self::EVENT_PARAMS_ATTR . $i]) ? $params[self::EVENT_PARAMS_ATTR . $i] : '';
            }
        }

        $this->params = $mappedParams;
    }
}
