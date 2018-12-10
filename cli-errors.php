<?php

// This class makes sure that the command line instruction has been structured correctly

class CliErrors
{
  public function __construct($options) {
    $this->options = $options;
  }

  public function check_for_errors() {
    $errors = array();

    if (!array_key_exists('file', $this->options)) {
      throw new BadMethodCallException ("Please specify the file option, use format --file='myfile.csv'\n\n");
    }

    if(is_array($this->options['file'])) {
      throw new InvalidArgumentException ("Please specify only one csv file to be processed\n\n");
    }

    if ($this->two_many_long_options()) {
      throw new InvalidArgumentException ("Please specify either the --dry_run option or --create_table option, not both\n\n");
    }

    if ($this->two_few_long_options()) {
      throw new InvalidArgumentException ("Please specify either the --dry_run option or --create_table option, neither have been provided\n\n");
    }

    if (array_key_exists('create_table', $this->options)) {
      if (!$this->all_database_config_options_present()) {
        throw new InvalidArgumentException ("Please make sure you have specified u, p and h database configuration options, at least one is missing\n\n");
      }
      if ($this->all_database_config_options_specified_multiple_times()) {
        throw new InvalidArgumentException ("Please make sure you have specified each database configuration option only once\n\n");
      }
    }
  }

  private function two_many_long_options() {
    return array_key_exists('dry_run', $this->options) &&
           array_key_exists('create_table', $this->options);
  }

  private function two_few_long_options() {
    return !array_key_exists('dry_run', $this->options) &&
           !array_key_exists('create_table', $this->options);
  }

  private function all_database_config_options_present() {
    return array_key_exists('u', $this->options) &&
           array_key_exists('p', $this->options) &&
           array_key_exists('h', $this->options);
  }

  private function all_database_config_options_specified_multiple_times() {
    return is_array($this->options['u']) ||
           is_array($this->options['p']) ||
           is_array($this->options['h']) ||
           is_array($this->options['t']) ||
           is_array($this->options['d']);
  }
}