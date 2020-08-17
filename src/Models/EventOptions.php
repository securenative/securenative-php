<?php

namespace SecureNative\sdk;

class EventOptions
{
    const MAX_EVENT_PROPERTIES_COUNT = 10;

    const EVENT = 'event';
    const EVENT_USER_ID = 'userId';
    const EVENT_USER_TRAITS = 'userTraits';
    const EVENT_USER_TRAITS_NAME = 'name';
    const EVENT_USER_TRAITS_EMAIL = 'email';
    const EVENT_USER_TRAITS_CREATED_AT = 'createdAt';
    const EVENT_CONTEXT = 'context';
    const EVENT_CONTEXT_CLIENT_TOKEN = 'clientToken';
    const EVENT_CONTEXT_IP = 'ip';
    const EVENT_CONTEXT_REMOTE_IP = 'remoteIp';
    const EVENT_CONTEXT_HEADERS = 'headers';
    const EVENT_CONTEXT_URL = 'url';
    const EVENT_CONTEXT_METHOD = 'url';
    const EVENT_PROPERTIES = 'properties';
    const EVENT_TIMESTAMP = 'timestamp';


    public $event;
    public $userId;
    public $userTraits;
    public $context;
    public $properties = null;
    public $timestamp;

    public function __construct($json = false){
        if ($json) $this->set(json_decode($json, true));
    }

    private function set($data){
        $this->event = isset($data[self::EVENT]) ? $data[self::EVENT] : null;
        $this->userId = isset($data[self::EVENT_USER_ID]) ? $data[self::EVENT_USER_ID] : null;

        if (isset($data[self::EVENT_USER_TRAITS])) {
            $userTraits = $data[self::EVENT_USER_TRAITS];
            $this->userTraits = new UserTraits(
                isset($userTraits[self::EVENT_USER_TRAITS_NAME]) ? $userTraits[self::EVENT_USER_TRAITS_NAME] : '',
                isset($userTraits[self::EVENT_USER_TRAITS_EMAIL]) ? $userTraits[self::EVENT_USER_TRAITS_EMAIL] : '',
                isset($userTraits[self::EVENT_USER_TRAITS_CREATED_AT]) ? $userTraits[self::EVENT_USER_TRAITS_CREATED_AT] : null
            );
        }

        if (isset($data[self::EVENT_CONTEXT])) {
            $context = $data[self::EVENT_CONTEXT];
            $this->context = new Context(
                isset($context[self::EVENT_CONTEXT_CLIENT_TOKEN]) ? $context[self::EVENT_CONTEXT_CLIENT_TOKEN] : '',
                isset($context[self::EVENT_CONTEXT_IP]) ? $context[self::EVENT_CONTEXT_IP] : '',
                isset($context[self::EVENT_CONTEXT_REMOTE_IP]) ? $context[self::EVENT_CONTEXT_REMOTE_IP] : '',
                isset($context[self::EVENT_CONTEXT_HEADERS]) ? $context[self::EVENT_CONTEXT_HEADERS] : (object)[],
                isset($context[self::EVENT_CONTEXT_URL]) ? $context[self::EVENT_CONTEXT_URL] : '',
                isset($context[self::EVENT_CONTEXT_METHOD]) ? $context[self::EVENT_CONTEXT_METHOD] : ''
            );
        }


        if (isset($data[self::EVENT_PROPERTIES]) && count($data[self::EVENT_PROPERTIES]) > self::MAX_EVENT_PROPERTIES_COUNT) {
            throw new \Exception('You can only set up to ' . self::MAX_EVENT_PROPERTIES_COUNT . ' custom properties');
        }

        $this->properties = isset($data[self::EVENT_PROPERTIES]) && count($data[self::EVENT_PROPERTIES]) > 0 ? $data[self::EVENT_PROPERTIES] : null;
        $this->timestamp = isset($data[self::EVENT_TIMESTAMP]) ? $data[self::EVENT_TIMESTAMP] : null;
    }
}
