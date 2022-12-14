<?php

  //Includes connection to the database
  include "resources/database-connection.php";

  $CONNECT;

  session_start();

  //Checks if user is signed in (or not playing the tutorial), else sent to login page
  if(!isset($_SESSION["username"]) && ($_SESSION["setID"]) != 1) {
    $_SESSION["destination"] = str_replace(".php", "", $_SERVER['SCRIPT_NAME']);
    header('Location: login');
  }

  //Checks if user has been sent from a valid page (and given a Set ID)
  if(!isset($_SESSION["setID"])) {
    header('Location: home');
  }

  //Gets the set details from the database
  $SETID = $_SESSION["setID"];
  $QUERYREAD = "SELECT SetName, Tags FROM settbl WHERE SetID = '$SETID'"; 
  $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);
  $ROW = mysqli_fetch_array($SQLREAD);

  $NAME = $ROW["SetName"];

  //Gets the term details from the database into arrays
  $QUERYREAD = "SELECT Term, Def, NumAtt FROM termtbl WHERE SetID = '$SETID'"; 
  $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);
  $columns = mysqli_num_rows($SQLREAD);

  $TERMNAMES = array();
  $TERMDEFS = array();
  $TERM_ATTS = array();

  for($x = 1; $x <= $columns; $x++) {
    $ROW = mysqli_fetch_array($SQLREAD);
    $TERMNAMES[$x] = $ROW["Term"];
    $TERMDEFS[$x] = $ROW["Def"];
    $TERM_ATTS[$x] = $ROW["NumAtt"];
  }

  //unset($_SESSION["setID"]);

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Play!</title>
  <link href="resources/style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="images/logo.png" type="image">
  <script type = "text/javascript" src="resources/learnle.js"></script>
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
          if(isset($_SESSION["username"])) {
            echo 'Playing as '. $_SESSION["username"];
          }
          else {
            echo 'Playing as a new Guest';
          }
        ?>
      </p>
    </div>

</div>

<body>


  <div id = "progress-bar">
    <div id = "progress">0%</div>
  </div>
    
  <div id = "grid-container">
  </div>

  <div id = "hint"> Hint: 
  </div>

  <div id = "game-end">

  </div>

  <div id = "allguesses">
  </div>

  <?php
    $gameComplete = FALSE;
    
    echo '<script>main_loop("['.implode(",",$TERMNAMES).']", ['.implode(",",$TERM_ATTS).'], "['.implode(",",$TERMDEFS).']");
        </script>';

  ?>


</body>

</html>