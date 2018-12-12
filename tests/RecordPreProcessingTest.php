<?php

use PHPUnit\Framework\TestCase;
require_once './record-pre-processing.php';

class RecordPreProcessingTest extends TestCase
{
  protected function setUp() {
    $this->expected = array (
      'first_name' => 'Bob',
      'surname' => 'Town',
      'email' => 'bob@bobtown.com'
    );
  }

  public function testReturnsWithValidEmail() {
    $pre_process = new RecordPreProcessing(['Bob', 'Town', 'bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->assertEquals($this->expected, $actual);
  }

  public function testReturnsFalseWithInvalidEmail() {
    $pre_process = new RecordPreProcessing(['Bob', 'Town', 'bob@bob@town.com']);
    $actual = $pre_process->pre_process();
    $expected = false;
    $this->assertEquals($expected, $actual);
  }

  public function testReturnsWithLowerCaseFirstName() {
    $pre_process = new RecordPreProcessing(['bob', 'Town', 'bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->assertEquals($this->expected, $actual);
  }

  public function testReturnsWithMixedCaseSurname() {
    $pre_process = new RecordPreProcessing(['Bob', 'tOWN', 'bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->assertEquals($this->expected, $actual);
  }

  public function testReturnsWithEmailWithTrailingWhiteSpace() {
    $pre_process = new RecordPreProcessing(['Bob', 'tOWN', '   bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->assertEquals($this->expected, $actual);
  }

  public function testReturnsWithCelticPrefixO() {
    $pre_process = new RecordPreProcessing(['Bob', "O'Town", '   bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->expected['surname'] = "O'Town";
    $this->assertEquals($this->expected, $actual);
  }

  public function testReturnsWithCelticPrefixOLowercase() {
    $pre_process = new RecordPreProcessing(['Bob', "o'town", '   bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->expected['surname'] = "O'Town";
    $this->assertEquals($this->expected, $actual);
  }

  public function testReturnsWithCelticPrefixMac() {
    $pre_process = new RecordPreProcessing(['Bob', 'MacTown', '   bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->expected['surname'] = 'MacTown';
    $this->assertEquals($this->expected, $actual);
  }
}
