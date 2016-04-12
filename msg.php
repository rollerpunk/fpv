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

$adr="login.php";

if(isset($_GET["dist"]))
{
  $adr= $_GET["dist"];
}

header('Refresh: 10; URL='.$adr);

  ?>

<a href="<?php echo $adr;?>">
<div style="display:inline-block">
  <div class="formsField"> 
   <fieldset>
    <?php echo $_GET["msg"]?>   
   </fieldset>  
  </div>
</div>
</a>
</body>
</html>
