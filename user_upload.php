<?php
error_reporting(E_ALL);
ini_set('display_errors', 'On');
ini_set('display_start_up_errors', 'On');

require_once './command-line.php';

$short_options = "u:p:h:t::d::";
$long_options  = array(
  "help",
  "file:",
  "dry_run",
  "create_table"
);

$options = getopt($short_options, $long_options);

$input_options = new CommandLine ($options);

try {
  $input_options->process_commands();
} catch (Exception $ex) {
  echo $ex->getMessage();
}
