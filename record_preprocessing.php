#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

class RecordPreProcessing {

  private $first_name;

  public function __construct($record) {
    $this->first_name = $this->capitalise($record[0]);
    $this->surname = $this->capitalise($record[1]);
    $this->email = strtolower($record[2]);
  }

  public function preProcess() {
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      echo 'Record email is invalid';
      return false;
    } else {
      return array (
        'first_name' => $this->first_name,
        'surname' => $this->surname,
        'email' => $this->email
      );
    }
  }

  private function capitalise($uncap_name) {
    //O', McKee, MacKay, Sam!!!
    return ucfirst(strtolower($uncap_name));
  }
}

?>