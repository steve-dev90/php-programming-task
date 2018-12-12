<?php

use PHPUnit\Framework\TestCase;
require_once './command-line.php';
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
    $options['u'] = 'root';
    $options['p'] = 'root';
    $options['h'] = '127.0.0.1';
    $options['d'] = 'progtasktest';
    $utility = new CommandLine($options);
    $utility->process_commands();
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $this->assertEquals(2, mysqli_num_rows($result));
  }
}