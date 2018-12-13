<?php

require_once './process-csv.php';
require_once './help.php';
require_once './cli-errors.php';

// This class interogates and processes the command line instruction.

class CommandLine
{
  private $options;

  public function __construct($options) {
    $this->options = $options;
    if (!array_key_exists('d', $this->options)) {
      $this->options['d'] = 'progtask';
    }
    if (!array_key_exists('t', $this->options)) {
      $this->options['t'] = '8889';
    }
  }

  public function process_commands() {
    $this->check_for_help();
    $cli_errors = new CliErrors($this->options);
    $cli_errors->check_for_errors();
    $csv = new ProcessCsv($this->options);
    $csv->process();
  }

  // If --help is specified, directives will be listed and no other action will be taken
  private function check_for_help() {
    if (array_key_exists('help', $this->options)) {
      $help = new Help;
      $help->directives_list();
      exit();
    }
  }
}
