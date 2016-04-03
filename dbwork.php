<?php
require "functions.php";


//---------------------
// checks user/pass
// returns name of userd db for future work
//---------------------

//TODO: deside wht is better to open/close connection in every fnction or 1 common ?

function userOk($name,$pass)
{
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
  if (!hashOk($dbPass,true))
  {
    /* close all */
    $sth->close();
    $conn->close();
    return false;// wrong password
  }  

  /* close all */
  $sth->close();
  $conn->close();

  // user/pass is ok. return the table to work with
  return $table;
}


//----------------------------
//create user
//----------------------------

function addUser($name,$pass,$table)
{
  //common start
  $conn=dbConnect();
  //-------------

  $sql = "INSERT INTO userlist (n, p, d)
  VALUES ('" . hashIt($name) . "', '" . hashIt($pass,true) . "', '" . $table . "')";

  if ($conn->query($sql) === TRUE) {
    $conn->close();
    return true;
  } 
  else 
  {
    echo "Error: " . $sql . "<br>" . $conn->error;
    $conn->close();
    return false;
  }
}


/*for next step
//------------------------
//Key
$key = 'SuperSecretKey';

//To Encrypt:
$encrypted = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $key, 'I want to encrypt this', MCRYPT_MODE_ECB);

//To Decrypt:
$decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $key, $encrypted, MCRYPT_MODE_ECB);

*/
?>
