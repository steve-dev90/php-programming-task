#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

class RecordPreProcessing
{

  private $first_name;

  public function __construct($record) {
    $this->first_name = $this->capitalise(trim($record[0]));
    $this->surname = $this->capitalise(trim($record[1]));
    $this->email = strtolower(trim($record[2]));
  }

  public function preProcess() {
    if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
      echo 'Invalid email: ' . $this->email . ' provided for ' . $this->first_name . '' . $this->surname . "\n";
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