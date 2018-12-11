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
      echo 'Invalid email: ' . $this->email . ' provided for ' . $this->first_name . ' ' . $this->surname . "\n";
      return false;
    } else {
      return array (
        'first_name' => $this->clean_name($this->first_name),
        'surname' => $this->clean_name($this->surname),
        'email' => $this->clean_email($this->email)
      );
    }
  }

  private function clean_name($unclean_name) {
    //O', McKee, MacKay, Sam!!!
    return ucfirst(strtolower(trim($unclean_name)));
  }

  private function clean_email($unclean_email) {
    return strtolower($unclean_email);
  }
}
