#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

DEFINE('DB_USERNAME', 'root');
DEFINE('DB_PASSWORD', 'root');
DEFINE('DB_PORT', '8889');
DEFINE('DB_HOST', '127.0.0.1');
DEFINE('DB_DATABASE', 'progtask');

class CreateUsersTable {

  public function __construct() {
    $this->$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE, DB_PORT);

    if (mysqli_connect_error()) {
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    echo 'Connected successfully.';
  }

  public function createUsersTable() {
    $this->removeExistingUsersTable();
    // Attempt create table query execution
    $sql = "CREATE TABLE users(
      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
      first_name VARCHAR(30) NOT NULL,
      surname VARCHAR(30) NOT NULL,
      email VARCHAR(70) NOT NULL
    )";

    if(mysqli_query($this->$mysqli, $sql)){
      echo "Table users created successfully.";
    } else{
      echo "ERROR: Could not execute $sql. " . mysqli_error($this->$mysqli);
    }
  }

  public function removeExistingUsersTable() {
    $sql = "DROP TABLE IF EXISTS users";

    if(mysqli_query($this->$mysqli, $sql)) {
       echo "Table users is deleted successfully";
    } else {
       echo "Table users has not been deleted\n";
    }
  }

  public function insertUser($first_name, $surname, $email) {
    // Attempt insert query execution
    $sql = "INSERT INTO users (first_name, surname, email) VALUES (?, ?, ?)";
    $statement = $this->$mysqli->prepare($sql);
    $statement->bind_param('sss', $first_name, $surname, $email);

    if($statement->execute()){
      echo "Records inserted successfully.";
    } else{
      echo "ERROR: Could not execute $sql. " . mysqli_error($this->$mysqli);
    }
  }

  public function __destruct() {
    $this->$mysqli->close();
  }
}

$obj = new CreateUsersTable();
$obj->createUsersTable();
$obj->insertUser('Sue', 'Tor', 'sue@suetown.com');

?>

