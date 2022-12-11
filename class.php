<?php

  //Includes connection to the database
  include "resources/database-connection.php";

  $CONNECT;

  session_start();
  unset($output);

  //Checks if user is signed in, else sent to login page
  if(!isset($_SESSION["username"])) {
    $_SESSION["destination"] = str_replace(".php","",$_SERVER['SCRIPT_NAME']);
    header('Location: login');
  }


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Class</title>
  <link href="resources/style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="images/logo.png" type="image">
</head>

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
            echo 'Signed in as '. $_SESSION["username"];
          ?>
        </p>
    </div>
  
</div>

<body>

  <section>

    <div class = "board sideboard">
      <h2>Students</h2>
      <ul>
        <li>Bloke 1</li>
        <li>Bloke sdgfffsdgddsgdssdg2</li>
        <li>Bloke 3</li>
      </ul>
    </div>

    <div>
      <div class = "board headerboard">
        <h2>Header</h2>
        Class code:
      </div>

      <div class = "board classfeed">
        <h2>Feed</h2>
      </div>
    </div>

  </section>
    
    



</body>

</html>
