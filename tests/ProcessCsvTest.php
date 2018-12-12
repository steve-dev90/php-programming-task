<?php

use PHPUnit\Framework\TestCase;
require_once './process-csv.php';

class ProcessCsvTest extends TestCase
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

  public function testWithInvalidFileName() {
    $this->expectException(RuntimeException::class);
    $csv = new ProcessCsv('wrong.csv', false, '');
  }

  public function testDryRun() {
    $csv = new ProcessCsv('./tests/user_test_valid_emails.csv', true, '');
    $csv->process();
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $this->assertEquals(0, mysqli_num_rows($result));
  }

  public function testCreateTableWithValidEmails() {
    $csv = new ProcessCsv('./tests/user_test_valid_emails.csv', false, $this->test->get_db_config());
    $csv->process();
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $this->assertEquals(2, mysqli_num_rows($result));
  }

  public function testCreateTableWithInvalidEmails() {
    $csv = new ProcessCsv('./tests/user_test_invalid_emails.csv', false, $this->test->get_db_config());
    $csv->process();
    $result = mysqli_query($this->test->get_mysqli(), 'SELECT * FROM users');
    $this->assertEquals(2, mysqli_num_rows($result));
  }
}

