<?php

namespace SecureNative\sdk;

const SIGNATURE_KEY = 'HTTP_X_SECURENATIVE';

class Middleware
{
    private $apiKey;

    public function __construct($apiKey)
    {
        $this->apiKey = $apiKey;
    }

    public function verifySignature()
    {
        $headers = $_SERVER;
        $body = file_get_contents("php://input");
        $signature = isset($headers[SIGNATURE_KEY]) ? $headers[SIGNATURE_KEY] : "";
        $comparison_signature = bin2hex(hash_hmac('sha512', $body, $this->apiKey, true));
        return hash_equals($signature, $comparison_signature);
    }
}
