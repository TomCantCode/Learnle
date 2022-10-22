<?php
  //includes connection to the database
  include "database-connection.php";

  $CONNECT;

  session_start();

  if(isset($_POST["confirm"])) {
    $USERNAME = $_POST["name"];
    $EMAIL = $_POST["email"];
    $DOB = $_POST["dob"];
    $ACCTYPE = $_POST["acctype"];
    $PASSWORD = $_POST["password"];
    $CPASSWORD = $_POST["cpassword"];

    $errors = false;

    if($PASSWORD != $CPASSWORD) {
      $output = "Passwords do not match";
      $errors = true;
    }

    $QUERYREAD = "SELECT * FROM acctbl WHERE Email = '$EMAIL'";
    $SQLREAD = mysqli_query($CONNECT, $QUERYREAD);

    if(mysqli_num_rows($SQLREAD) > 0) {
      $output = "Email is already in use";
      $errors = true;
    }

    if($errors == false) {
      $PASSWORD = $PASSWORD;//Hashing here
      $QUERYADD = "INSERT INTO acctbl (AccName, Email, DOB, AccType, Password) VALUES ('$USERNAME', '$EMAIL', '$DOB', '$ACCTYPE', '$PASSWORD')";

      if(mysqli_query($CONNECT, $QUERYADD)) {
        $output = "Account added!";
      }
    }

  }
  
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Register Account</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<?php
  include 'menu-small.php';
?>


<body>

  <div class = "largeboard">
    
    <h2>
      Create an Account:
    </h2>

    <pre>
      <form method= "POST" action = "<?php echo $_SERVER["PHP_SELF"] ?>">

        Name:               <input type= "text" id= "name" name= "name"><br>
        E-mail:             <input type= "text" id= "email" name= "email"><br>
        Date of Birth:      <input type= "date" id= "dob" name= "dob"><br>
        Account Type:       <select id= "acctype" name= "acctype">
          <option value= "s">Student</option>
          <option value= "t">Teacher</option>
        </select><br>
        Password:           <input type= "password" id= "password" name= "password"><br>
        Confirm Password:   <input type= "password" id= "cpassword" name= "cpassword"><br><br>
        <input type= "submit" value= "Confirm" name= "confirm">   <input type= "reset">

        <div class="output" id="output"><?php if(isset($output)) {echo $output;} ?></div>
      </form>
    </pre>
      
  </div>
    
    



</body>

</html>

