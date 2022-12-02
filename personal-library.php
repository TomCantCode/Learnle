<?php

    //Includes connection to the database
    include "resources/database-connection.php";

    $CONNECT;
  
    session_start();

    unset($output_sets);
    unset($output_classes);
    
    //Cookies are deleted
    setcookie("term_count_uid", "", time() - 3600);
    setcookie("all_guesses", "", time() - 3600);
  
    //Checks if user is signed in, else sent to login page
    if(!isset($_SESSION["username"])) {
        $_SESSION["destination"] = str_replace(".php","",$_SERVER['SCRIPT_NAME']);
        header('Location: login');
    }

    //If searchbar has been entered
    if(isset($_GET["Searchbar"])){
      $_SESSION["search"] = $_GET["Searchbar"];
      header("Location: search-result");
    }

    //Gets all the sets the user has created from the database
    $ACCID = $_SESSION["ID"];
    $QUERYREAD = "SELECT SetID, SetName, Tags FROM settbl WHERE AccID = '$ACCID' ORDER BY SetName"; 
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);
    $columns = mysqli_num_rows($SQLREAD);

    //If user has no sets then a message will display
    if($columns == 0) {
        $output_sets = "You have no sets, try making some!";
    }
    //Puts all the set data into arrays
    else {
        $output_sets = '';
        $SETIDS_U = array();
        $SETNAMES_U = array();
        $SETTAGS_U = array();

        for($x = 1; $x <= $columns; $x++){
            $ROW = mysqli_fetch_array($SQLREAD);
            $SETIDS_U[$x] = $ROW["SetID"];
            $SETNAMES_U[$x] = $ROW["SetName"];
            $SETTAGS_U[$x] = $ROW["Tags"];
        }

    }


    //If any of the play game buttons have been pressed, change page to the game and set the game ID
    for($y = 1; $y <= $columns; $y++){

      if(isset($_POST["play-".$y])) {
          echo $SETIDS_U[$y];
          $_SESSION["setID"] = $SETIDS_U[$y];
          header('Location: game');
      }
    }

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
      <form method= "GET" action = "<?php echo $_SERVER["PHP_SELF"] ?>">
        <input type = "search" placeholder = "Search for a set" class = "searchbar" name = "Searchbar">
      <form>
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
    
    <div class = "halfboard">
     <h2>Your Sets:</h2>
     <p>Sets you make or save will appear here</p>


     <?php if(isset($output_sets)) {echo $output_sets;} ?>

     <?php
        //Display created sets

        for($a = 1; $a <= $columns; $a++){
            echo '
            <div class = "set">
                <div>'.$SETNAMES_U[$a].'</div><br>
                <div class = "row">
                  <div>'.$SETTAGS_U[$a].'</div>
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

    <div class = "halfboard">
     <h2>Your Classes:</h2>
     <p>Classes you join will appear here</p>

    
    </div>
    
  </div>

  
</body>

</html>