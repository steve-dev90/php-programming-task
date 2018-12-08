#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

require './record_preprocessing.php';

class ProcessCsv {

  public function __construct($file, $dry_run) {
    $this->file = $file;
    $this->dry_run = $dry_run;
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
    if ($processed_data && $this->dry_run) {
      echo "Dada \n";
      var_dump($obj->preProcess());
      echo "\n";
    }
  }
}

$obj = new ProcessCsv('users.csv', true);
$obj->process();

?>