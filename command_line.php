#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php
require_once './process_csv.php';
require_once './database_config.php';

class CommandLine
{

  public function __construct($options) {
    $this->options = $options;
  }

  public function process_commands() {
    $this->check_for_errors();

    if (array_key_exists('t', $this->options)) {
      $port = $this->options['t'];
    } else {
      $port = null;
    }
    if (array_key_exists('d', $this->options)) {
      $database = $this->options['d'];
    } else {
      $database = null;
    }
    $db_config = new DatabaseConfig (
      $this->options['u'],
      $this->options['p'],
      $this->options['h'],
      $port,
      $database
    );

    $csv = new ProcessCsv(
      $this->options['file'],
      array_key_exists("dry_run", $this->options),
      $db_config
    );
    $csv->process();
  }

  public function check_for_errors() {
    //multiple options specified -u='h' -u='g'
    $errors = array();

    if (!array_key_exists("file", $this->options)) {
      $errors[] = ("Please specify the file option, use format --file='myfile.csv'\n");
    }

    if ($this->two_many_long_options()) {
      $errors[] = ("Please specify either the --dry_run option or --create_table option, not both\n");
    }

    if ($this->two_few_long_options()) {
      $errors[] = ("Please specify either the --dry_run option or --create_table option, neither have been provided\n");
    }

    if (array_key_exists("create_table", $this->options)) {
      if (!$this->all_database_config_options_present()) {
        $errors[] = ("Please make sure you have specified u, p and h database configuration options, at least one is missing\n");
      }
    }

    foreach ($errors as $error) {
      echo $error;
      exit();
    }
  }

  private function two_many_long_options() {
    return array_key_exists("dry_run", $this->options) &&
           array_key_exists("create_table", $this->options);
  }

  private function two_few_long_options() {
    return !array_key_exists("dry_run", $this->options) &&
           !array_key_exists("create_table", $this->options);
  }

  private function all_database_config_options_present() {
    return array_key_exists("u", $this->options) &&
           array_key_exists("p", $this->options) &&
           array_key_exists("h", $this->options);
  }

}

