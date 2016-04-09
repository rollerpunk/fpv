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
  
   if (isset($_POST['delete']) && !empty($_POST['username']) && !empty($_POST['password'])) {
     $xx=delUser($_POST['username'], $_POST['password']);
   if ($xx) 
   {          
      header( "Location: index.php" ); //user deleted
   }else {
      $msg = 'Wrong username or password';
   }
  }
?>

  <div class="delUser centered\"> <form role = \"form\" action = \" " . htmlspecialchars($_SERVER['PHP_SELF'] ."  \" method = \"post\">
      <fieldset>
        <legend>Delete user</legend>  
        <input type = \"text\" name = \"username\" placeholder = \"username\" required autofocus></br>
        <input type = \"password\" name = \"password\" placeholder = \"password\" required></br>
        <button type = \"submit\" name = \"delete\">Delete</button> 
        <button type = \"reset\" name = \"cancel\" value=\"cancel\" onClick=\"window.location='login.php'\">Cancel</button>  
      </fieldset>";  
      
      
      echo "</div>"; //TODO do normal cancel--just to hide menu
}
