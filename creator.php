<?php

  //Includes connection to the database
  include "resources/database-connection.php";

  $CONNECT;

  session_start();

  //Gets values for variables from form upon completion
  if(isset($_POST["confirm"])) {
    $USERNAME = $_POST["name"];
    $EMAIL = $_POST["email"];
    $DOB = $_POST["dob"];
    $ACCTYPE = $_POST["acctype"];
    $PASSWORD = $_POST["password"];
    $CPASSWORD = $_POST["cpassword"];

  //All error checking
    $errors = false;

    if($PASSWORD != $CPASSWORD) {
      $output = "Passwords do not match";
      $errors = true;
    }

    $TODAY = date("Y-m-d");

    if($DOB >= $TODAY) {
      $output = "Date of Birth is invalid";
      $errors = true;
    }

    //Fetches any duplicate email addresses
    $QUERYREAD = "SELECT * FROM acctbl WHERE Email = '$EMAIL'";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);

    if(mysqli_num_rows($SQLREAD) > 0) {
      $output = "Email is already in use";
      $errors = true;
    }

    //If no errors have occured the variables are set to the database
    if($errors == false) {
      $PASSWORD = $PASSWORD;//Hashing here
      $QUERYADD = "INSERT INTO acctbl (AccName, Email, DOB, AccType, Password) VALUES ('$USERNAME', '$EMAIL', '$DOB', '$ACCTYPE', '$PASSWORD')";

      if(mysqli_query($CONNECT, $QUERYADD)) {
        $output = "Account added!";
      }
    }

    $_SESSION["username"] = $USERNAME;
    $_SESSION["loggedin"] = TRUE;

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

    
      <form method = "POST" action = "<?php echo $_SERVER["PHP_SELF"] ?>">

        <br><br>Set Name:&nbsp&nbsp<input type= "text" id= "setname" name= "setname" required>&nbsp<input type = "submit" value = "Save set" name = "confirm"><br><br>
        Tags:&nbsp&nbsp<input type= "text" id= "tag" name= "tag1" placeholder = "Eg: OCR" required> <input type= "text" id= "tag" name= "tag2" placeholder = "Eg: Physics" required> <input type= "text" id= "tag" name= "tag3" placeholder = "Eg: A-Level" required><br><br>
        Keyboard Type:&nbsp&nbsp<select id= "keyboard" name= "keyboard" required><br>
            <option value= "1">Alphabet</option>
            <option value= "2">Simple Maths</option>
            <option value= "3">Complex Maths</option>
          </select><br><br>
        
        <br>Terms:          
        Number of Terms: &nbsp&nbsp<input type = "button" value = " + " id = "addterm">&nbsp&nbsp<div id = "termcount">0</div>&nbsp&nbsp<input type = "button" value = " - " id = "removeterm">  
        
        <div class = "output" id = "output"><?php if(isset($output)) {echo $output;} ?></div>
      </form>

      <div id = "termlist"><br>

          <div class = "term" id = 1>
            <br>Name:&nbsp&nbsp<input type= "text" id= "setname" name= "setname" required>&nbsp&nbsp&nbsp&nbsp Number of attempts:&nbsp&nbsp<input type= "number" id= "setname" name= "setname" required><br>
            <br>Definition (Hint):&nbsp&nbsp<input type= "text" id= "tag" name= "tag1" required>
          </div>

      </div>
      
      <script src = "resources/terms.js"></script>

    
      
  </div>
    
    



</body>

</html>
