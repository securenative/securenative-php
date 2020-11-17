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

    public function testIpExtractionUsingXFORWARDEDFORHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["X_FORWARDED_FOR"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXFORWARDEDFORHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["X_FORWARDED_FOR"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingHTTPXREALIPHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_REAL_IP"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingHTTPXREALIPHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_REAL_IP"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingREMOTEADDRHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["REMOTE_ADDR"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingREMOTEADDRHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["REMOTE_ADDR"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingXClientIpHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-client-ip"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXClientIpHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-client-ip"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingXRealIpHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-real-ip"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXRealIpHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-real-ip"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingForwardedForHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["forwarded-for"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingForwardedForHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["forwarded-for"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingXClusterClientIpHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-cluster-client-ip"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXClusterClientIpHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-cluster-client-ip"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingXForwardedHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-forwarded"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXForwardedHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-forwarded"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingForwardedHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["forwarded"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingForwardedHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["forwarded"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingViaHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["via"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingViaHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["via"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingHTTPXCLIENTIPHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_CLIENT_IP"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingHTTPXCLIENTIPHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_CLIENT_IP"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testExtractionPriorityWithXForwardedFor()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_FORWARDED_FOR"] = "203.0.113.1";
        $_SERVER["HTTP_X_REAL_IP"] = "198.51.100.101";
        $_SERVER["HTTP_X_CLIENT_IP"] = "198.51.100.102";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("203.0.113.1", $client_ip);
    }

    public function testExtractionPriorityWithoutXForwardedFor()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_REAL_IP"] = "198.51.100.101";
        $_SERVER["HTTP_X_CLIENT_IP"] = "203.0.113.1, 141.246.115.116, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        $this->assertEquals("203.0.113.1", $client_ip);
    }
}