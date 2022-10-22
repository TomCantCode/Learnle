
<?php

    //Display any hidden errors
    ini_set('display_errors', true);
    ini_set('display_startup_errors', true);
    error_reporting(E_ALL);

    //Variables for db connection
    $USERNAME = 'root';
    $HOST = 'localhost';
    $PASSWORD = 'password';
    $DATABASE = 'learnle';
    $ROOT = '3306';

    //Connect to the database
    $CONNECT = mysqli_connect($HOST, $USERNAME, $PASSWORD, $DATABASE, $ROOT);

    //Check connection
    if (!$CONNECT) {
        die("Connection failed: " . mysqli_connect_error());
      }
    echo "Connected successfully";


?>