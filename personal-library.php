<?php

  //Includes connection to the database
  include "resources/database-connection.php";

  $CONNECT;

  session_start();

  unset($output_sets1);
  unset($output_classes);
  
  //Cookies are deleted
  setcookie("term_count_uid", "", time() - 3600);
  setcookie("all_guesses", "", time() - 3600);

  //Checks if user is signed in, else sent to login page
  if(!isset($_SESSION["username"])) {
    $_SESSION["destination"] = str_replace(".php","",$_SERVER['SCRIPT_NAME']);
    header('Location: login');
    exit();
  }

  //If searchbar has been entered
  if(isset($_GET["Searchbar"])){
    $_SESSION["search"] = $_GET["Searchbar"];
    header("Location: search-result");
    exit();
  }

  //Gets all the sets the user has created from the database
  $ACCID = $_SESSION["ID"];
  $QUERYREAD = "SELECT SetID, SetName, Tags FROM settbl WHERE AccID = '$ACCID' ORDER BY SetName"; 
  $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);
  $columns = mysqli_num_rows($SQLREAD);

  //If user has no sets then a message will display
  if($columns == 0){
      $output_sets1 = "You have no sets, try making some!";
  }
  //Puts all the set data into arrays
  else{
      $output_sets1 = '';
      $SETIDS_U = array();
      $SETNAMES_U = array();
      $SETTAGS_U = array();

      for($x = 1; $x <= $columns; $x++){
        $ROW = mysqli_fetch_array($SQLREAD);
        $SETIDS_U[$x] = $ROW["SetID"];
        $SETNAMES_U[$x] = $ROW["SetName"];
        $SETTAGS_U[$x] = ucwords($ROW["Tags"]);
      }

  }

  //Gets all the sets the user has saved from the database
  $QUERYREAD2 = "SELECT SetID FROM personaltbl WHERE AccID = '$ACCID'"; 
  $SQLREAD2 = mysqli_query($CONNECT, $QUERYREAD2);
  $columns2 = mysqli_num_rows($SQLREAD2);

  //If user has no saved sets then a message will display
  if($columns2 == 0){
      $output_sets2 = "You have not saved any sets";
  }
  //Puts all the set data into arrays
  else{
      $output_sets2 = '';
      $SETIDS_S = array();
      $SETNAMES_S = array();
      $SETTAGS_S = array();

      for($q = 1; $q <= $columns2; $q++) {
        $ROW2 = mysqli_fetch_array($SQLREAD2);
        $SETID = $ROW2["SetID"];
      
        $QUERYREAD3 = "SELECT SetID, SetName, AccID, Tags FROM settbl WHERE SetID = $SETID";
        $SQLREAD3 = mysqli_query($CONNECT, $QUERYREAD3);
        $columns3 = mysqli_num_rows($SQLREAD3);

        for($z = $q; $z < ($columns3 + $q); $z++){
          $ROW3 = mysqli_fetch_array($SQLREAD3);
          $SETIDS_S[$z] = $ROW3["SetID"];
          $SETNAMES_S[$z] = $ROW3["SetName"];
          $SETTAGS_S[$z] = ucwords($ROW3["Tags"]);

          //Fetches the username of the set creator
          $CREATORID = $ROW3["AccID"];
          $QUERYREAD4 = "SELECT AccName FROM acctbl WHERE AccID = $CREATORID"; 
          $SQLREAD4 = mysqli_query($CONNECT, $QUERYREAD4);
          $ROW4 = mysqli_fetch_array($SQLREAD4);
          $CREATORS_S[$z] = $ROW4["AccName"];
        }
      }

  }

  //If any of the play created game buttons have been pressed, change page to the game and set the game ID
  for($y = 1; $y <= $columns; $y++){

    if(isset($_POST["play_u-".$y])){
        echo $SETIDS_U[$y];
        $_SESSION["setID"] = $SETIDS_U[$y];
        header('Location: game');
        exit();
    }
  }

  //If any of the play saved game buttons have been pressed, change page to the game and set the game ID
  for($y = 1; $y <= $columns; $y++){

    if(isset($_POST["play_s-".$y])){
        echo $SETIDS_S[$y];
        $_SESSION["setID"] = $SETIDS_S[$y];
        header('Location: game');
        exit();
    }
  }

    //If any of the play game buttons have been pressed, change page to the game and set the game ID
  if(isset($columns2)) {
    for($y = 1; $y <= $columns2; $y++){

      if(isset($_POST["play-".$y])){
          $_SESSION["setID"] = $SETIDS[$y];
          header('Location: game');
      }
    }
  }

  //If any of the save/unsave game buttons have been pressed, added/removed to personal library
  if(isset($columns2)) {
    for($y = 1; $y <= $columns2; $y++){

      //If user pressed the unsave button
      if(isset($_POST["unsave-".$y])){
        //Variables are set
        $errors = 0;
        $SAVESET = $SETIDS_S[$y];

        //Checks to see if user has already saved this set
        $QUERYREAD5 = "SELECT AccID, SetID FROM personaltbl WHERE (AccID = '$ACCID') and (SetID = '$SAVESET')";
        $SQLREAD5 = mysqli_query($CONNECT, $QUERYREAD5);
        $columns5 = mysqli_num_rows($SQLREAD5);

        //If there are no errors, adds Set to personal library table under user's ID
        if($errors == 0){
          $QUERYDEL = "DELETE FROM personaltbl WHERE (AccID = '$ACCID') and (SetID = '$SETIDS_S[$y]')";
          //echo $USERID;
          if(mysqli_query($CONNECT, $QUERYDEL)){
            echo '<script>alert("Set removed!")</script>';
            header('Location: personal-library');
            //unset($_POST["unsave-".$y]);
          }
        }

      }
      
    }
  }


  $_SESSION["search"] = null;

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Your Personal Library</title>
  <link href="resources/style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="images/logo.png" type="image">
</head>


<div class = "menu">

    <div class = "menuleft">
      <a href = "home">
        <img class = "logo" src = "images/logo.png" height = "60px" width = "60px">
      </a>
      
      <div>Learnle</div>
    </div>

    <div class = "menumiddle">
      <form method= "GET" action = "<?php echo str_replace(".php","",$_SERVER["PHP_SELF"]) ?>">
        <input type = "search" placeholder = "Search for a set" class = "searchbar" name = "Searchbar">
      </form>
    </div>
  
    <div class = "menuright">
        <div>

          <?php 
          
          //Sets displayed profile image, either a teacher or student, depending on users account type
          if(isset($_SESSION["username"])) {
            if(($_SESSION["type"]) == 't') {
              $image = 'teacher';
            }
            else {
              $image = 'student';
            }

            //Sets right menu depending whether user is signed in
            echo 
            '<div class = "dropdown">
              <button class = "dropbutton"><img class = "icon" src = "images/' . $image . '.png" height = "64px" width = "64px"></button>
                <div class = "droplist">
                  <pre>' . $_SESSION["username"] . '</pre>
                  <a href="resources/logout" class="link" target="_self">Logout</a><br>
                </div>
            </div>';
          }
          
          ?>
        </div>
    </div>

</div>

<body>
  
  <div class = "groupboard">
    
    <div class = "board halfboard">
     <h2>Your Sets:</h2>
     <p>Sets you make or save will appear here</p>


     <?php if(isset($output_sets1)) {echo $output_sets1;} ?>

     <?php
        //Display created sets

        for($a = 1; $a <= $columns; $a++){
            echo '
            <div class = "set">
                <div>'.$SETNAMES_U[$a].'</div><br>
                <div class = "row">
                  <div>'.$SETTAGS_U[$a].'</div>
                  <form method = "POST" action = "'. str_replace(".php","",$_SERVER["PHP_SELF"]) .'"">
                    <div class = "button">
                      <input type = "submit" class = "roundbutton" name = "play_u-'.$a.'" id = "play" title = "Play this Set" value = "Play">
                    </div>
                  </form>
                </div>
            </div>';
        }
     ?>


     <?php if(isset($output_sets2)) {echo $output_sets2;} ?>


     <?php

        //Display sets
        $TIMES = $columns2;
        for($a = 1; $a <= $TIMES; $a++){

          $SAVEBUTTON = '<input type = "submit" class = "roundbutton" name = "unsave-'.$a.'" id = "like" title = "Remove from your personal library" value = "Remove">';

          echo '
          <div class = "set">
              <div>'.$SETNAMES_S[$a].'</div>
              <div>By '.$CREATORS_S[$a].'</div><br>
              <div class = "row">
                <div>'.$SETTAGS_S[$a].'</div>
                <form method = "POST" action = "'. str_replace(".php","",$_SERVER["PHP_SELF"]) .'">
                  <div class = "button">
                    <input type = "submit" class = "roundbutton" name = "play_s-'.$a.'" id = "play" title = "Play this Set" value = "Play">
                  '.$SAVEBUTTON.'
                  </div>
                </form>
              </div>
          </div>';

          $SAVEBUTTON = '';
        }
     ?>
    </div>

    <div class = "board halfboard">
     <h2>Your Classes:</h2>
     <p>Classes you join will appear here</p>

    
    </div>
    
  </div>

  
</body>

</html>