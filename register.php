<?php

  //Includes connection to the database
  include "resources/database-connection.php";

  $CONNECT;

  session_start();
  unset($output);

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

    //If no errors have occured the variables are set to the database and session variables
    if($errors == false) {
      $PASSWORD = $PASSWORD;//Hashing here
      $QUERYADD = "INSERT INTO acctbl (AccName, Email, DOB, AccType, Password) VALUES ('$USERNAME', '$EMAIL', '$DOB', '$ACCTYPE', '$PASSWORD')";

      if(mysqli_query($CONNECT, $QUERYADD)) {
        $output = "Account added!";
      }

      $QUERYREAD = "SELECT AccID, AccType FROM acctbl WHERE Email = '$EMAIL'";
      $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);
      $ROW = mysqli_fetch_assoc($SQLREAD);

      $_SESSION["ID"] = $ROW["AccID"];
      $_SESSION["username"] = $USERNAME;
      $_SESSION["type"] = $ROW["AccType"];
      $_SESSION["loggedin"] = TRUE;

     //Sent to homepage/orignal destination
     if(!isset($_SESSION["destination"])) {
      $DESTINATION = "home.php";
     }
     else {
      $DESTINATION = $_SESSION["destination"];
     }

     echo '<script type="text/JavaScript"> 
     alert("Signed In!");
     window.location.href = "' . $DESTINATION . '";
     </script>';
     $_SESSION["destination"] = null;


    }

  }
  
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Register Account</title>
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
        <div>
          <pre>Already have an Account?</pre>
          <a href="login.php" class="link" target="_self">Log In</a><br>
        </div>
    </div>
  
</div>

<body>

  <div class = "largeboard">
    
    <h2>
      Create an Account:
    </h2>

    <pre>
      <form method= "POST" action = "<?php echo $_SERVER["PHP_SELF"] ?>"  autocomplete="off">

        Name:               <input type= "text" id= "name" name= "name" required><br>
        Email:              <input type= "text" id= "email" name= "email" required><br>
        Date of Birth:      <input type= "date" id= "dob" name= "dob" required><br>
        Account Type:       <select id= "acctype" name= "acctype" required>
          <option value= "s">Student</option>
          <option value= "t">Teacher</option>
        </select><br>
        Password:           <input type= "password" id= "password" name= "password" required><br>
        Confirm Password:   <input type= "password" id= "cpassword" name= "cpassword" required><br><br>
        <input type= "submit" class = "smallbutton" value= "Confirm" name= "confirm">   <input type= "reset" class = "smallbutton" required>

        <div class="output" id="output"><?php if(isset($output)) {echo $output;} ?></div>
      </form>
    </pre>
      
  </div>
    
    



</body>

</html>

