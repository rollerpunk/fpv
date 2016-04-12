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

  if($_SESSION['del'] = true)//check if it's allowed to delete
  {
   //TODO FIXME uncomment me soon when 'del' to be introduced.// header( "Location: login.php" ); //somethin unclear. do not allow to delete.
  }
  
  
  printMenuP1(); // create common part of top menu

//-----------start-------

  
  printMenuP2(); // common menu finish
  $msg="";
  if (isset($_POST['delete']) && !empty($_POST['username']) && !empty($_POST['password'])) 
  {
    $xx=delUser($_POST['username'], $_POST['password']);  
    if ($xx!=1)
    {
      $msg=$xx;
    }
  }
?>

<div style="display:inline-block">

<div class="delDiv1">
You are going to delete user
</div>

<div class="delDiv1">
  <div class="delUser"> 
    <?php
      if ($msg != "")
         echo "<div class=\"errorDiv\">Error: " . $msg . "</div>"; ?>  
    <form role = "form" action = "<?php htmlspecialchars($_SERVER['PHP_SELF'])?>" method = "post">
      <fieldset>
        <legend>Delete user</legend>  
        <input type = "text\" name = "username" placeholder = "username" required autofocus></br>
        <input type = "password" name = "password" placeholder = "password" required></br>
        <button type = "submit" name = "delete">Delete</button> 
        <button type = "reset" name = "cancel" value="cancel" onClick="window.location=login.php">Cancel</button>
      </fieldset>
    </form>
  </div>

</div>
</div>
</body>
</html>
