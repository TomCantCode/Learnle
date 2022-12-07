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
    $PASSWORD = $_POST["password"];

    //All error checking
    $errors = false;

    //Fetches the Username, email and password from the database
    $QUERYREAD = "SELECT AccID, AccName, Email, AccType, Password FROM acctbl WHERE Email = '$EMAIL'";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);
    $ROW = mysqli_fetch_assoc($SQLREAD);

    //If there are no results from the database,
    if(mysqli_num_rows($SQLREAD) == 0) {
      $output = "Incorrect Username, email or passworda";
      $errors = true;
    }

    //If the Usernames doesn't match,
    if($ROW['AccName'] != $USERNAME) {
      $output = "Incorrect Username, email or passwordb";
      $errors = true;
    }

    //If the passwords doesn't match,
    if($ROW['Password'] != $PASSWORD) {
      $output = "Incorrect Username, email or passwordc";
      echo $ROW['Password']. '<br>' .$PASSWORD;
      $errors = true;
    }

    //If no errors have occured the variables are set to the session variables
    if($errors == false) {
      $_SESSION["ID"] = $ROW["AccID"];
      $_SESSION["username"] = $USERNAME;
      $_SESSION["type"] = $ROW["AccType"];
      $_SESSION["loggedin"] = TRUE;
      $output = "Signed In!";

     //Sent to homepage/orignal destination
     if(!isset($_SESSION["destination"])) {
      $DESTINATION = "home";
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
  <title>Sign In</title>
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
        <div>
          <pre>Don't have an Account?</pre>
          <a href="register" class = "link" target="_self">Register</a><br>
        </div>
    </div>

</div>

<body>

  <div class = "board largeboard">
    
    <h2>
      Sign In:
    </h2>

    <pre>
      <form method= "POST" action = "<?php echo str_replace(".php","",$_SERVER["PHP_SELF"]) ?>">

        Name:               <input type= "text" id= "name" name= "name" required><br>
        Email:              <input type= "text" id= "email" name= "email" required><br>
        Password:           <input type= "password" id= "password" name= "password" required><br>
        <div class = "button"><input type= "submit" class = "smallbutton" value= "Confirm" name= "confirm"></div>   <div class = "button"><input type= "reset" class = "smallbutton" required></div>

        <div class="output" id="output"><?php if(isset($output)) {echo $output;} ?></div>
      </form>
    </pre>
      
  </div>
    
    



</body>

</html>

