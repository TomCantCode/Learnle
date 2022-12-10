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
    $DOB = $_POST["dob"];
    $ACCTYPE = $_POST["acctype"];
    $PASSWORD = $_POST["password"];
    $CPASSWORD = $_POST["cpassword"];

    //All error checking
    $errors = false;

    if($PASSWORD != $CPASSWORD) {
      $alert = "Passwords do not match";
      $errors = true;
    }

    $TODAY = date("Y-m-d");

    if($DOB >= $TODAY) {
      $alert = "Date of Birth is invalid";
      $errors = true;
    }

    //Fetches any duplicate email addresses
    $QUERYREAD = "SELECT * FROM acctbl WHERE Email = '$EMAIL'";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);

    if(mysqli_num_rows($SQLREAD) > 0) {
      $alert = "Email is already in use";
      $errors = true;
    }

    //Fetches any duplicate usernames
    $QUERYREAD = "SELECT * FROM acctbl WHERE AccName = '$USERNAME'";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);

    if(mysqli_num_rows($SQLREAD) > 0) {
      $alert = "Username is already in use";
      $errors = true;
    }

    //If no errors have occured the variables are set to the database and session variables
    if($errors == false) {
      $PASSWORD = $PASSWORD;//Hashing here
      $QUERYADD = "INSERT INTO acctbl (AccName, Email, DOB, AccType, Password) VALUES ('$USERNAME', '$EMAIL', '$DOB', '$ACCTYPE', '$PASSWORD')";

      if(mysqli_query($CONNECT, $QUERYADD)) {
        $alert = "Account added!";
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
  <title>Register Account</title>
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
          <pre>Already have an Account?</pre>
          <a href="login" class="link" target="_self">Log In</a><br>
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
      Create an Account:
    </h2>

    <pre>
      <form method= "POST" action = "<?php echo str_replace(".php","",$_SERVER["PHP_SELF"]) ?>"  autocomplete="off">

        Name:               <input type= "text" id= "name" name= "name" required><br>
        Email:              <input type= "text" id= "email" name= "email" required><br>
        Date of Birth:      <input type= "date" id= "dob" name= "dob" min="1900-01-01" max="<?php $d = strtotime("-5 years"); echo date("Y-m-d", $d); ?>" required><br>
        Account Type:       <select id= "acctype" name= "acctype" required>
          <option value= "s">Student</option>
          <option value= "t">Teacher</option>
        </select><br>
        Password:           <input type= "password" id= "password" name= "password" required><br>
        Confirm Password:   <input type= "password" id= "cpassword" name= "cpassword" required><br><br>
        <div class = "button"><input type= "submit" class = "smallbutton" value= "Confirm" name= "confirm"></div>   <div class = "button"><input type= "reset" class = "smallbutton" required></div>

      </form>
    </pre>
      
  </div>
    
    



</body>

</html>

