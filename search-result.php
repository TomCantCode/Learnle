<?php

  //Includes connection to the database
  include "resources/database-connection.php";
  
  $CONNECT;

  session_start();
  $_SESSION["destination"] = null;

  //Cookies are deleted
  setcookie("term_count_uid", "", time() - 3600);
  setcookie("all_guesses", "", time() - 3600);

  //If there is no search query, sent to homepage
  if(!isset($_SESSION["search"]) /*or strlen(trim($_SESSION["search"])) == 0*/) {
    header("Location : home");
  }

  //If searchbar has been entered
  if(isset($_GET["Searchbar"])){
    $_SESSION["search"] = $_GET["Searchbar"];
    header("Location: search-result");
  }

  //Checks if search query is surrounded by '' marks, meaning they are searching by tags
  $SEARCH = $_SESSION["search"];
  $TAGS = $SEARCH;
  $TAG_LIST = array();

  if(str_starts_with($TAGS, '\'') and str_ends_with($TAGS, '\'')) {
    //Search query is converted into seperate tag searches
    $TAGCOUNT = floor(substr_count($TAGS, '\'') / 2);
    for($w = 0; $w < $TAGCOUNT; $w++){
      $start = strpos($TAGS, '\'');
      $end = strpos($TAGS, '\'', $start + 1);
      $length = $end - $start + 1;
      ${"TAG-$w"} = substr($TAGS, $start, $length);
      //Removes seperated tag from the remaining search query
      $TAGS = str_replace(${"TAG-$w"}, '', $TAGS);
      ${"TAG-$w"} = strval(${"TAG-$w"});
      array_push($TAG_LIST, ${"TAG-$w"});
      
    }

    $TAG_STRING = implode(', ',$TAG_LIST);

    //Gets the set by tags from tag table
    $QUERYREAD = "SELECT SetID FROM tagtbl WHERE Tag IN ($TAG_STRING)";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);
    $columns_tags = mysqli_num_rows($SQLREAD);

    //If user has no sets then a message will display
    if($columns_tags == 0) {
      $output = "No results for $TAG_STRING";
    }
    //Puts all the set data into arrays
    else {
      $output = '';
      $SETIDS = array();
      $SETNAMES = array();
      $CREATORS = array();
      $SETTAGS = array();

      for($q = 1; $q <= $columns_tags; $q++) {
        $ROW = mysqli_fetch_array($SQLREAD);
        $SETID = $ROW["SetID"];
      

        $QUERYREAD1 = "SELECT SetID, SetName, AccID, Tags FROM settbl WHERE SetID = $SETID";
        $SQLREAD1 = mysqli_query($CONNECT, $QUERYREAD1);
        $columns = mysqli_num_rows($SQLREAD1);

        for($x = $q; $x < ($columns + $q); $x++){
          $ROW = mysqli_fetch_array($SQLREAD1);
          $SETIDS[$x] = $ROW["SetID"];
          $SETNAMES[$x] = $ROW["SetName"];
          $SETTAGS[$x] = ucwords($ROW["Tags"]);

          //Fetches the username of the set creator
          $ACCID = $ROW["AccID"];
          $QUERYREAD2 = "SELECT AccName FROM acctbl WHERE AccID = $ACCID"; 
          $SQLREAD2 = mysqli_query($CONNECT, $QUERYREAD2);
          $ROW2 = mysqli_fetch_array($SQLREAD2);
          $CREATORS[$x] = $ROW2["AccName"];
        }
      }
    }

  }
  //Else the search query is treated as a string
  else {
    $QUERYREAD = "SELECT SetID, SetName, AccID, Tags FROM settbl WHERE SetName LIKE '$SEARCH%'";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);
    $columns = mysqli_num_rows($SQLREAD);
  

    //If user has no sets then a message will display
    if($columns == 0) {
        $output = "No results for $SEARCH";
    }
    //Puts all the set data into arrays
    else {
        $output = '';
        $SETIDS = array();
        $SETNAMES = array();
        $CREATORS = array();
        $SETTAGS = array();

        for($x = 1; $x <= $columns; $x++){

            $ROW = mysqli_fetch_array($SQLREAD);
            $SETIDS[$x] = $ROW["SetID"];
            $SETNAMES[$x] = $ROW["SetName"];
            $SETTAGS[$x] = ucwords($ROW["Tags"]);;


            //Fetches the username of the set creator
            $ACCID = $ROW["AccID"];
            $QUERYREAD1 = "SELECT AccName FROM acctbl WHERE AccID = $ACCID"; 
            $SQLREAD1 = mysqli_query($CONNECT, $QUERYREAD1);
            $ROW1 = mysqli_fetch_array($SQLREAD1);
            $CREATORS[$x] = $ROW1["AccName"];
        }
    }
  }

  //If any of the play game buttons have been pressed, change page to the game and set the game ID
  if(isset($columns)) {
    for($y = 1; $y <= $columns; $y++){

      if(isset($_POST["play-".$y])) {
          echo $SETIDS[$y];
          $_SESSION["setID"] = $SETIDS[$y];
          header('Location: game');
      }
    }
  }

  //So searchbar doesn't immediatley clear
  if($SEARCH != null) {
    $searchbar_val = $SEARCH;
  }
  elseif(isset($TAG_STRING)) {
    $searchbar_val =  $TAG_STRING;
  }
  else {
    $searchbar_val =  '';
  }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Search Result</title>
  <link href="resources/style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="images/logo.png" type="image">
</head>

<style>
  body {
    overflow-x: hidden;
  }
</style>

<div class = "menu">

    <div class = "menuleft">
      <a href = "home">
        <img class = "logo" src = "images/logo.png" height = "60px" width = "60px">
      </a>
      
      <div>Learnle</div>
    </div>

    <div class = "menumiddle">
      <form method= "GET" action = "<?php echo $_SERVER["PHP_SELF"] ?>">
        <input type = "search" placeholder = "Search for a set" class = "searchbar" name = "Searchbar" value = "<?php echo $searchbar_val?>">
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
                  <a href="personal-library" class="link" target="_self">Personal Library</a><br>
                  <a href="resources/logout" class="link" target="_self">Logout</a><br>
                </div>
            </div>';
          }
          else {
            echo '<a href="login" class="link" target="_self">Login</a><br>
                  <a href="register" class="link" target="_self">Register</a><br>';
          }
          
          ?>
        </div>
    </div>

</div>

<body>
  
  <div class = "largeboard">
    
     <h2>Results for <?php echo $SEARCH?>:</h2>
     <p>
      <?php
        //Depending which method was used
        if(isset($columns_tags)) {
          $TIMES = $columns_tags;
        }
        else{
          $TIMES = $columns;
        } 
        //Grammar
        if($TIMES == 1){
          echo $TIMES.' result:';
        } 
        else if($TIMES > 0 or $TIMES == 0){
          echo $TIMES.' results:';
        }
      ?>
    </p>


     <?php if(isset($output)) {echo $output;} ?>

     <?php

        //Display sets  
        for($a = 1; $a <= $TIMES; $a++){
            echo '
            <div class = "set">
                <div>'.$SETNAMES[$a].'</div>
                <div>By '.$CREATORS[$a].'</div><br>
                <div class = "row">
                  <div>'.$SETTAGS[$a].'</div>
                  <form method = "POST" action = "'. $_SERVER["PHP_SELF"] .'"">
                    <div class = "button">
                      <input type = "submit" class = "roundbutton" name = "play-'.$a.'" id = "play" value = "Play">
                    </div>
                  </form>
                </div>
            </div>';
        }
     ?>
    
  </div>

  
</body>

</html>