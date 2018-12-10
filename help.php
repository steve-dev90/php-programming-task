<?php

class Help
{
  public function directives_list() {
  echo "
    ** List of directives **
    --file='csv file name' ; this is the name of the CSV to be parsed, required \n
    --create_table ; this will cause the MySQL users table to be built (and no further
    action will be taken), optional\n
    --dry_run ; this will be used with the --file directive in the instance
    that we want to run the script but not insert into the DB. All other functions
    will be executed, but the database won't be altered, optional\n
    -u='MySQL username' ; required if create_table specified\n
    -p='MySQL password' ; required if create_table specified\n
    -h='MySQL host' ; required if create_table specified\n
    -t='MySQL port' ; optional, default = '8889' \n
    -d='MySQL database' ; optional, default = 'progtask'\n
    --help ; which will output the above list of directives with details\n";
  }
}