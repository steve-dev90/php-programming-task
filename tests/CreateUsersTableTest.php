<?php

use PHPUnit\Framework\TestCase;
require_once './create-users-table.php';
require_once './database-config.php';
require_once './tests/test-database.php';

class CreateUsersTableTest extends TestCase
{

  private $test;

  protected function setUp() {
    $this->test = new TestDatabase();
  }

  protected function tearDown() {
    if(!mysqli_query($this->test->get_mysqli(), "DROP TABLE IF EXISTS users")) {
      die ('Could not delete existing test users table. Error: ' . mysqli_error($this->test->get_mysqli()) . "\n\n");
    }
    $this->test->get_mysqli()->close();
  }

  public function testInsertUsers() {
    $this->test->get_db()->insert_user('Bob', 'Town', 'bob@bobtown.com');
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $row = mysqli_fetch_array($result);
    $this->assertEquals('bob@bobtown.com', $row['email']);
  }

  public function testInsertUsersUniqueEmail() {
    $this->test->get_db()->insert_user('Bob', 'Town', 'bob@bobtown.com');
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $this->assertEquals(1, mysqli_num_rows($result));
  }
}