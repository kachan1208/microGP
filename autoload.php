<?php

function __autoload($classname) {
  require_once(__DIR__ . '/src/' . $classname . '.php');
}