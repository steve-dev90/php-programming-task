<?php

// Sets up database configuration options and hopefully proects them from inadvertent changes

class DatabaseConfig
{
  public function __construct($user_name, $password, $host, $port, $database) {
    $this->user_name = $user_name;
    $this->password = $password;
    $this->host = $host;
    if ($port == null) {
      $this->port = '8889';
    } else {
      $this->port = $port;
    }
    if ($database== null) {
      $this->database= 'progtask';
    } else {
      $this->database= $database;
    }
  }

  public function get_user_name() {
    return $this->user_name;
  }

  public function get_password() {
    return $this->password;
  }

  public function get_host() {
    return $this->host;
  }

  public function get_port() {
    return $this->port;
  }

  public function get_database() {
    return $this->database;
  }
}