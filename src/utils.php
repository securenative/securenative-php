<?php

abstract class Utils
{
  const ALGORITHM = "AES-256-CBC";
  const BLOCK_SIZE = 16;
  const AES_KEY_SIZE = 32;

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

  public static function securHeaderFromRequest()
  {
    if (array_key_exists('x-securenative', $_SERVER)) {
      return $_SERVER['x-securenative'];
    }
    return '';
  }  

  public static function cookieIdFromRequest()
  {
    if(isset($_COOKIE) && array_key_exists('_sn', $_COOKIE)){
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


  public static function decrypt($cipherText, $cipherKey)
  {
    $key = mb_convert_encoding(substr($cipherKey, 0, 32), "utf-8");
    $contents = hex2bin(cipherText);

    $iv = substr($contents, 0, BLOCK_SIZE);
    $textBytes = substr($contents, BLOCK_SIZE);

    if ( $decrypted = openssl_decrypt(mb_convert_encoding($textBytes, "utf-8"), $ALGORITHM, $key, 0, $iv ))
    {
      return $decrypted;
    }
    else
    {
      return false;
    }
  }
}
