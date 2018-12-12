<?php

//Cleans data in csv and validates email address

class RecordPreProcessing
{
  private $first_name;
  private $surname;
  private $email;

  public function __construct($record) {
    $this->first_name = $record[0];
    $this->surname = $record[1];
    $this->email = trim($record[2]);
  }

  public function pre_process() {
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      echo 'Invalid email: ' . $this->email . ' provided for ' . $this->first_name . ' ' . $this->surname . "\n\n";
      return false;
    } else {
      return array (
        'first_name' => $this->clean_name($this->first_name),
        'surname' => $this->clean_name($this->surname),
        'email' => $this->clean_email($this->email)
      );
    }
  }

  // Characters that are not letters e.g. ! are accepted as valid.
  private function clean_name($unclean_name) {
    $unclean_name = trim($unclean_name);
    $prefixes = array("O'", "o'", 'Mc', 'mc', 'Mac', 'mac');
    foreach ($prefixes as $prefix) {
      $pos = strpos($unclean_name, $prefix);
      $celtic_prefix = '';
      if ($pos === 0) {
        $unclean_name = substr($unclean_name, strlen($prefix));
        $celtic_prefix = ucfirst($prefix);
        break;
      }
    }
    return $celtic_prefix . ucfirst(strtolower($unclean_name));
  }

  private function clean_email($unclean_email) {
    return strtolower($unclean_email);
  }
}
