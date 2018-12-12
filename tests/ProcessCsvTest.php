<?php

use PHPUnit\Framework\TestCase;
require_once './tests/test-database.php';

class ProcessCsvTest extends TestCase
{

  private $test;

  protected function setUp() {
    $this->test = new TestDatabase();
    $this->options['u'] = T_USER_NAME;
    $this->options['p'] = T_PASSWORD;
    $this->options['h'] = T_HOST;
    $this->options['t'] = T_PORT;
    $this->options['d'] = T_DATABASE;
  }

  protected function tearDown() {
    if(!mysqli_query($this->test->get_mysqli(), "DROP TABLE IF EXISTS users")) {
      die ('Could not delete existing test users table. Error: ' . mysqli_error($this->test->get_mysqli()) . "\n\n");
    }
    $this->test->get_mysqli()->close();
  }

  public function testWithInvalidFileName() {
    $this->expectException(RuntimeException::class);
    $this->options['file'] = 'wrong.csv';
    $this->options['dry_run'] = false;
    $csv = new ProcessCsv($this->options);
  }

  public function testDryRun() {
    $this->options['file'] = './tests/user_test_valid_emails.csv';
    $this->options['dry_run'] = false;
    $csv = new ProcessCsv($this->options);
    $csv->process();
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $this->assertEquals(false, $result);
    unset($this->options['dry_tun']);
  }

  public function testCreateTableWithValidEmails() {
    $this->options['file'] = './tests/user_test_valid_emails.csv';
    $csv = new ProcessCsv($this->options);
    $csv->process();
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $this->assertEquals(2, mysqli_num_rows($result));
  }

  public function testCreateTableWithInvalidEmails() {
    $this->options['file'] = './tests/user_test_invalid_emails.csv';
    $csv = new ProcessCsv($this->options);
    $csv->process();
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $this->assertEquals(2, mysqli_num_rows($result));
  }
}

