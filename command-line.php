#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

require_once './process-csv.php';
require_once './database-config.php';
require_once './help.php';
require_once './cli-errors.php';

class CommandLine
{
  public function __construct($options) {
    $this->options = $options;
  }

  public function process_commands() {
    $this->check_for_help();
    $cli_errors = new CliErrors($this->options);
    $cli_errors->check_for_errors();
    $this->process_csv($this->config_database());
  }

  private function check_for_help() {
    if (array_key_exists('help', $this->options)) {
      $help = new Help;
      $help->directives_list();
      exit();
    }
  }

  private function config_database() {
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
    return $db_config;
  }

  private function process_csv($db_config) {
    $csv = new ProcessCsv(
      $this->options['file'],
      array_key_exists("dry_run", $this->options),
      $db_config
    );
    $csv->process();
  }
}

