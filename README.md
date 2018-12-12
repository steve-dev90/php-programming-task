## Catalyst programming task

# Introduction
Command line utility to upload a csv containing users data and to save this data to a database.

# Install instructions
To install the utility:
1. Clone the repo on your machine : `git clone https://github.com/steve-dev90/php-programming-task.git`.
2. Configure the mysql database. The default database name is set to `progtask` and the default database port is set to `8889`. If these defaults are not correct for your environment they can be changed. See user instructions below.
3. Configure the test database. To run the tests a test database with the following configuration must be set up (or change the configuration to suit by editing the constants in test-database.php):
- host: 127.0.0.1
- user name: root
- password: root
- database name: progtasktest
- port : 8889
4. Run composer to set up phpunit for testing : `composer install`. This assumes composer is on the $PATH of your machine. The utility itself does not rely on any dependencies installed via composer.
5. To run the test suite : `phpunit test/[testname]`.

# User instructions
To run the utility : `./vendor/bin/phpunit tests/`.

Options:

--file='csv file name' ; this is the name of the CSV to be parsed. Required if either --create_table or --dry_run are used.
--create_table ; this will cause the MySQL users table to be built (and no further action will be taken). Optional.
--dry_run ; this will be used with --file where we want to run the script but not insert the csv records into the database. All other functions will be executed. Optional.
-u='MySQL username' ; required if create_table used.\n
-p='MySQL password' ; required if create_table used.\n
-h='MySQL host' ; required if create_table used.\n
-t='MySQL port' ; optional, default = '8889'. \n
-d='MySQL database' ; optional, default = 'progtask'.\n
--help ; which will output the above list of directives with details. No further action will be taken

# Examples

`php user_upload.php --help`
-> Will list utility directives. No other action taken even if other options provided.

`php user_upload.php --file='users.csv' --dry_run`
-> Will parse the csv and validate the csv records. No records will be inserted into the database.

`php user_upload.php --file='users.csv' --create-table -u='root' -p='root' -h='127.0.0.1`
-> Will parse the csv, validate the csv records and save them to the database.



