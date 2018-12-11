<?php

require './record-pre-processing.php';
require './create-users-table.php';

class ProcessCsv
{
  public function __construct($file, $dry_run, $db_config) {
    if(!is_file($file) || !is_readable($file)) {
      throw new RuntimeException ('The csv file could not be opened for reading. File: ' . $file . "\n\n");
    }
    $this->file = $file;
    $this->handle = $this->get_csv_handle();
    $this->dry_run = $dry_run;
    if (!$dry_run) {
      $this->db = new CreateUsersTable($db_config);
      $this->db->createUsersTable();
    }
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
    fclose($this->handle);
  }

  private function get_csv_handle() {
    $handle = fopen($this->file, 'r');
    if (!$handle) {
      throw new RuntimeException ('Encountered an error while reading CSV file: ' . $this->file . "\n\n");
    }
    return $handle;
  }

  private function process_row($data) {
    var_dump($data);
    $data_process = new RecordPreProcessing($data);
    $pre_processed_data = $data_process->pre_process();
    if ($pre_processed_data && !$this->dry_run) {
      $this->db->insertUser(
        $pre_processed_data['first_name'],
        $pre_processed_data['surname'],
        $pre_processed_data['email']
      );
    }
  }
}
