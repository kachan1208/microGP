<?php
require_once(__DIR__.'/../autoload.php');

microGP::post("http://httpbin.org/post", ['a' => '1', 'b' => 2]);