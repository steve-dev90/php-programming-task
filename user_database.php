#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

  DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'root');
  DEFINE('DB_PORT', '8889');
  DEFINE('DB_HOST', '127.0.0.1');
  DEFINE('DB_DATABASE', 'progtask');

  $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

  if (mysqli_connect_error()) {
    die("ERROR: Could not connect. " . mysqli_connect_error());
  }

  // Attempt create table query execution
  $sql = "CREATE TABLE users(
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    first_name VARCHAR(30) NOT NULL,
    surname VARCHAR(30) NOT NULL,
    email VARCHAR(70) NOT NULL
  )";

  if(mysqli_query($mysqli, $sql)){
    echo "Table created successfully.";
  } else{
    echo "ERROR: Could not able to execute $sql. " . mysqli_error($mysqli);
  }
    echo 'Connected successfully.';

  $mysqli->close();
?>

