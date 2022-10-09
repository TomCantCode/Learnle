
<?php

    //Variables for db connection

    $USERNAME = 'root';
    $HOST = 'localhost';
    $PASSWORD = 'password';
    $DATABASE = 'learnle_db';

    $CONNECT = mysqli_connect($HOST, $USERNAME, $PASSWORD, $DATABASE);


    if(mysqli_connect_errno()) {
        exit('Error: '.mysqli_connect_error());
    }

?>