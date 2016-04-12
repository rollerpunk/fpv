<?php


//---------------------
// checks user/pass
// returns name of userd db for future work
//---------------------

function userOk($name,$pass)
{
//TODO:  
// hide encription data into DB
// data shoulby encripted/decripted by "original" password as key


  //common start
  $conn=dbConnect();

  //-------------

  /* create a prepared statement */
  
  $sth = $conn->stmt_init();
  if (!$sth->prepare('
    SELECT
      p,d
    FROM userlist
    WHERE u =?'))
  {
     print "Failed to prepare statement\n";
     print "Errorcode: %d\n" . $conn->error;
     return;
  }

  $xx=hashIt($name);
  $sth->bind_param('s',$xx);
  $sth->execute();
  
  /* bind result variables */
  $sth->bind_result($dbPass,$table);

  /* fetch values */
  if (!$sth->fetch()) // only 1 result possible,no loop needed
  {
    /* close all */
    $sth->close();
    $conn->close();
    return false; //no such user  
  }
  //check pass
  if (!hashOk($dbPass,$pass,true))
  {
    /* close all */
    $sth->close();
    $conn->close();
    return false;// wrong password
  }  

  /* close all */
  $sth->close();
  $conn->close();

  $_SESSION['username'] = $name; // if name is known then it's allowed to edit alboms
  $_SESSION['dbname'] = $table; //  

  return true;
  
}



//----------------------------
//common function to open/close db and send sql request
//----------------------------
function sendSql($sql)
{
  $conn=dbConnect();
  $result = $conn->query($sql);
  if (!$result)
  {
    if ($conn->errno != 1146 )
    {
      echo "<div class=\"footer errorDiv\"><br><b>sql</b># ".$conn->errno.":<br>" . $sql . "<br><b>Error:</b><br>" . $conn->error . "<br></div>"; //TODO make normal error handler
      return false;
    }
 }
  $conn->close();
  return  $result;
}



//----------------------------
//create user
//----------------------------
function addUser($name,$pass,$table)
{
  //doublesure that we have usertable
  initialTable();
  

  //check user
  $sql = "SELECT u from userlist where u = '". hashIt($name) ."'";
  $result = sendSql($sql);
  if($result->num_rows > 0)
  {
      // row exists. do whatever you would like to do.
      return "Username <b>$name</b> already occupied";
  }
  
  
  //check table  
  if(galeryOk($table))
  {
    return "Gallery name <b>$table</b> already occupied";
  }
  
  //try to create ftp-table first
  $sql= "
  CREATE TABLE  IF NOT EXISTS " . $table . " (
  `a` binary(200) NOT NULL,
  `u` binary(200) NOT NULL,
  `p` binary(200) NOT NULL,
  `k` text NOT NULL,
  `m` tinyint(1) NOT NULL,
  PRIMARY KEY (`a`)
)";

  if (!sendSql($sql))
  {
    return false;
  }

  $sql = "INSERT INTO userlist (u, p, d)
  VALUES ('" . hashIt($name) . "', '" . hashIt($pass,true) . "', '" . $table . "')";
  
  if (!sendSql($sql))
  {
    return false;
  }

  $_SESSION['username'] = $name; // if name is known then it's allowed to edit alboms
  $_SESSION['dbname'] = $table; //  
}

//--------------------------------
// add ftp information for user
//--------------------------------
function addFtp($add,$uname,$pass)
{

  $key = createKey();  

  $table=$_SESSION['dbname'];
  //echo "<div> address: ".$add."<br>user: " . $uname ."(". encript($key,$add) . ")<br>pass: " . $pass ."(". encript($key,$pass) . ")<br>table: " . $table . "(". encript($key,$table) . ")<br>key:". $key ."<hr></div>";
  $a=base64_encode(encript($key,$add));
  $u=base64_encode(encript($key,$uname));
  $p=base64_encode(encript($key,$pass));
  $k=base64_encode($key);
  $sql = "INSERT INTO ". $table ."(a, u, p ,k ,m)
  VALUES ('$a','$u','$p' ,'$k' , 1)";

  $res =sendSql($sql); 
  if (!$res)
  {
    return false;
  }  
  
 
  
  
  
  
  /*/--------------check what was written
  //00000000000000000000000000000000000000
   echo "a=".$a."<br>u=".$u."<br>p=".$p;
  echo "<br>add ftp:<br>". $sql;
  
   $sql = "SELECT * from " . $table;  // TODO: add latter . " where m = 1";
  $result = sendSql($sql);

  if (get_class($result)!= "mysqli_result")
  {
    //error. put it to error div
    echo $result;
    return NULL;
  }
  
  if ($result->num_rows > 0) 
  {
    $row = $result->fetch_assoc();
    $key=$row["k"];
    $ftp_server = decript($row["a"],$key);
    $ftp_user_name = decript($row["u"],$key);
    $ftp_user_pass = decript($row["p"],$key);
     echo "<div class=\"errorDiv\">WTF  <div class=\"settings\">key: <b>". $key ."</b><br>to64<br>". base64_encode($key);
     echo "<br>from64<br>".base64_decode($key);
     echo "</b><br>add: " . $ftp_server; 
     echo "<br>Name: " .  $ftp_user_name. "<br>Pass: " . $ftp_user_pass . "<br></div></div>"; // TODO: add more details soon

  } 
  else 
  {
    echo "result->num_rows =".$result->num_rows ;
    return NULL;
  }
  
  */
  
  return true;
}


//----------------------
//creates ftp-settings form
//------------------------
function ftpConfigmenu()
{
  echo  '<div>
      <fieldset>
      <legend>FTP configuration</legend>  
      <input type = "text" name = "ftpName" placeholder = "FTP full address or name" required autofocus></br>
      <input type = "text" name = "ftpUser" placeholder = "FTP username" required></br>
      <input type = "password" name = "ftpPass" placeholder = "FTP password" required></br>
      <span>ADD OTHER FTP</span><br>
      <span>(BACKUP or MULTISOURSE)</span><br>
      <a href="#">I don\'t have FTP</a>
      </fieldset>
      </div>';
}


//---------------------
//delete user
//---------------------
function delUser($name,$pass)
{
  if (userOk($name,$pass))
  {
  
    //TODO  double check if delete user
    
    
    $table=$_SESSION['dbname']; //  set by userOk

    //delete table/galery
    if (galeryOk($table))
    {
      $sql="DROP TABLE ".$table; 
      $res =sendSql($sql); 
      if (!$res)
      {
	return $res; //something wrong . strange
      } 
    } 
    //no table here.continue
     
    //delete user
    $conn=dbConnect();

    /* create a prepared statement */  
    $sth = $conn->stmt_init();       
    if (!$sth->prepare('DELETE FROM userlist WHERE u=?'))
    {
      return "Fail<br>Error: %s" . $conn->error;
    }

    $xx=hashIt($name);
    $sth->bind_param('s',$xx);
    if (!$sth->execute())
    {
      return "Fail<br>Error: %s" . $conn->error;
    }

    /* close all */
    $sth->close();
    $conn->close();

    header( "Location: msg.php?msg='User <b>".$name."</b> was deleted" ); //notify and go to login
  }
  else
  {  
    return "User <b>".$name."</b> was not deleted" ; 
  }

}

//------------------
// checks if given correct gallery name
//-----------------

function galeryOk($table)
{
  //check table
  if(sendSql("DESCRIBE `$table`")) {
     return true;
  }
  return false;   
}


?>
