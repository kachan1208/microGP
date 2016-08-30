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

  /**
   * Additional curl options for POST request
   *  - set curl to use POST request = true
   *  - POST data = ""
   */
  protected static $post_options = [
    "CURLOPT_POST"         => true
    , "CURLOPT_POSTFIELDS" => ""
  ];

  /**
   * Basic request info which returns with request body
   *  - Response code
   *  - Request data size
   *  - Request time
   *  - Request headers 
   */
  protected static $request_info = [
      'code'       => 'CURLINFO_HTTP_CODE'
      , 'filesize' => 'CURLINFO_REQUEST_SIZE'
      , 'time'     => 'CURLINFO_TOTAL_TIME'
      , 'headers'  => 'CURLINFO_HEADER_OUT'
    ];

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

    return self::request_send($url, $headers, $params);
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

    self::$post_options['CURLOPT_POSTFIELDS'] = $data;

    $headers = array_merge(self::$get_headers, $headers);
    $params  = array_merge(self::$curl_options, self::$post_options, $params);
    // print_r($headers);

    return self::request_send($url, $headers, $params);
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
    $curl = curl_init($url);

    //Set curl options
    foreach($params as $param => $value) {
      curl_setopt($curl, constant($param), $value);
    }
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

    $response = curl_exec($curl);
    $info = self::get_info($curl);

    curl_close($curl);
    return ['body' => $response, 'info' => $info, 'code' => $info['code']];
  }

  /**
   * Get curl exec information
   * @param  $curl  object Curl object, after receive response
   * @return        array  Return small info about request/response
   */
  protected static function get_info($curl) {
    $info = [];
    //Collect info
    foreach(self::$request_info as $key => $option) {
      $info[$key] = curl_getinfo($curl, constant($option));
    }

    return $info;
  }
}