#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

require './record_preprocessing.php';
require './create_users_table.php';

class ProcessCsv
{

  public function __construct($file, $dry_run, $db_config) {
    $this->file = $file;
    $this->dry_run = $dry_run;
    if (!$dry_run) {
      $this->db = new CreateUsersTable($db_config);
      $this->db->createUsersTable();
    }
  }

  public function process() {
    if (($handle = fopen("{$this->file}", "r")) !== false) {
      while (($data = fgetcsv($handle, 1000, ",")) !== false) {
        $this->process_row($data);
      }
      fclose($handle);
    }
  }

  private function process_row($data) {
    var_dump($data);
    echo ("\n");
    $obj = new RecordPreProcessing($data);
    $processed_data = $obj->preProcess();
    if ($processed_data && !$this->dry_run) {
      $this->db->insertUser(
        $processed_data['first_name'],
        $processed_data['surname'],
        $processed_data['email']
      );
    }
  }
}



?>