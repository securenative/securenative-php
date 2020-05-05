<?php

namespace SecureNative\sdk;

class Context
{
    public $clientToken;
    public $ip;
    public $remoteIp;
    public $headers;

    public function __construct($clientToken = null, $ip = null, $remoteIp = null, $headers = null)
    {
        $this->clientToken = $clientToken;
        $this->ip = $ip;
        $this->remoteIp = $remoteIp;
        $this->headers = $headers;
    }
}
