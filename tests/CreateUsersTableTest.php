<?php

use PHPUnit\Framework\TestCase;
require './create-users-table.php';
require './database-config.php';

class CreateUsersTableTest extends TestCase {

  private $db;
  private $db_config;
  private $mysqli;
  const USER_NAME = 'root';
  const PASSWORD = 'root';
  const HOST = '127.0.0.1';
  const PORT = '8889';
  const DATABASE = 'progtasktest';

  protected function setUp() {
    $this->db_config = new DatabaseConfig (
      self::USER_NAME,
      self::PASSWORD,
      self::HOST,
      self::PORT,
      self::DATABASE
    );
    try {
      $this->db = new CreateUsersTable ($this->db_config);
      $this->db->create_users_table();
      $this->mysqli = new mysqli(
        self::HOST,
        self::USER_NAME,
        self::PASSWORD,
        self::DATABASE,
        self::PORT
      );
    } catch (Exception $ex) {
      echo "Set up of test database failed\n";
      echo $ex->getMessage(), "\n\n";
    }
  }

  protected function tearDown() {
    $this->mysqli->close();
  }

  public function testInsertUsers() {
    $this->db->insert_user('Bob', 'Town', 'bob@bobtown.com');
    $result = mysqli_query($this->mysqli, 'SELECT * FROM users');
    $row = mysqli_fetch_array($result);
    $this->assertEquals('bob@bobtown.com', $row['email']);
  }

  public function testInsertUsersUniqueEmail() {
    $this->db->insert_user('Bob', 'Town', 'bob@bobtown.com');
    $result = mysqli_query($this->mysqli, 'SELECT * FROM users');
    $this->assertEquals(1, mysqli_num_rows($result));
  }
}