#!/Applications/MAMP/bin/php/php7.0.32/bin/php
<?php

class CreateUsersTable
{
  public function __construct($config) {
    $this->mysqli = new mysqli(
      $config->get_host(),
      $config->get_user_name(),
      $config->get_password(),
      $config->get_database(),
      $config->get_port()
    );

    if (mysqli_connect_error()) {
      die("ERROR: Could not connect. " . mysqli_connect_error());
    }
    echo 'Connected to database successfully\n';
  }

  public function createUsersTable() {
    $this->removeExistingUsersTable();
    // Attempt create table query execution
    $sql = "CREATE TABLE users(
      id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
      first_name VARCHAR(30) NOT NULL,
      surname VARCHAR(30) NOT NULL,
      email VARCHAR(70) NOT NULL UNIQUE
    )";

    if(mysqli_query($this->mysqli, $sql)){
      echo "Table users created successfully\n";
    } else{
      die ("ERROR: Could not execute $sql. " . mysqli_error($this->mysqli));
    }
  }

  public function removeExistingUsersTable() {
    $sql = "DROP TABLE IF EXISTS users";

    if(mysqli_query($this->mysqli, $sql)) {
       echo "Table users is deleted successfully";
    } else {
       die( "Table users has not been deleted\n");
    }
  }

  public function insertUser($first_name, $surname, $email) {
    // Attempt insert query execution
    $sql = "INSERT INTO users (first_name, surname, email) VALUES (?, ?, ?)";
    $statement = $this->mysqli->prepare($sql);
    $statement->bind_param('sss', $first_name, $surname, $email);

    if($statement->execute()){
      echo "Records inserted successfully\n\n";
    } else{
      echo "Warning: Could not insert record into database. " . mysqli_error($this->mysqli) . "\n\n";
    }
  }

  public function __destruct() {
    $this->mysqli->close();
  }
}