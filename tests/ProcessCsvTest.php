<?php

use PHPUnit\Framework\TestCase;
require_once './process-csv.php';

class ProcessCsvTest extends TestCase {




  public function testWithInvalidFileName() {
    $this->expectException(RuntimeException::class);
    $csv = new ProcessCsv('wrong.csv', false, '');
  }
}

