<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="albom.ico" type="image/x-icon">
<link rel="stylesheet" href="albom.css">
</head>
<body>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



  require "dbwork.php";
  session_start(); // Start the session.must be after class defenitin
  printMenuP1(); // create common part of top menu

//-----------start-------

  printMenuP2(); // common menu finish
   
  $msg = '';  
  if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
   if (userOk($_POST['username'], $_POST['password'])) 
    {
      $_SESSION['username'] = $_POST['username'];      
      header( "Location: index.php" ); //start over
   }else {
      $msg = '<h1>Wrong username or password</h1>';
   }
  }
?>  
  <div class="forms"> 
   <h2>Enter Username and Password</h2>  
   <form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
    <?php echo $msg; ?>
    <input type = "text" name = "username" placeholder = "username" required autofocus></br>
    <input type = "password" name = "password" placeholder = "password" required>
    <br><button type = "submit" name = "login">Login</button>
   </form>    
  </div> 

<?php
//---------end----------
  createSettings();
?>
</body>
</html>
