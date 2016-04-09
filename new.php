<!DOCTYPE html>
<html>
<head>
<title>allIView</title>
<link rel="icon" href="albom.ico" type="image/x-icon">
<link rel="stylesheet" href="albom.css">
</head>
<body>
<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  require "functions.php";
  session_start(); // Start the session.must be after class defenitin
  printMenuP1(); // create common part of top menu

//-----------start-------

  printMenuP2(); // common menu finish
  ?>

<?php
  $msg = '';  
  if (isset($_POST['login'])) 
  {  
    if (!empty($_POST['username']) 
        && !empty($_POST['password'])
        && !empty($_POST['dbname'])
        && !empty($_POST['ftpName'])
        && !empty($_POST['ftpUser'])
        && !empty($_POST['ftpPass'])
   ){
      if ($_POST['password']== $_POST['password2'] )
      {
        $xx= addUser($_POST['username'],$_POST['password'],$_POST['dbname']);
        if ($xx != true )
        {
          if(addFtp($_POST['ftpName'],$_POST['ftpUser'],$_POST['ftpPass'])==true)
          {
            header( "Location: index.php" ); //got to liblary
          }
          else //problem with ftp
          {
            //TODO:redirect to settings to fix ftp problem
            $msg = '<h3>Problem with FTP</h3>';
          }  
        }
        else
        {//some problem with user creation
          $msg=$xx;
        }
      }
      else    
      {
        $msg = '<h3>Passwords do not match</h3>';
      }
    }
    else
    {
      $msg = '<h3>Please fill all fields</h3>';
    }    
  }
?>


  <div class="formsField"> 
   <fieldset>
     <legend><h2>Register new user</h2></legend>
     
   <form role = "form" action = "<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method = "post">

    <?php
      if ($msg != "")
         echo "<div class=\"errorDiv\">Error: " . $msg . "</div>"; ?>

    <div style="display:inline-block">
      <fieldset>
      <legend>User configuration</legend>  
      <input type = "text" name = "username" placeholder = "username" required autofocus></br>
      <input type = "password" name = "password" placeholder = "password" required></br>
      <input type = "password" name = "password2" placeholder = "repeat password" required></br>
      <input type = "text" name = "dbname" placeholder = "galery name" required >
      </fieldset>
    </div><div style="display:inline-block; vertical-align:top;">   
    <?php ftpConfigmenu(); ?>
    </div></br><br>
    <button type = "submit" name = "login">Register</button> 
    <button type = "reset" name = "cancel" value="cancel" onClick="window.location='login.php'">Cancel</button>
    
    <br>
    </form>  
   </fieldset>  
  </div>

</body>
</html>
