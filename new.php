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
  if (isset($_POST['login'])) 
  {  
    if ($_POST['password']== $_POST['password2'] )
    {
      if (addUser($_POST['username'],$_POST['password'],$_POST['dbname']))
      {
        header( "Location: index.php" ); //got to liblary  
        //TODO: 
        //use correct lib
        //also get login-information
      }
    }
    else    
    {
      $msg = '<h1>Passwords do not match</h1>';
    }    
  }
?>  
  <div class="formsField"> 
   <fieldset>
     <legend><h2>Register new user</h2></legend>
     
   <form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
    <?php echo $msg; ?>
    <input type = "text" name = "username" placeholder = "username" required autofocus></br>
    <input type = "password" name = "password" placeholder = "password" required></br>
    <input type = "password" name = "password2" placeholder = "repeat password" required></br>
    <input type = "text" name = "dbname" placeholder = "galery name" required ></br><br>
    <button type = "submit" name = "login">Register</button> 
    <button type = "submit" name = "cancel" value="cancel" onClick="window.location='login.php';">Cancel</button>

    <br>
    </form>  
   </fieldset>  
  </div> 

<?php
//---------end----------
  createSettings();
?>
</body>
</html>
