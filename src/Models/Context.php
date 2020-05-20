<?php

namespace SecureNative\sdk;

class Context
{
    public $clientToken;
    public $ip;
    public $remoteIp;
    public $headers;
    public $url;
    public $method;

    public function __construct($clientToken = null, $ip = null, $remoteIp = null, $headers = null, $url= null, $method = null)
    {
        $this->clientToken = $clientToken;
        $this->ip = $ip;
        $this->remoteIp = $remoteIp;
        $this->headers = $headers;
        $this->url = $url;
        $this->method = $method;
    }
}
