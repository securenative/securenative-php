<?php

namespace SecureNative\sdk;

const ALGORITHM = "AES-256-CBC";
const BLOCK_SIZE = 16;
const AES_KEY_SIZE = 32;

abstract class Utils
{

    public static function clientIpFromRequest()
    {
        if (array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER)) {
            $parts = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return $parts[0];
        }
        if (array_key_exists('HTTP_X_REAL_IP', $_SERVER)) {
            return $_SERVER['HTTP_X_REAL_IP'];
        }
        if (array_key_exists('REMOTE_ADDR', $_SERVER)) {
            return $_SERVER['REMOTE_ADDR'];
        }
        return null;
    }

    public static function userAgentFromRequest()
    {
        if (array_key_exists('HTTP_USER_AGENT', $_SERVER)) {
            return $_SERVER['HTTP_USER_AGENT'];
        }
        return null;
    }


    public static function headersFromRequest()
    {
        $headers = array();
        foreach ($_SERVER as $key => $val) {
            if (substr($key, 0, 5) == 'HTTP_') {
                $name = strtolower(substr($key, 5));
                $name = str_replace("_", "-", $name);
                $headers[$name] = $val;
            }
        }
        return $headers;
    }

    public static function urlFromRequest()
    {
        if (array_key_exists('HTTPS', $_SERVER)) {
            return 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . "{$_SERVER['HTTP_HOST']}/{$_SERVER['REQUEST_URI']}";
        }

        return '';
    }

    public static function methodFromRequest()
    {
        if (array_key_exists('REQUEST_METHOD', $_SERVER)) {
            return $_SERVER['REQUEST_METHOD'];
        }
        return '';
    }

    public static function securHeaderFromRequest()
    {
        if (array_key_exists('HTTP_X_SECURENATIVE', $_SERVER)) {
            return $_SERVER['HTTP_X_SECURENATIVE'];
        }
        return '';
    }

    public static function cookieIdFromRequest()
    {
        if (isset($_COOKIE) && array_key_exists('_sn', $_COOKIE)) {
            return $_COOKIE['_sn'];
        }

        return null;
    }

    public static function generateGuidV4()
    {
        $data = openssl_random_pseudo_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    public static function serialize($obj)
    {
        return json_encode($obj);
    }

    public static function decrypt($cipherText, $cipherKey)
    {
        $key = mb_convert_encoding(substr($cipherKey, 0, AES_KEY_SIZE), "utf-8");
        $contents = hex2bin($cipherText);

        $iv = substr($contents, 0, BLOCK_SIZE);
        $textBytes = substr($contents, BLOCK_SIZE);

        if ($decrypted = openssl_decrypt($textBytes, ALGORITHM, $key, true, $iv)) {
            return $decrypted;
        } else {
            Logger::debug("Decrypt error", openssl_error_string());
            return "";
        }
    }

    public static function encrypt($plainText, $cipherKey) {
        $iv = openssl_random_pseudo_bytes(BLOCK_SIZE);

        if ($encrypted = openssl_encrypt($plainText, ALGORITHM, $cipherKey, true, $iv)) {
            return bin2hex($iv) . bin2hex($encrypted);
        } else {
            Logger::debug("Encrypt error", openssl_error_string());
            return "";
        }

    }
}
