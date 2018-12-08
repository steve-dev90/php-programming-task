#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

class CommandLine
{

  public function __construct($options) {
    $this->options = $options;
  }

  public function process_commands() {
    $this->check_for_errors();
  }

  public function check_for_errors() {
    if (!array_key_exists("file", $this->options)) {
      $errors[] = ("Please specify the file option, use format --file='myfile.csv'\n");
    }
    if (!$this->options['file']) {
      $errors[] = ("Please specify a file to upload, use format --file='myfile.csv'\n");
    }
    if ($this->two_many_options()) {
      $errors[] = ("Please specify either the --dry_run option or --create_table option, not both\n");
    }
    if ($this->two_few_options()) {
      $errors[] = ("Please specify either the --dry_run option or --create_table option, neither provided\n");
    }
    foreach ($errors as $error) {
      echo $error;
    }


  }

  private function two_many_options() {
    return array_key_exists("dry_run", $this->options) &&
           array_key_exists("create_table", $this->options);
  }

  private function two_few_options() {
    return !array_key_exists("dry_run", $this->options) &&
           !array_key_exists("create_table", $this->options);
  }



}

