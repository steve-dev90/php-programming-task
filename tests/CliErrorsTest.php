<?php

use PHPUnit\Framework\TestCase;
require_once './cli-errors.php';

class CliErrorsTest extends TestCase
{
  public function testExceptionNoFileOption() {
    $this->expectException(BadMethodCallException::class);
    $options = [];
    $err = new CliErrors($options);
    $err->check_for_errors();
  }

  public function testExceptionMultipleFiles() {
    $this->expectException(InvalidArgumentException::class);
    $options['file'] = array('file1.csv', 'file2.csv');
    $err = new CliErrors($options);
    $err->check_for_errors();
  }

  public function testExceptionDryRunAndCreateTable() {
    $this->expectException(InvalidArgumentException::class);
    $options['file'] = 'file1.csv';
    $options['dry_run'] = false;
    $options['create_table'] = false;
    $err = new CliErrors($options);
    $err->check_for_errors();
  }

  public function testExceptionNoDryRunAndCreateTable() {
    $this->expectException(InvalidArgumentException::class);
    $options['file'] = 'file1.csv';
    var_dump($options['file']);
    $err = new CliErrors($options);
    $err->check_for_errors();
  }

  public function testExceptionNoDbConfig() {
    $this->expectException(InvalidArgumentException::class);
    $options['file'] = 'file1.csv';
    $options['create_table'] = false;
    $err = new CliErrors($options);
    $err->check_for_errors();
  }

  public function testExceptionMultipleDbConfig() {
    $this->expectException(InvalidArgumentException::class);
    $options['file'] = 'file1.csv';
    $options['create_table'] = false;
    $options['u'] = array('root', 'root');
    $options['p'] = 'root';
    $options['h'] = '127';
    $options['t'] = '8';
    $options['d'] = 'd';
    $err = new CliErrors($options);
    $err->check_for_errors();
  }

  public function testCorrectCreateTable() {
    $options['file'] = 'file1.csv';
    $options['create_table'] = false;
    $options['u'] = 'root';
    $options['p'] = 'root';
    $options['h'] = '127';
    $options['t'] = '8';
    $options['d'] = 'd';
    $err = new CliErrors($options);
    $this->assertEquals(true, $err->check_for_errors());
  }

  public function testCorrectDryRun() {
    $options['file'] = 'file1.csv';
    $options['dry_run'] = false;
    $err = new CliErrors($options);
    $this->assertEquals(true, $err->check_for_errors());
  }
}