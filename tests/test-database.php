<?php

class TestDatabase
{
  public $db;
  public $mysqli;

  const USER_NAME = 'root';
  const PASSWORD = 'root';
  const HOST = '127.0.0.1';
  const PORT = '8889';
  const DATABASE = 'progtasktest';

  public function __construct() {
    try {
      $this->db = new CreateUsersTable (
        self::USER_NAME,
        self::PASSWORD,
        self::HOST,
        self::PORT,
        self::DATABASE
      );
      $this->db->create_users_table();
      $this->mysqli = new mysqli(
        self::HOST,
        self::USER_NAME,
        self::PASSWORD,
        self::DATABASE,
        self::PORT
      );
    } catch (Exception $ex) {
      die ("Set up of test database failed : " . $ex->getMessage() . "\n\n");
    }
  }

  public function get_db() {
    return $this->db;
  }

  public function get_mysqli() {
    return $this->mysqli;
  }
}