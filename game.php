<?php

  //Includes connection to the database
  include "resources/database-connection.php";

  $CONNECT;

  session_start();

  //Checks if user is signed in, else sent to login page
  if(!isset($_SESSION["username"])) {
    $_SESSION["destination"] = $_SERVER['SCRIPT_NAME'];
    header('Location: login.php');
  }

  //Checks if user has been sent from a valid page (and given a Set ID)
  if(!isset($_COOKIE["setID"])) {
    header('Location: home.php');
  }

  //Gets the set and terms from the database
  $SETID = $_COOKIE["setID"];



?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Play!</title>
  <link href="resources/style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="images/logo.png" type="image">
</head>

<style>
  body {
    overflow-x: hidden;
  }
</style>

<div class = "menusmall">

    <div class = "menuleft">
      <a href = "home">
        <img class = "logo" src = "images/logo.png" height = "40px" width = "40px">
      </a>
      
      <div>Learnle</div>
    </div>
  
    <div class = "menuright">
      <p>
        <?php 
           echo 'Playing as '. $_SESSION["username"];
        ?>
      </p>
    </div>

</div>

<body>

  <div class = "progress-bar">
  </div>
    
  <div id="grid-container">
  </div>

  <script src="resources/learnle.js">
    create_grid('grid-container', MAXGUESSES, ANSWER.length);
  </script>



</body>

</html>