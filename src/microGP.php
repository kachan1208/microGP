<?php

namespace microGP;

/**
 * Micro wrapper for curl lib, can make GET/POST requests
 * 
 * @author kachan1208@gmail.com 
 */
class microGP {
  /**
   * Basic GET headers
   */
  protected static $get_headers = [
    "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36"
  ]; 

  /**
   * Basic POST headers
   */
  protected static $post_headers = [
    "User-Agent" => "Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/51.0.2704.84 Safari/537.36"
  ]; 

  /**
   * Basic curl options:
   *  - Follow location = true 
   *  - Return headers  = true
   *  - Return response = true
   *  - Connection timeout = 60 sec
   *  - Curl exec timeout  = 61 sec
   */
  protected static $curl_options = [
    "CURLOPT_FOLLOWLOCATION"   => true
    , "CURLINFO_HEADER_OUT"    => true
    , "CURLOPT_RETURNTRANSFER" => true
    , "CURLOPT_CONNECTTIMEOUT" => 60
    , "CURLOPT_TIMEOUT"        => 61
  ];

  protected static $post_options = [
    "CURLOPT_POST"         => true
    , "CURLOPT_POSTFIELDS" => ""
  ];
  
  /**
   * Curl object
   */
  protected static $curl = NULL;

  /**
   * Request method GET
   * 
   * @param $url     string Host url
   * @param $headers array  Additional headers
   * @param $params  array  Additional curl params
   * @return         object Response object: response, response headers, request headers
   */
  public static function get($url, $headers = [], $params = []) {
    if(!$url || $url == '') {
      return false;
    }

    //Init headers and curl options
    $headers = array_merge(self::$get_headers, $headers);
    $params  = array_merge(self::$curl_options, $params);

    self::request_send($url, $headers, $params);
  }

  /**
   * Request method POST
   *
   * @param $url     string Host url
   * @param $data    array  POST data
   * @param $headers array  Additional headers
   * @param $params  array  Additional curl params
   * @return         object Response object: response, response headers, request headers
   */
  public static function post($url, $data = null, $headers = [], $params = []) {
    if(!$url || $url == '') {
      return false;
    }

    $headers = array_merge(self::$get_headers, $headers);
    $headers = array_merge(self::$curl_options, self::$post_options, $params);

    self::request_send($url, $headers, $params);
  }

  /**
   * Basic request method, sends GET/POST requests
   * @param $url     string Host url
   * @param $headers array  Additional headers
   * @param $params  array  Additional curl params
   * @param $headers array  HTTP Headers
   * @return         object Response object: response, response headers, request headers
   */
  protected static function request_send($url, $headers, $params) {
     
  }
}