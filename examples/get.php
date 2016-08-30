<?php
require_once(__DIR__.'/../autoload.php');

print_r(microGP::get("http://httpbin.org/ip"));