<?php

  //Includes connection to the database
  include "resources/database-connection.php";

  $CONNECT;

  session_start();
  unset($alert);
  $DESTINATION = '';

  echo '<script type="text/JavaScript">var leave = false
      </script>';

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
      $alert = "Incorrect Username, email or password";
      $errors = true;
    }
    else{
      //If the Usernames doesn't match,
      if($ROW['AccName'] != $USERNAME) {
        $alert = "Incorrect Username, email or password";
        $errors = true;
      }

      //If the passwords doesn't match,
      if($ROW['Password'] != $PASSWORD) {
        $alert = "Incorrect Username, email or password";
        echo $ROW['Password']. '<br>' .$PASSWORD;
        $errors = true;
      }
    }

    //If no errors have occured the variables are set to the session variables
    if($errors == false) {
      $_SESSION["ID"] = $ROW["AccID"];
      $_SESSION["username"] = $USERNAME;
      $_SESSION["type"] = $ROW["AccType"];
      $_SESSION["loggedin"] = TRUE;
      $alert = "Signed In!";

      //Sent to homepage/orignal destination
      if(!isset($_SESSION["destination"])) {
        $DESTINATION = "home";
      }
      else {
        $DESTINATION = $_SESSION["destination"];
      }

      echo '<script type="text/JavaScript">leave = true
      </script>';

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
      if(leave == true){
        window.location.href = "<?php echo $DESTINATION?>";
      }
    }

    //Close the pop-up if the user clicks the screen anywhere
    window.onclick = function(event) {
      if((event.target == modal) || (event.target == box)) {
        modal.style.display = "none";
        if(leave == true){
          window.location.href = "<?php echo $DESTINATION?>";
        }
      }
    }
  </script>

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

      </form>
    </pre>
      
  </div>
    
    



</body>

</html>

