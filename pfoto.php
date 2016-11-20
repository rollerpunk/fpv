<!DOCTYPE html>
<html>
<head>
<title>allIView</title>
<link rel="icon" href="albom.ico" type="image/x-icon">
<link rel="stylesheet" href="albom.css">
</head>
<script type="text/javascript">

document.onkeydown = function(e) {
    switch(e.which) {
        case 37: // left
        window.location = document.getElementById("prev").getAttribute("href");  
        break;

        case 38: // up
        break;

        case 39: // right
        window.location = document.getElementById("next").getAttribute("href"); 
        break;

        case 40: // down
        break;

        default: return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
};
</script>
<body>


<?php

//TODO:
// 1) add slideshow
// 2) add photo details
// 3) fit foto to window/div

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

  set_time_limit(0);  //disable watchogz

  require "classes.php";
  session_start(); // Start the session

  $conn_id=getFtp();  //connect to ftp
  printMenuP1(); // create common part of top menu


//-----------start-------
  $location=$_GET["loc"];  // get photo location 
  $alboms = $_SESSION["alboms"];
  
  $al= substr($location,0,strpos($location,":")); //get albom id
  $pic= substr($location,strpos($location,":")+1);//get pic

  echo "<div class=\"albLoc\"><a href=\"index.php\">Home</a> : "; // link to album list 
  echo " <a href=\"album.php?loc=" . $al . "\">" . $_SESSION["alboms"][$al]->albomName . "</a>"; //link to album
  echo " : <b>" . $pic . "</b></div>"; //photo name

  printMenuP2(); // common menu finish
 

//print foto
  $alboms[$al]->ftp_id = $conn_id; //ftp_id is lost during sessions
  $albom = $_SESSION["alboms"][$al]->printFoto();

//---------end----------
  ftp_close($conn_id); // close ftp
?>

</body>
</html>
