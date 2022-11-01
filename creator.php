<?php

  //Includes connection to the database
  include "resources/database-connection.php";

  $CONNECT;

  session_start();

  //Checks if user is signed in, else sent to login page
  if(!isset($_SESSION["username"])) {
    header('Location: login.php');
  }

  //Gets values for set variables from form upon completion
  if(isset($_POST["confirm"])) {
    $SETNAME = $_POST["setname"];
    $TAG1 = strtolower($_POST["tag1"]);
    $TAG2 = strtolower($_POST["tag2"]);
    $TAG3 = strtolower($_POST["tag3"]);
    $TAGS = array($TAG1,$TAG2,$TAG3);
    $KEYBOARDTYPE = $_POST["keyboard"];

  //Gets values for term variables from form upon completion
  $TERMNUM = $_COOKIE['term_count_uid'];

  for ($x = 0; $x <= $TERMNUM; $x++) {
    $termname = "termname-".$TERMNUM;
    $attempts = "attempts-".$TERMNUM;
    $def = "def-".$TERMNUM;

    ${"TERMNAME-".$TERMNUM} = strtolower($_POST[$termname]);
    ${"ATTEMPTS-".$TERMNUM} =$_POST[$attempts];
    ${"DEF-".$TERMNUM} = $_POST[$def];
  }

  //All error checking
    $errors = false;

    //Fetches any duplicate set name
    $QUERYREAD = "SELECT * FROM settbl WHERE SetName = '$SETNAME'";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);

    if(mysqli_num_rows($SQLREAD) > 0) {
      $output = "Set name is already in use";
      $errors = true;
    }

    //Checks each term for errors
    

    //If no errors have occured the set variables are set to the database
    if($errors == false) {
      $QUERYADD = "INSERT INTO settbl (SetName, KeyboardType, Tags) VALUES ('$SETNAME', '$KEYBOARDTYPE', '$TAGS')";

      if(mysqli_query($CONNECT, $QUERYADD)) {
        $output = "Set added!";
      }
    }

    //If no errors have occured the term variables are set to the database

    
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
      <a href = "home.php">
        <img class = "logo" src = "images/logo.png" height = "40px" width = "40px">
      </a>
      
      <div>Learnle</div>
    </div>

    <div class = "menuright">
        <p>
          <?php if(isset($_SESSION["username"])) {
            echo 'Save to '. $_SESSION["username"] ."'s Personal library";
          }
          ?>
        </p>
    </div>
  
</div>

<body>

  <div class = "largeboard">
    
    <h2>
      Create a Set:
    </h2>

    
      <form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"] ?>

        <br><br>Set Name:&nbsp&nbsp<input type= "text" id= "setname" name= "setname" required>&nbsp<input type = "submit" value = "Save set" name = "confirm"><br><br>
        Tags:&nbsp&nbsp<input type= "text" id= "tag" name= "tag1" placeholder = "Eg: OCR" required> <input type= "text" id= "tag" name= "tag2" placeholder = "Eg: Physics" required> <input type= "text" id= "tag" name= "tag3" placeholder = "Eg: A-Level" required><br><br>
        Keyboard Type:&nbsp&nbsp
        <select id= "keyboard" name= "keyboard" required><br>
            <option value= "1">Alphabet</option>
            <option value= "2">Maths included</option>
        </select><br><br>
        
        <br>Number of Terms: &nbsp&nbsp
        <div class = "row">
          <input type = "button" value = " + " id = "addterm">&nbsp&nbsp
          <div id = "termcount">1</div>&nbsp&nbsp
          <input type = "button" value = " - " id = "removeterm">
        </div>
        
        <div class = "output" id = "output"><?php if(isset($output)) {echo $output;} ?></div>
      </form>

      <div id = "termlist"><br>

          <div class = "term" id = 1>
            <div class = "num">Term 1:</div><br>
            <div class = "row">
              <div class = "row">Name:&nbsp&nbsp<input type= "text" id= "termname-1" name= "termname-1" required>&nbsp&nbsp&nbsp&nbsp</div>
              <div class = "row">Number of attempts:&nbsp&nbsp<input type= "number" id= "attempts-1" name= "attempts-1" required><br></div>
            </div>
            <div class = "row"><br>Definition (Hint):&nbsp&nbsp<input type= "text" id= "def-1" name= "def-1" required></div>
          </div>

      </div>
      
      <script src = "resources/terms.js"></script>

    
      
  </div>
    
    



</body>

</html>
