<?php
//------------------------------------------
// show settings menu
//------------------------------------------
function showSettings()
{ 

}
//-----------------------------------------
//hide settings menu
//-----------------------------------------
function hideSettings()
{}
?>

<!DOCTYPE html>
<html>
<head>
<title>allIView</title>
<link rel="icon" href="albom.png" type="image/x-icon">
<link rel="stylesheet" href="albom.css">
</head>
<body>
<div>
 <div class="formsField"> 
   <fieldset>
     <legend><h2>Login here</h2></legend>   
     <form role = "form" action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>" method = "post">
     <?php 
       if ($msg != "")
         echo "<div class=\"errorDiv\">Error: " . $msg . "</div>"; ?>
     <input type = "text" name = "username" placeholder = "username" required autofocus></br>
     <input type = "password" name = "password" placeholder = "password" required><br>
     <button type = "submit" name = "login">Login</button>
   </form>  
  </fieldset>  
  </div> 
</div>


</body>
</html>
