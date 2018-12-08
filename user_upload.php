#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php
// require './user_database.php';

$shortopts = "";
$longopts  = array(
  "help",
  "file::",
  "dry_run",
  "create_table"
);
$options = getopt($shortopts, $longopts);
// var_dump($options);
// echo "hello \n", $argv[2], $options["file"], "\n";

for ($i = 1; $i < $argc; $i++) {
  switch ($argv[$i]) {
  case '--help';
    directives_list();
    break;
  case '--dry_run';
    read_csv();
    break;
  case '--create_table';
    create_table();
    break;
  }
}

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
