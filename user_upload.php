#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

require_once './command-line.php';

$short_options = "u:p:h:t::d::";
$long_options  = array(
  "help",
  "file:",
  "dry_run",
  "create_table"
);

$options = getopt($short_options, $long_options);
var_dump($options);
$input_options = new CommandLine ($options);

try {
  $input_options->process_commands();
} catch (RuntimeException $ex) {
  //echo $ex . 'HellOOOOO';
  echo $ex->getMessage();
}
