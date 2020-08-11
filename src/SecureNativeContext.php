<?php


namespace SecureNative\sdk;


class SecureNativeContext
{
    public $clientToken;
    public $ip;
    public $remoteIp;
    public $headers;
    public $url;
    public $method;
    public $body;

    /**
     * SecureNativeContext constructor.
     * @param $clientToken
     * @param $ip
     * @param $remoteIp
     * @param $headers
     * @param $url
     * @param $method
     * @param $body
     */
    public function __construct($clientToken, $ip, $remoteIp, $headers, $url, $method, $body)
    {
        $this->clientToken = $clientToken;
        $this->ip = $ip;
        $this->remoteIp = $remoteIp;
        $this->headers = $headers;
        $this->url = $url;
        $this->method = $method;
        $this->body = $body;
    }

    public static function fromRequest() : SecureNativeContext
    {
        $clientToken = Utils::cookieIdFromRequest() ? Utils::cookieIdFromRequest() : Utils::securHeaderFromRequest();
        $ip = Utils::clientIpFromRequest();
        $remoteIp = Utils::clientIpFromRequest();
        $headers =  Utils::headersFromRequest();
        $url =  Utils::urlFromRequest();
        $method =  Utils::methodFromRequest();
        $body = null;

        return new SecureNativeContext($clientToken, $ip, $remoteIp, $headers, $url, $method, $body);
    }

    /**
     * @return mixed
     */
    public function getClientToken()
    {
        return $this->clientToken;
    }

    /**
     * @param mixed $clientToken
     * @return SecureNativeContext
     */
    public function setClientToken($clientToken)
    {
        $this->clientToken = $clientToken;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     * @return SecureNativeContext
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemoteIp()
    {
        return $this->remoteIp;
    }

    /**
     * @param mixed $remoteIp
     * @return SecureNativeContext
     */
    public function setRemoteIp($remoteIp)
    {
        $this->remoteIp = $remoteIp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * @param mixed $headers
     * @return SecureNativeContext
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     * @return SecureNativeContext
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return SecureNativeContext
     */
    public function setMethod($method)
    {
        $this->method = $method;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @param mixed $body
     * @return SecureNativeContext
     */
    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
}

