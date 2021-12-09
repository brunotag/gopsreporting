<?php
  class db extends mysqli {
    // (You could set defaults for the params here if you want
    //  i.e. $host = 'myserver', $dbname = 'myappsdb' etc.)
    public function __construct($host = NULL, $username = NULL, $dbname = NULL, $port = NULL, $socket = NULL) {
      parent::__construct($host, $username, $dbname, $port, $socket);
      $this->set_charset("utf8mb4");
    } 
  } 
?>
