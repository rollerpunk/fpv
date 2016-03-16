<!DOCTYPE html>
<html>
<head>
<link rel="icon" href="albom.ico" type="image/x-icon">
<link rel="stylesheet" href="albom.css">
</head>
<body>
123
<?php


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);



 // set_time_limit(0);  //dizable watchog to enable picture proccessing
  require "classes.php";
//      session_destroy();
  session_start(); // Start the session.must be after class defenitin
echo "gergg";
  printMenuP1(); // create common part of top menu
  $conn_id=getFtp();  //connect to ftp
//-----------start---------
  
  printMenuP2();
  session_unset(); // clear session variables
  echo "<div class=\"albomField\">";
  scanDirs($conn_id,"/"); // create albums according to ftp file tree
  $_SESSION["alboms"] = $GLOBALS['alboms'];
  // TODO: sort albums 
  printAlbums();  //list all albums
  echo "</div>";

  
//-------------end--------------
  ftp_close($conn_id);
?>
</body>
</html>



