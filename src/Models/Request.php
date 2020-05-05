<?php

namespace SecureNative\sdk;

class Request
{
    public $cid;
    public $vid;
    public $fp;
    public $ip;
    public $remoteIp;
    public $method;
    public $url;
    public $headers;

    /**
     * Request constructor.
     * @param $cid
     * @param $vid
     * @param $fp
     * @param $ip
     * @param $remoteIp
     * @param $method
     * @param $url
     * @param $headers
     */
    public function __construct($cid, $vid, $fp, $ip, $remoteIp, $method, $url, $headers)
    {
        $this->cid = $cid;
        $this->vid = $vid;
        $this->fp = $fp;
        $this->ip = $ip;
        $this->remoteIp = $remoteIp;
        $this->method = $method;
        $this->url = $url;
        $this->headers = $headers;
    }

    /**
     * @return mixed
     */
    public function getCid()
    {
        return $this->cid;
    }

    /**
     * @param mixed $cid
     * @return Request
     */
    public function setCid($cid)
    {
        $this->cid = $cid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getVid()
    {
        return $this->vid;
    }

    /**
     * @param mixed $vid
     * @return Request
     */
    public function setVid($vid)
    {
        $this->vid = $vid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFp()
    {
        return $this->fp;
    }

    /**
     * @param mixed $fp
     * @return Request
     */
    public function setFp($fp)
    {
        $this->fp = $fp;
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
     * @return Request
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
     * @return Request
     */
    public function setRemoteIp($remoteIp)
    {
        $this->remoteIp = $remoteIp;
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
     * @return Request
     */
    public function setMethod($method)
    {
        $this->method = $method;
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
     * @return Request
     */
    public function setUrl($url)
    {
        $this->url = $url;
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
     * @return Request
     */
    public function setHeaders($headers)
    {
        $this->headers = $headers;
        return $this;
    }
}



