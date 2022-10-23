<?php

  //Includes connection to the database
  include "database-connection.php";

  $CONNECT;

  session_start();

  //Gets values for variables from form upon completion
  if(isset($_POST["confirm"])) {
    $USERNAME = $_POST["name"];
    $PASSWORD = $_POST["password"];

    //All error checking
    $errors = false;

    //Checks if username exists
    $QUERYREAD = "SELECT * FROM acctbl WHERE Email = '$USERNAME'";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);

    if(mysqli_num_rows($SQLREAD) == 0) {
      $output = "No registered User has that name";
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

  }
  
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Sign In</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="images/logo.png" type="image">
</head>

<div class = "menusmall">
    <div class = "menuleft">
      <a href = "home.php">
        <img class = "logo" src = "images/logo.png" height = "40px" width = "40px">
      </a>
      
      <div>Learnle</div>
    </div>
  
  </div>

<body>

  <div class = "largeboard">
    
    <h2>
      Sign In:
    </h2>

    <pre>
      <form method= "POST" action = "<?php echo $_SERVER["PHP_SELF"] ?>">

        Name:               <input type= "text" id= "name" name= "name" required><br>
        Password:           <input type= "password" id= "password" name= "password" required><br>
        <input type= "submit" value= "Confirm" name= "confirm">   <input type= "reset" required>

        <div class="output" id="output"><?php if(isset($output)) {echo $output;} ?></div>
      </form>
    </pre>
      
  </div>
    
    



</body>

</html>

