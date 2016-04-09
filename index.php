<!DOCTYPE html>
<html>
<head>
<title>allIView</title>
<link rel="icon" href="albom.ico" type="image/x-icon">
<link rel="stylesheet" href="albom.css">
<script src="functions.js" type="text/javascript"> </script>
</head>
<body>
<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



 // set_time_limit(0);  //dizable watchog to enable picture proccessing
  require "classes.php";
  session_start(); // Start the session.must be after class defenition

  if(isset($_GET["galery"])) // check if it was direct link
  {
    $_SESSION["dbname"]=$_GET["galery"]; //TODO:   give good name as it would be visible
  }

  if(!isset($_SESSION["dbname"]))// check if galery name is know.it may go from login or from link
  {
    header( "Location: login.php" ); //not enought info to continue. go to login
  }

  printMenuP1(); // create common part of top menu

  $conn_id=getFtp();  //connect to ftp

//-----------start---------
  
  printMenuP2();
 

  
  echo "<div class=\"albomField\">";
  scanDirs($conn_id,"/"); // create albums according to ftp file tree
  $_SESSION["alboms"] = $GLOBALS['alboms'];
  // TODO: sort albums 
  printAlbums();  //list all albums
  echo "</div>";

  createSettings();
//-------------end--------------
  ftp_close($conn_id);
?>
</body>




</html>



