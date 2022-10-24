
<?php
  session_start();

?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Homepage</title>
  <link href="resources/style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="images/logo.png" type="image">
</head>

<div class = "menu">

    <div class = "menuleft">
      <a href = "home.php">
        <img class = "logo" src = "images/logo.png" height = "60px" width = "60px">
      </a>
      
      <div>Learnle</div>
    </div>

    <div class = "menumiddle">
      <input type = "search" placeholder = "Search for a set" class = "searchbar">
    </div>
  
    <div class = "menuright">
        <div>
          <?php if(isset($_SESSION["username"])) {
            echo '<pre> Welcome '. $_SESSION["username"] . '</pre>
            <a href="resources/logout.php" target="_self">Logout</a><br>';
          }
          else {
            echo '<a href="login.php" target="_self">Login</a><br>
          <a href="register.php" target="_self">Register</a><br>';
          }
          
          ?>
        </div>
    </div>

</div>

<body>
  
  <div class = "groupboard">
    
    <div class = "homeboard">
     <h2>Welcome</h2>
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sapien neque, varius quis convallis id,
        ullamcorper id ante. Morbi aliquet pharetra enim vitae gravida. Etiam venenatis placerat enim quis
        feugiat. Vestibulum eget auctor ante. Etiam sit amet sem tortor. Donec sit amet dolor ac eros
        condimentum pharetra. Quisque lacinia diam at urna imperdiet lobortis. Quisque dignissim nulla
        sapien, eget tristique ipsum viverra non. Vestibulum eleifend, libero tincidunt imperdiet sodales,
        risus neque molestie metus, a tempus purus nisi ut neque. Morbi ullamcorper iaculis convallis. Sed
        vitae massa efficitur nulla porta euismod sit amet a odio. Maecenas commodo justo sit amet ex
        commodo rhoncus.</p>
     <br>image
    </div>

    <div class = "homeboard">
     <h2>Make Set</h2>
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sapien neque, varius quis convallis id,
        ullamcorper id ante. Morbi aliquet pharetra enim vitae gravida. Etiam venenatis placerat enim quis
        feugiat. Vestibulum eget auctor ante. Etiam sit amet sem tortor. Donec sit amet dolor ac eros
        condimentum pharetra. Quisque lacinia diam at urna imperdiet lobortis. Quisque dignissim nulla
        sapien, eget tristique ipsum viverra non. Vestibulum eleifend, libero tincidunt imperdiet sodales,
        risus neque molestie metus, a tempus purus nisi ut neque. Morbi ullamcorper iaculis convallis. Sed
        vitae massa efficitur nulla porta euismod sit amet a odio. Maecenas commodo justo sit amet ex
        commodo rhoncus.</p>
     <br>image
    </div>

    <div class = "homeboard">
     <h2>Join Others</h2>
     <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis sapien neque, varius quis convallis id,
        ullamcorper id ante. Morbi aliquet pharetra enim vitae gravida. Etiam venenatis placerat enim quis
        feugiat. Vestibulum eget auctor ante. Etiam sit amet sem tortor. Donec sit amet dolor ac eros
        condimentum pharetra. Quisque lacinia diam at urna imperdiet lobortis. Quisque dignissim nulla
        sapien, eget tristique ipsum viverra non. Vestibulum eleifend, libero tincidunt imperdiet sodales,
        risus neque molestie metus, a tempus purus nisi ut neque. Morbi ullamcorper iaculis convallis. Sed
        vitae massa efficitur nulla porta euismod sit amet a odio. Maecenas commodo justo sit amet ex
        commodo rhoncus.</p>
     <br>image
    </div>
    
  </div>

  
</body>

<?php
  include 'footer.php';
?>
  
</html>