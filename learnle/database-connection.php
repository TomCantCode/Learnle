
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

    //Connect to the database
    $CONNECT = mysqli_connect($HOST, $USERNAME, $PASSWORD, $DATABASE, 3306);

    //Check connection
    if (!$CONNECT) {
        die("Connection failed: " . mysqli_connect_error());
      }
    echo "Connected successfully";


?>