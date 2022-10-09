<?php
  //includes connection to the database
  include 'database-connection.php';

  $CONNECT;

  session_start();
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Register Account</title>
  <link href="style.css" rel="stylesheet" type="text/css" />
</head>

<header>
  <h1>
    Learnle
  </h1>
</header>

<h2>
  Create an Account:
</h2>

<body>

  <?php
    echo 'Hello'
  ?>

  <div id = "board">
    <pre>
      <form method="post">
      Name:               <input type="text" id="name" name="name"><br>
      E-mail:             <input type="text" id="email" name="email"><br>
      Date of Birth:      <input type="date" id="dob" name="dob"><br>
      Account Type:       <select id="acctype" name="acctype">
        <option value="student">Student</option>
        <option value="teacher">Teacher</option>
      </select><br>
      Password:           <input type="password" id="password" name="password"><br>
      Confirm Password:   <input type="password" id="cpassword" name="cpassword"><br><br>
      <input type="submit" value="Confirm">   <input type="reset">
    </form>
  </pre>
      
  </div>
    
    



</body>

</html>

