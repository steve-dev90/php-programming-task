<?php

//This class contains all database related functions

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
      throw new RuntimeException ('Could not connect to database, please check your configuration options. Error: ' . mysqli_connect_error() . "\n\n");
    }
    echo 'Connected to database successfully\n\n';
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

    if(!mysqli_query($this->mysqli, $sql)){
      throw new RuntimeException ('Could not create users table. Error: ' . mysqli_error($this->mysqli) . "\n\n");
    }
  }

  public function removeExistingUsersTable() {
    $sql = "DROP TABLE IF EXISTS users";

    if(!mysqli_query($this->mysqli, $sql)) {
      throw new RuntimeException ('Could not delete existing users table. Error: ' . mysqli_error($this->mysqli) . "\n\n");
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