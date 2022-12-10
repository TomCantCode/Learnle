<?php

  //Includes connection to the database
  include "resources/database-connection.php";

  $CONNECT;

  session_start();
  unset($alert);
  echo '<script src = "resources/terms.js"></script>
     <script type="text/JavaScript"> 
     var SAVED = false;
     </script>';
   

  //Checks if user is signed in, else sent to login page
  if(!isset($_SESSION["username"])) {
    $_SESSION["destination"] = str_replace(".php","",$_SERVER['SCRIPT_NAME']);
    header('Location: login');
  }


  //Gets values for set variables from form upon completion
  if(isset($_POST["confirm"])) {
    $SETNAME = $_POST["setname"];
    $TAG1 = strtolower($_POST["tag1"]);
    $TAG2 = strtolower($_POST["tag2"]);
    $TAG3 = strtolower($_POST["tag3"]);
    $TAGS = array($TAG1,$TAG2,$TAG3);
    $TAGS = array_filter($TAGS);
    $TAGS = implode(", ",$TAGS);
    $KEYBOARDTYPE = $_POST["keyboard"];

    //Gets values for term variables from form upon completion
    $TERMNUM = $_COOKIE['term_count_uid'];

    for ($x = 1; $x <= $TERMNUM; $x++) {
      ${"TERMNAME-".$x} = strtolower($_POST["termname-$x"]);
      ${"ATTEMPTS-".$x} = $_POST["attempts-$x"];
      ${"DEF-".$x} = $_POST["def-$x"];
    }

    //Checks each tag is a sensible length
    for($a = 1; $a < 3; $a++) {
      if(!(${"TAG".$a} < 20)) {
        $alert = "Length of tag is too large (Tag: $a)";
        $errors = true;
      }
    }

    //All error checking
    $errors = false;

    //Fetches any duplicate set name
    $QUERYREAD = "SELECT * FROM settbl WHERE SetName = '$SETNAME'";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);

    if(mysqli_num_rows($SQLREAD) > 0) {
      $alert = "Set name is already in use";
      $errors = true;
    }

    //Checks set title is only alphanumeric
    if(!preg_match("#^[a-zA-Z0-9 ]+$#", $SETNAME)) {
      $alert = "Set name doesn't contain just alphanumeric characters";
      $errors = true;
    }

    //Checks each term for errors
    for ($x = 1; $x <= $TERMNUM; $x++) {

      $CURRENTTERM = ${"TERMNAME-".$x};
      $CURRENTATT = ${"ATTEMPTS-".$x};
      $CURRENTDEF = ${"DEF-".$x};

      //If term is too long
      if(!(strlen($CURRENTTERM) <= 15)) {
        $alert = "Term is too long (Term: $x) $CURRENTTERM";
        $errors = true;
      }

      //If term has character that won't be typable with keyboard type
      if($KEYBOARDTYPE == 1) {
        $alphabet = "#^[a-zA-Z]+$#";
      }
      else {
        $alphabet = "#^[a-zA-Z0-9+-/*=]+$#";
      }

      if(!preg_match($alphabet, $CURRENTTERM)) {
        $alert = "Term doesn't contain legal characters from chosen keyboard mode (Term: $x)";
        $errors = true;
      }

      //If number of attempts is less than the length of the word AND sensible length (i.e unfair)
      if($CURRENTATT < strlen($CURRENTTERM)) {
        $alert = "Number of attempts is less than the length of the Term (Term: $x)";
        $errors = true;
      }
    
      if(!($CURRENTATT < 15)) {
          $alert = "Number of attempts is too large (Term: $x)";
          $errors = true;
      }
    }
 

    //If no errors have occured the set variables are set to the database
    if($errors == false) {
      $ACCID = $_SESSION["ID"];
      $QUERYADD = "INSERT INTO settbl (SetName, AccID, KeyboardType, Tags) VALUES ('$SETNAME', '$ACCID', '$KEYBOARDTYPE', '$TAGS')";

      if(mysqli_query($CONNECT, $QUERYADD)) {
        $alert = "Set added!";
      }

      //Tags added to seperate table
      $QUERYREAD = "SELECT SetID FROM settbl WHERE SetName = '$SETNAME'";
      $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);
      $ROW = mysqli_fetch_assoc($SQLREAD);
      $SETID = $ROW["SetID"];

      for($b = 1; $b <= 3; $b++) {
        $CURRENTTAG = ${"TAG".$b};
        //Only adds tag to table if it has been set
        if($CURRENTTAG != null) {
          $QUERYADD = "INSERT INTO tagtbl (SetID, Tag) VALUES ('$SETID', '$CURRENTTAG')";

          if(mysqli_query($CONNECT, $QUERYADD)) {
            $alert = "Tag ". $b ." added!";
          }
        }
      }

    }

    //If no errors have occured the term variables are set to the database
    if($errors == false) {
      for ($x = 1; $x <= $TERMNUM; $x++) {

        $CURRENTTERM = ${"TERMNAME-$x"};
        $CURRENTATT = ${"ATTEMPTS-$x"};
        $CURRENTDEF = ${"DEF-$x"};
        $QUERYADD = "INSERT INTO termtbl (Term, SetID, Def, NumAtt) VALUES ('$CURRENTTERM', '$SETID', '$CURRENTDEF', '$CURRENTATT')";

        if(mysqli_query($CONNECT, $QUERYADD)) {
          $alert = "Term ". $x ." added!";
        }
      }


     echo '<script src = "resources/terms.js"></script>
     <script type="text/JavaScript"> 
     SAVED = true;
     </script>';
     $alert = "Set added!";

    }
    
  }
  
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Create a Set</title>
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
            echo 'Save to '. $_SESSION["username"] ."'s Personal library";
          ?>
        </p>
    </div>
  
</div>

<body>

  <?php
    //$alert = 'Popup';
    if(isset($alert)){
      $alert_status = 'block';
    }
    else{
      ob_start();
      $alert_status = 'none';
      ob_end_clean();
    }
  ?>


  <style>
    .modal {
      display: <?php echo $alert_status?>;
    }
  </style>

  <div id="popup" class="modal">

    <div class="alertbox">
      <div class="text">
        <?php if(isset($alert)) {echo $alert;}?>
      </div>
    </div>

  </div>

  <script>
    //Set variables
    var modal = document.getElementById("popup");
    var box = document.getElementsByClassName("alertbox")[0];

    //Close the pop-up if the user clicks it
    box.onclick = function() {
      modal.style.display = "none";
      if(SAVED == true){
        window.location.href = "home";
      }
    }

    //Close the pop-up if the user clicks the screen anywhere
    window.onclick = function(event) {
      if((event.target == modal) || (event.target == box)) {
        modal.style.display = "none";
        if(SAVED == true){
          window.location.href = "home";
        }
      }
    }
  </script>





  <div class = "board largeboard">
    
    <h2>
      Create a Set:
    </h2>
    
      <form method = "POST" action = "<?php echo str_replace(".php","",$_SERVER["PHP_SELF"]) ?>" autocomplete="off">

        <div class = "button">
          <input type = "submit" class = "smallbutton" id= "save" value = "Save set" name = "confirm"><br><br>
        </div>
        Set Name:&nbsp&nbsp<input type= "text" id= "setname" name= "setname" required>&nbsp<br><br>
        Tags:&nbsp&nbsp<input type= "text" id= "tag" name= "tag1" placeholder = "Eg: OCR"> <input type= "text" id= "tag" name= "tag2" placeholder = "Eg: Physics" > <input type= "text" id= "tag" name= "tag3" placeholder = "Eg: A-Level" ><br><br>
        Keyboard Type:&nbsp&nbsp
        <select id= "keyboard" name= "keyboard" required><br>
            <option value= "1">Alphabet</option>
            <option value= "2">Maths included</option>
        </select><br><br>
        
        <br>Number of Terms: &nbsp&nbsp
        <div class = "row">
          <div class = "button">
            <input type = "button" class = "smallbutton" value = " + " id = "addterm">&nbsp&nbsp
          </div>
          <div id = "termcount">1</div>&nbsp&nbsp
          <div class = "button">
            <input type = "button" class = "smallbutton" value = " - " id = "removeterm">
          </div>
        </div>
      

      <div id = "termlist"><br>

          <div class = "term" id = 1>
            <div>Term 1:</div><br>
            <div class = "row">
              <div class = "row">Name:&nbsp&nbsp<input type= "text" id= "termname-1" name= "termname-1" required autocomplete="off">&nbsp&nbsp&nbsp&nbsp</div>
              <div class = "row">Number of attempts:&nbsp&nbsp<input type= "number" id= "attempts-1" name= "attempts-1" required><br></div>
            </div>
            <div class = "row"><br>Definition (Hint):&nbsp&nbsp<input type= "text" id= "def-1" name= "def-1" required autocomplete="off"></div>
          </div>

      </div>
      </form>

      <script src = "resources/terms.js"></script>

    
      
  </div>
    
    



</body>

</html>
