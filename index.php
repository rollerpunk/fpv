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
    $_SESSION["dbname"]=$_GET["gallery"]; //TODO:   give good name as it would be visible
  }

  if(!galeryOk($_SESSION["dbname"]))// check if galery name is know.it may go from login or from link
  {
    header( "Location: msg.php?msg=Gallery <b>".$name."</b> was not found" ); //notify and go to login
  }


  
  printMenuP1(); // create common part of top menu

  $conn_id=getFtp();  //connect to ftp

  if ($conn_id==false)
  {  //TODO redirect to settings ??
     header( "Location: msg.php?msg=Problem with FTP connection" ); //notify and go to login
  }
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



