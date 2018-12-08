<?php
function read_csv() {
  $filename = 'users.csv';
  $users = [];
  if (($handle = fopen("{$filename}", "r")) !== FALSE)
  {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE)
    {
      $users[] = $data;
    }
    fclose($handle);
  }
  var_dump($users);
}
?>