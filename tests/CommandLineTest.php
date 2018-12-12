<?php

use PHPUnit\Framework\TestCase;
require_once './tests/test-database.php';

class CommandLineTest extends TestCase
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

  public function testUtilityNoOptionalPortConfig() {
    $options['file'] = './tests/user_test_valid_emails.csv';
    $options['create_table'] = false;
    $options['u'] = T_USER_NAME;
    $options['p'] = T_PASSWORD;
    $options['h'] = T_HOST;
    $options['d'] = T_DATABASE;
    $utility = new CommandLine($options);
    $utility->process_commands();
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $this->assertEquals(2, mysqli_num_rows($result));
  }
}