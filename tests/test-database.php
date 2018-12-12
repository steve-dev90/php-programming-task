<?php

const T_USER_NAME = 'root';
const T_PASSWORD = 'root';
const T_HOST = '127.0.0.1';
const T_PORT = '8889';
const T_DATABASE = 'progtasktest';

class TestDatabase
{
  public $mysqli;

  public function __construct() {
    try {
      $this->mysqli = new mysqli(T_HOST, T_USER_NAME, T_PASSWORD, T_DATABASE, T_PORT);
    } catch (Exception $ex) {
      die ("Set up of test database failed : " . $ex->getMessage() . "\n\n");
    }
  }

  public function get_mysqli() {
    return $this->mysqli;
  }
}