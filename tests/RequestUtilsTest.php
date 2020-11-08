<?php


use SecureNative\sdk\SecureNativeOptions;
use SecureNative\sdk\Utils;

class RequestUtilsTest extends PHPUnit\Framework\TestCase
{
    public function testProxyHeadersWithIpv4()
    {
        $options = new SecureNativeOptions();
        $options->setProxyHeaders(["CF-Connecting-IP"]);

        $_SERVER["CF-Connecting-IP"] = "203.0.113.1";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("203.0.113.1", $client_ip);
    }

    public function testProxyHeadersWithIpv6()
    {
        $options = new SecureNativeOptions();
        $options->setProxyHeaders(["CF-Connecting-IP"]);

        $_SERVER["CF-Connecting-IP"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testProxyHeadersWithMultipleHeaders()
    {
        $options = new SecureNativeOptions();
        $options->setProxyHeaders(["CF-Connecting-IP"]);

        $_SERVER["CF-Connecting-IP"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }
}