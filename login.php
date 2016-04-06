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
  session_unset(); // clear session variables 
  

  $msg = '';  
  $msg2 = '';
  
  //on login
  if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
   $xx=userOk($_POST['username'], $_POST['password']);
   if ($xx==0) 
    {
      $_SESSION['username'] = $_POST['username']; //FIXME
      $_SESSION['dbname'] = "test"; //FIXME            
      header( "Location: index.php" ); //login ok.go to liblary TODO: use correct lib
   }else {
      if ($xx==1) //TODO maybe it'sbetter to uniite for better security
        $msg = '<h3>Wrong username</h3>';
      else
        $msg = '<h3>Wrong password</h3>';
   }
  }

  //on go to galery
  if (isset($_POST['albom']) && !empty($_POST['galery']))
  {
     $_SESSION['dbname'] = $_POST['galery'];      
     header( "Location: index.php" ); //got to view liblary  TODO: use correct lib
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
     <?php echo $msg; ?>
     <input type = "text" name = "username" placeholder = "username" required autofocus></br>
     <input type = "password" name = "password" placeholder = "password" required><br>
     <button type = "submit" name = "login">Login</button>
   </form>  
  </fieldset>  
  </div> 

  <div class="formsField"> 
   <fieldset>
     <legend><h2>I have galery name</h2></legend>   
     <form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
     <?php echo $msg2; ?>
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
