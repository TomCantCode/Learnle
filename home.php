
<?php
  session_start();
  $_SESSION["destination"] = null;

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

<style>
  body {
    overflow-x: hidden;
  }
</style>

<div class = "menu">

    <div class = "menuleft">
      <a href = "home">
        <img class = "logo" src = "images/logo.png" height = "60px" width = "60px">
      </a>
      
      <div>Learnle</div>
    </div>

    <div class = "menumiddle">
      <input type = "search" placeholder = "Search for a set" class = "searchbar">
    </div>
  
    <div class = "menuright">
        <div>

          <?php 
          
          //Sets displayed profile image, either a teacher or student, depending on users account type
          if(isset($_SESSION["username"])) {
            if(($_SESSION["type"]) == 't') {
              $image = 'teacher';
            }
            else {
              $image = 'student';
            }

            //Sets right menu depending whether user is signed in
            echo 
            '<div class = "dropdown">
              <button class = "dropbutton"><img class = "icon" src = "images/' . $image . '.png" height = "64px" width = "64px"></button>
                <div class = "droplist">
                  <pre>' . $_SESSION["username"] . '</pre>
                  <a href="personal-library" class="link" target="_self">Personal Library</a><br>
                  <a href="resources/logout" class="link" target="_self">Logout</a><br>
                </div>
            </div>';
          }
          else {
            echo '<a href="login" class="link" target="_self">Login</a><br>
                  <a href="register" class="link" target="_self">Register</a><br>';
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
     <br>image<br>
     <a href = "game" class = "link" action = "set()" id = "example-game" target = "_self">Play example game</a>
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
     <br>image<br>
     <a href = "creator" class = "link" target = "_self">Set Creator</a>

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

  
  <script src = "resources/general.js"></script>

</body>

<?php
  include 'resources/footer';
?>
  
</html>