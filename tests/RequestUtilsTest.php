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
        unset($_SERVER["CF-Connecting-IP"]);
        $this->assertEquals("203.0.113.1", $client_ip);
    }

    public function testProxyHeadersWithIpv6()
    {
        $options = new SecureNativeOptions();
        $options->setProxyHeaders(["CF-Connecting-IP"]);

        $_SERVER["CF-Connecting-IP"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["CF-Connecting-IP"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testProxyHeadersWithMultipleHeaders()
    {
        $options = new SecureNativeOptions();
        $options->setProxyHeaders(["CF-Connecting-IP"]);

        $_SERVER["CF-Connecting-IP"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["CF-Connecting-IP"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingXFORWARDEDFORHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["X_FORWARDED_FOR"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["X_FORWARDED_FOR"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXFORWARDEDFORHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["X_FORWARDED_FOR"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["X_FORWARDED_FOR"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingHTTPXREALIPHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_REAL_IP"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["HTTP_X_REAL_IP"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingHTTPXREALIPHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_REAL_IP"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["HTTP_X_REAL_IP"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingHTTPREMOTEADDRHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_REMOTE_ADDR"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["HTTP_REMOTE_ADDR"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingHTTPREMOTEADDRHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_REMOTE_ADDR"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["HTTP_REMOTE_ADDR"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingXClientIpHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-client-ip"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["x-client-ip"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXClientIpHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-client-ip"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["x-client-ip"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingXRealIpHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-real-ip"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["x-real-ip"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXRealIpHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-real-ip"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["x-real-ip"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingForwardedForHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["forwarded-for"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["forwarded-for"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingForwardedForHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["forwarded-for"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["forwarded-for"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingXClusterClientIpHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-cluster-client-ip"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["x-cluster-client-ip"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXClusterClientIpHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-cluster-client-ip"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["x-cluster-client-ip"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingXForwardedHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-forwarded"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["x-forwarded"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingXForwardedHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["x-forwarded"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["x-forwarded"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingForwardedHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["forwarded"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["forwarded"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingForwardedHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["forwarded"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["forwarded"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingViaHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["via"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["via"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingViaHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["via"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["via"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testIpExtractionUsingHTTPXCLIENTIPHeaderIpv6()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_CLIENT_IP"] = "f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["HTTP_X_CLIENT_IP"]);
        $this->assertEquals("f71f:5bf9:25ff:1883:a8c4:eeff:7b80:aa2d", $client_ip);
    }

    public function testIpExtractionUsingHTTPXCLIENTIPHeaderMultipleIpv4()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_CLIENT_IP"] = "141.246.115.116, 203.0.113.1, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["HTTP_X_CLIENT_IP"]);
        $this->assertEquals("141.246.115.116", $client_ip);
    }

    public function testExtractionPriorityWithXForwardedFor()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_FORWARDED_FOR"] = "203.0.113.1";
        $_SERVER["HTTP_X_REAL_IP"] = "198.51.100.101";
        $_SERVER["HTTP_X_CLIENT_IP"] = "198.51.100.102";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["HTTP_X_FORWARDED_FOR"]);
        unset($_SERVER["HTTP_X_REAL_IP"]);
        unset($_SERVER["HTTP_X_CLIENT_IP"]);
        $this->assertEquals("203.0.113.1", $client_ip);
    }

    public function testExtractionPriorityWithoutXForwardedFor()
    {
        $options = new SecureNativeOptions();
        $_SERVER["HTTP_X_REAL_IP"] = "198.51.100.101";
        $_SERVER["HTTP_X_CLIENT_IP"] = "203.0.113.1, 141.246.115.116, 12.34.56.3";

        $client_ip = Utils::clientIpFromRequest($options);
        unset($_SERVER["HTTP_X_REAL_IP"]);
        unset($_SERVER["HTTP_X_CLIENT_IP"]);
        $this->assertEquals("203.0.113.1", $client_ip);
    }

    public function testStripingPiiDataFromHeaders()
    {
        $_SERVER["HTTP_HOST"] = "net.example.com";
        $_SERVER["HTTP_USER_AGENT"] = "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5 (.NET CLR 3.5.30729)";
        $_SERVER["HTTP_ACCEPT"] = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $_SERVER["HTTP_ACCEPT_LANGUAGE"] = "en-us,en;q=0.5";
        $_SERVER["HTTP_ACCEPT_LANGUAGE"] = "gzip,deflate";
        $_SERVER["HTTP_ACCEPT_CHARSET"] = "ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $_SERVER["HTTP_KEEP_ALIVE"] = "300";
        $_SERVER["HTTP_CONNECTION"] = "keep-alive";
        $_SERVER["HTTP_COOKIE"] = "PHPSESSID=r2t5uvjq435r4q7ib3vtdjq120";
        $_SERVER["HTTP_PRAGMA"] = "no-cache";
        $_SERVER["HTTP_CACHE_CONTROL"] = "no-cache";
        $_SERVER["HTTP_AUTHORIZATION"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_ACCESS_TOKEN"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_APIKEY"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_PASSWORD"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_PASSWD"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_SECRET"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_API_KEY"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";

        $headers = Utils::headersFromRequest(null);

        unset($_SERVER["HTTP_HOST"]);
        unset($_SERVER["HTTP_USER_AGENT"]);
        unset($_SERVER["HTTP_ACCEPT"]);
        unset($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        unset($_SERVER["HTTP_ACCEPT_ENCODING"]);
        unset($_SERVER["HTTP_ACCEPT_CHARSET"]);
        unset($_SERVER["HTTP_KEEP_ALIVE"]);
        unset($_SERVER["HTTP_CONNECTION"]);
        unset($_SERVER["HTTP_COOKIE"]);
        unset($_SERVER["HTTP_PRAGMA"]);
        unset($_SERVER["HTTP_CACHE_CONTROL"]);
        unset($_SERVER["HTTP_AUTHORIZATION"]);
        unset($_SERVER["HTTP_ACCESS_TOKEN"]);
        unset($_SERVER["HTTP_APIKEY"]);
        unset($_SERVER["HTTP_PASSWORD"]);
        unset($_SERVER["HTTP_PASSWD"]);
        unset($_SERVER["HTTP_SECRET"]);
        unset($_SERVER["HTTP_API_KEY"]);

        $this->assertFalse(in_array("HTTP_AUTHORIZATION", $headers));
        $this->assertFalse(in_array("HTTP_ACCESS_TOKEN", $headers));
        $this->assertFalse(in_array("HTTP_APIKEY", $headers));
        $this->assertFalse(in_array("HTTP_PASSWORD", $headers));
        $this->assertFalse(in_array("HTTP_PASSWD", $headers));
        $this->assertFalse(in_array("HTTP_SECRET", $headers));
        $this->assertFalse(in_array("HTTP_API_KEY", $headers));
    }

    public function testStripingPiiDataFromRegexPattern()
    {
        $_SERVER["HTTP_HOST"] = "net.example.com";
        $_SERVER["HTTP_USER_AGENT"] = "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5 (.NET CLR 3.5.30729)";
        $_SERVER["HTTP_ACCEPT"] = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $_SERVER["HTTP_ACCEPT_LANGUAGE"] = "en-us,en;q=0.5";
        $_SERVER["HTTP_ACCEPT_LANGUAGE"] = "gzip,deflate";
        $_SERVER["HTTP_ACCEPT_CHARSET"] = "ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $_SERVER["HTTP_KEEP_ALIVE"] = "300";
        $_SERVER["HTTP_CONNECTION"] = "keep-alive";
        $_SERVER["HTTP_COOKIE"] = "PHPSESSID=r2t5uvjq435r4q7ib3vtdjq120";
        $_SERVER["HTTP_PRAGMA"] = "no-cache";
        $_SERVER["HTTP_CACHE_CONTROL"] = "no-cache";
        $_SERVER["HTTP_AUTH_AUTHORIZATION"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_AUTH_ACCESS_TOKEN"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_AUTH_APIKEY"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_AUTH_PASSWORD"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_AUTH_PASSWD"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_AUTH_SECRET"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_AUTH_API_KEY"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";

        $options = new SecureNativeOptions();
        $options->setPiiRegexPattern("/HTTP_AUTH_/i");
        $headers = Utils::headersFromRequest($options);

        unset($_SERVER["HTTP_HOST"]);
        unset($_SERVER["HTTP_USER_AGENT"]);
        unset($_SERVER["HTTP_ACCEPT"]);
        unset($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        unset($_SERVER["HTTP_ACCEPT_ENCODING"]);
        unset($_SERVER["HTTP_ACCEPT_CHARSET"]);
        unset($_SERVER["HTTP_KEEP_ALIVE"]);
        unset($_SERVER["HTTP_CONNECTION"]);
        unset($_SERVER["HTTP_COOKIE"]);
        unset($_SERVER["HTTP_PRAGMA"]);
        unset($_SERVER["HTTP_CACHE_CONTROL"]);
        unset($_SERVER["HTTP_AUTHORIZATION"]);
        unset($_SERVER["HTTP_ACCESS_TOKEN"]);
        unset($_SERVER["HTTP_APIKEY"]);
        unset($_SERVER["HTTP_PASSWORD"]);
        unset($_SERVER["HTTP_PASSWD"]);
        unset($_SERVER["HTTP_SECRET"]);
        unset($_SERVER["HTTP_API_KEY"]);

        $this->assertFalse(in_array("HTTP_AUTHORIZATION", $headers));
        $this->assertFalse(in_array("HTTP_ACCESS_TOKEN", $headers));
        $this->assertFalse(in_array("HTTP_APIKEY", $headers));
        $this->assertFalse(in_array("HTTP_PASSWORD", $headers));
        $this->assertFalse(in_array("HTTP_PASSWD", $headers));
        $this->assertFalse(in_array("HTTP_SECRET", $headers));
        $this->assertFalse(in_array("HTTP_API_KEY", $headers));
    }

    public function testStripingPiiDataFromCustomHeaders()
    {
        $_SERVER["HTTP_HOST"] = "net.example.com";
        $_SERVER["HTTP_USER_AGENT"] = "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.5) Gecko/20091102 Firefox/3.5.5 (.NET CLR 3.5.30729)";
        $_SERVER["HTTP_ACCEPT"] = "text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
        $_SERVER["HTTP_ACCEPT_LANGUAGE"] = "en-us,en;q=0.5";
        $_SERVER["HTTP_ACCEPT_LANGUAGE"] = "gzip,deflate";
        $_SERVER["HTTP_ACCEPT_CHARSET"] = "ISO-8859-1,utf-8;q=0.7,*;q=0.7";
        $_SERVER["HTTP_KEEP_ALIVE"] = "300";
        $_SERVER["HTTP_CONNECTION"] = "keep-alive";
        $_SERVER["HTTP_COOKIE"] = "PHPSESSID=r2t5uvjq435r4q7ib3vtdjq120";
        $_SERVER["HTTP_PRAGMA"] = "no-cache";
        $_SERVER["HTTP_CACHE_CONTROL"] = "no-cache";
        $_SERVER["HTTP_AUTHORIZATION"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_ACCESS_TOKEN"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_APIKEY"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_PASSWORD"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_PASSWD"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_SECRET"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";
        $_SERVER["HTTP_API_KEY"] = "ylSkZIjbdWybfs4fUQe9BqP0LH5Z";

        $headers = ["HTTP_AUTHORIZATION", "HTTP_ACCESS_TOKEN", "HTTP_APIKEY", "HTTP_PASSWORD", "HTTP_PASSWD", "HTTP_SECRET", "HTTP_API_KEY"];
        $options = new SecureNativeOptions();
        $options->setPiiHeaders($headers);
        $headers = Utils::headersFromRequest($options);

        unset($_SERVER["HTTP_HOST"]);
        unset($_SERVER["HTTP_USER_AGENT"]);
        unset($_SERVER["HTTP_ACCEPT"]);
        unset($_SERVER["HTTP_ACCEPT_LANGUAGE"]);
        unset($_SERVER["HTTP_ACCEPT_ENCODING"]);
        unset($_SERVER["HTTP_ACCEPT_CHARSET"]);
        unset($_SERVER["HTTP_KEEP_ALIVE"]);
        unset($_SERVER["HTTP_CONNECTION"]);
        unset($_SERVER["HTTP_COOKIE"]);
        unset($_SERVER["HTTP_PRAGMA"]);
        unset($_SERVER["HTTP_CACHE_CONTROL"]);
        unset($_SERVER["HTTP_AUTHORIZATION"]);
        unset($_SERVER["HTTP_ACCESS_TOKEN"]);
        unset($_SERVER["HTTP_APIKEY"]);
        unset($_SERVER["HTTP_PASSWORD"]);
        unset($_SERVER["HTTP_PASSWD"]);
        unset($_SERVER["HTTP_SECRET"]);
        unset($_SERVER["HTTP_API_KEY"]);

        $this->assertFalse(in_array("HTTP_AUTHORIZATION", $headers));
        $this->assertFalse(in_array("HTTP_ACCESS_TOKEN", $headers));
        $this->assertFalse(in_array("HTTP_APIKEY", $headers));
        $this->assertFalse(in_array("HTTP_PASSWORD", $headers));
        $this->assertFalse(in_array("HTTP_PASSWD", $headers));
        $this->assertFalse(in_array("HTTP_SECRET", $headers));
        $this->assertFalse(in_array("HTTP_API_KEY", $headers));
    }
}