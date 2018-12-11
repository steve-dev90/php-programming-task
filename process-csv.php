<?php

require_once './record-pre-processing.php';
require_once './create-users-table.php';

class ProcessCsv
{
  private $file;
  private $handle;
  private $dry_run;
  private $db;

  public function __construct($file, $dry_run, $db_config) {
    if(!is_file($file) || !is_readable($file)) {
      throw new RuntimeException ('The csv file could not be opened for reading. File: ' . $file . "\n\n");
    }
    $this->file = $file;
    $this->handle = $this->get_csv_handle();
    $this->dry_run = $dry_run;
    if (!$dry_run) {
      $this->db = new CreateUsersTable($db_config);
      $this->db->create_users_table();
    }
  }

  private function get_csv_handle() {
    $handle = fopen($this->file, 'r');
    if (!$handle) {
      throw new RuntimeException ('Encountered an error while reading CSV file: ' . $this->file . "\n\n");
    }
    echo "CSV processing started ...\n\n";
    return $handle;
  }

  public function process() {
    $header_row = true;
    while (($data = fgetcsv($this->handle, 1000, ',')) !== false) {
      if ($header_row) {
        $header_row = false;
        continue;
      }
      $this->process_row($data);
    }
    echo "CSV processing finished! \n\n";
    fclose($this->handle);
  }

  private function process_row($data) {
    $data_process = new RecordPreProcessing($data);
    $pre_processed_data = $data_process->pre_process();
    if ($pre_processed_data && !$this->dry_run) {
      $this->db->insert_user(
        $pre_processed_data['first_name'],
        $pre_processed_data['surname'],
        $pre_processed_data['email']
      );
    }
  }
}
