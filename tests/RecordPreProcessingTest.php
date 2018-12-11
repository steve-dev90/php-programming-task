<?php

use PHPUnit\Framework\TestCase;
require './record-pre-processing.php';

class RecordPreProcessingTest extends TestCase {

  protected function setUp()
  {
    $this->expected = array (
      'first_name' => 'Bob',
      'surname' => 'Town',
      'email' => 'bob@bobtown.com'
    );
  }

  public function testReturnsWithValidEmail()
  {
    $pre_process = new RecordPreProcessing(['Bob', 'Town', 'bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->assertEquals($this->expected, $actual);
  }

  public function testReturnsFalseWithInvalidEmail()
  {
    $pre_process = new RecordPreProcessing(['Bob', 'Town', 'bob@bob@town.com']);
    $actual = $pre_process->pre_process();
    $expected = false;
    $this->assertEquals($expected, $actual);
  }

  public function testReturnsCapitalisedFirstName()
  {
    $pre_process = new RecordPreProcessing(['bob', 'Town', 'bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->assertEquals($this->expected, $actual);
  }

  public function testReturnsCapitalisedSurname()
  {
    $pre_process = new RecordPreProcessing(['Bob', 'tOWN', 'bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->assertEquals($this->expected, $actual);
  }

  public function testReturnsWithEmailTrailingWhiteSpace()
  {
    $pre_process = new RecordPreProcessing(['Bob', 'tOWN', '   bob@bobtown.com']);
    $actual = $pre_process->pre_process();
    $this->assertEquals($this->expected, $actual);
  }

}
