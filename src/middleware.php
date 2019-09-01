<?php

const SIGNATURE_KEY = 'x-securenative';

class Middleware
{
  private $apiKey;

  public function __construct($apiKey)
  {
      $this->apiKey = $apiKey;
  }

  public function verifySignature($headers, $body)
  {
     $signature = headers[SIGNATURE_KEY] ? headers[SIGNATURE_KEY] : "";
     $comparison_signature = hash_hmac('sha512', Utils::serialize($body), $this->apiKey, true);
     return hash_equals($signature, $comparison_signature);
  }
}
