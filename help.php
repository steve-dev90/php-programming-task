<?php

class Help
{
  public function directives_list() {
  echo "
    ** List of directives **
    --file='csv file name' ; this is the name of the CSV to be parsed. Required \n
    --create_table ; this will cause the MySQL users table to be built (and no further
    action will be taken). Optional\n
    --dry_run ; this will be used with --file where we want to run the script but
    not insert the csv records into the database. All other functions will be executed.
    Optional\n
    -u='MySQL username' ; required if create_table used\n
    -p='MySQL password' ; required if create_table used\n
    -h='MySQL host' ; required if create_table used\n
    -t='MySQL port' ; optional, default = '8889' \n
    -d='MySQL database' ; optional, default = 'progtask'\n
    --help ; which will output the above list of directives with details.
    No further action will be taken\n\n";
  }
}