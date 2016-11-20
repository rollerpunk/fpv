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


  set_time_limit(0);  //disable watchog
  require "classes.php";
  session_start(); // Start the session.must be after class defenitin


  printMenuP1(); // create common part of top menu
  $conn_id=getFtp();  //connect to ftp TODO dbname must be set to get data fro ftp

  if (!isset($_SESSION['alboms'])) { //check if needed data present in session
    header( "Location: index.php" ); //start over
  }

//-----------start-------
//TODO it should be possible to have direct link to view
  $location=$_GET["loc"];  // get album location 
  $alboms = $_SESSION["alboms"];

  echo "<div class=\"albLoc\"><a href=\"index.php\">Home</a> -> ". $alboms[$location]->albomName . "</div>"; // link to album list
  printMenuP2(); // common menu finish

  // print albums
  $alboms[$location]->ftp_id = $conn_id; //ftp_id is lost during sessions
  $alboms[$location]->printAlbom();

//---------end----------
  ftp_close($conn_id); // close ftp

?>
</body>
</html>
