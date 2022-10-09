<?php

$USER =  "root";
$HOST =  "localhost";
$PASSWORD =  "password";
$DATABASE_NAME =  "database";

$conn = mysqli_connect($HOST, $USER, $PASSWORD, $DATABASE_NAME);

if(mysqli_connect_errno()) {
    exit('Failed to connect to MySQL: ' .mysqli_connect_errno());
}