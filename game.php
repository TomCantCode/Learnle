<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width">
  <title>Play!</title>
  <link href="resources/style.css" rel="stylesheet" type="text/css" />
  <link rel="icon" href="images/logo.png" type="image">
</head>
<style>
  body {
    overflow-x: hidden;
  }
</style>

<div class = "menusmall">

    <div class = "menuleft">
      <a href = "home.php">
        <img class = "logo" src = "images/logo.png" height = "40px" width = "40px">
      </a>
      
      <div>Learnle</div>
    </div>
  
    <div class = "menuright">
        <div>
          <?php if(isset($_SESSION["username"])) {
            echo 'Playing as '. $_SESSION["username"];
          }
          ?>
        </div>
    </div>

</div>

<body>
  
  <div id="grid-container">
  </div>
  
  <script src="resources/learnle.js">
    
  </script>



</body>

</html>