#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php
// require './user_database.php';
require_once './command_line.php';

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
$input_options->process_commands();


function directives_list() {
 echo "
  --file [csv file name] – this is the name of the CSV to be parsed\n
  --create_table – this will cause the MySQL users table to be built (and no further
  action will be taken)\n
  --dry_run – this will be used with the --file directive in the instance
  that we want to run the script but not insert into the DB. All other functions
  will be executed, but the database won't be altered\n
  -u – MySQL username\n
  -p – MySQL password\n
  -h – MySQL host\n
  --help – which will output the above list of directives with details\n";
}

?>
