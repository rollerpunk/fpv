<!DOCTYPE html>
<html>
<head>
<title>allIView</title>
<link rel="icon" href="albom.png" type="image/x-icon">
<link rel="stylesheet" href="albom.css">
</head>
<body>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



  require "functions.php";
  session_start(); // Start the session.must be after class defenitin
  session_unset(); // clear session variables 
  cleanCookie(); // clear all cookies
  printMenuP1(); // create common part of top menu

//-----------start-------

  
  printMenuP2(); // common menu finish
  
  

  $msg = '';  
  $msg2 = '';
  
  //on login
  if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
   $xx=userOk($_POST['username'], $_POST['password']);
   if ($xx) 
   {          
      header( "Location: index.php" ); //login ok.go to liblary TODO: use correct lib
   }else {
      $msg = 'Wrong username or password';
   }
  }

  //on go to galery
  if (isset($_POST['albom']) && !empty($_POST['galery']))
  {
     $_SESSION['dbname'] = $_POST['galery'];
     if (!galeryOk($_SESSION['dbname']))
     {
	$msg2="No such gallery: <b>".$_SESSION['dbname']."</b>";
     }
     else
     {
       header( "Location: index.php" );
     }
  }
?>  


<div>
  <div class="entranceHeading">
  <h1>Please choose what do you want to do<h1>
  </div>
  <div class="formsField"> 
   <fieldset>
     <legend><h2>Login here</h2></legend>   
     <form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
     <?php 
       if ($msg != "")
         echo "<div class=\"errorDiv\">Error: " . $msg . "</div>"; ?>
     <input type = "text" name = "username" placeholder = "username" required autofocus></br>
     <input type = "password" name = "password" placeholder = "password" required><br>
     <button type = "submit" name = "login">Login</button>
   </form>  
  </fieldset>  
  </div> 

  <div class="formsField"> 
   <fieldset>
     <legend><h2>I have gallery name</h2></legend>   
     <form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
      <?php 
       if ($msg2 != "")
         echo "<div class=\"errorDiv\">Error: " . $msg2 . "</div>"; ?>
     <input type = "text" name = "galery" placeholder = "galery name" required autofocus></br>
     <button type = "submit" name = "albom">View the galery</button>
   </form>  
    </fieldset>  
  </div> 

  <div class="formsField"> 
   <fieldset>
     <legend><h2>I want to register</h2></legend> 
     <a href="new.php"> New User </a>
    </fieldset>  
  </div>
</div>


<?php
//---------end----------
  createSettings();
?>
</body>
</html>
