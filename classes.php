<?php
require 'functions.php'; //include common functions

class Albom {
  var $location;
  var $albomName;
  var $contents;
  var $ftp_id;
  var $titleImg;

  function __construct($ftplocation,$ftp_id,$titleImg=1){
     $this->ftp_id = $ftp_id;
     $this->location = $ftplocation; //full ftp dir
     $this->contents = ftp_nlist($ftp_id, $this->location);
     $this->albomName=$ftplocation; //TODO: change to something good
     $this->titleImgNo=$titleImg;
    
     //remove non images from contents
     $this->removeNonPic(); 
     
   } 

//-----------------------------------
// print album title
//-----------------------------------

  function printTitle($x)
  {
    $local_file = $GLOBALS['local_file'];
    $server_file = $this->contents[$this->titleImgNo];

   // echo "<div class=\"albTitle\"><a href=\"album.php?loc=" . $this->location ."\">";     //link to albom

    echo "<a href=\"album.php?loc=" . $x ." \"><div class=\"albTitle\">";     //link to albom

    echo "<div class=\"albName\">" . $this->albomName . "</div>";
    echo "<img title=\"". $this->albomName ."\"src=\"";    
// we are looking for images only  
    if ($this->isExtentionOk($server_file) != false)
    {
      // try to download $server_file and save to $local_file
      if (ftp_get($this->ftp_id, $local_file, $server_file, FTP_BINARY))
      {        
        echo scaleImg($local_file) . "\">";                
      }
      else
      { //ftp error put msg and default img
        echo "\"><h1>FTP ERROR</h1>\nNot possible to get img:" . $server_file;  

      }     
    }
    else     
      echo "data:image/png;base64,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\">"; 
    echo "</div></a>\n";   
  }

//-----------------------------------
// print all images in album
//-----------------------------------
  function printAlbom(){

    $local_file = $GLOBALS['local_file'];
    
    echo "<div class=\"albomField\">";   

    for ($i = 0 ; $i < count($this->contents) ; $i++)
    {
      try{
      $server_file = $this->contents[$i];
      }
      catch (Exception $e) {
        continue; // not supported format,skip it
      }

      // we are looking for images only  
      if ($this->isExtentionOk($server_file) != false)
      {
        // try to download $server_file and save to $local_file
        if (ftp_get($this->ftp_id, $local_file, $server_file, FTP_BINARY))
        { 
          echo "<a href=\"pfoto.php?loc=" . $_GET["loc"] . ":" . $i ."\"><div class=\"albPhoto\">";          
          echo "<img src=\"" . scaleImg($local_file) . "\" title=\"". $server_file ."\"></div></a>\n";      
        }
        else
        {
          echo "<h1>FTP ERROR</h1>\nNot possible to get img:" . $server_file;   //TODO: common error log       
        }
     
      }      
    }
    echo "</div>";
    }



//-------------------------------------
//prints particular photo
//-------------------------------------
  function printFoto(){
    $local_file = $GLOBALS['local_file'];

    $id = substr($_GET["loc"],strpos($_GET["loc"],":")+1);
    $alb = substr($_GET["loc"],0,strpos($_GET["loc"],":"));
    $prev = $id-1;
    $next = $id+1;
    
    if ($id == 0) $prev = count($this->contents)-1;
    if ($id == count($this->contents)-1) $next = 0;
    
    echo "<div class=\"albomField\"><div class=\"navi prev\"><a id=\"prev\" href=\"pfoto.php?loc=" . $alb . ":" .$prev . "\" accesskey=\"z\"> < </a></div>"; //previous

    echo "<div class=\"pic\">";
    if (ftp_get($this->ftp_id, $local_file, $this->contents[$id], FTP_BINARY))
    {    
      echo "<img src=\"". scaleImg($local_file,800) ."\">";  // the picture
    }
    echo"</div>";

   echo "<div class=\"navi next\"><a id=\"next\" href=\"pfoto.php?loc=" . $alb . ":" . $next . "\" accesskey=\"x\"> ></a></div></div>";   //next one
  
  }
//--------------------------------------
// remove not supported files
//--------------------------------------
  function removeNonPic(){
    for ($i = count($this->contents)-1 ; $i >=0  ; $i--) //go backward to remove elemets in 1 pass
    {
    //  echo "" . $this->contents[$i] . "<br>";
      if ($this->isExtentionOk($this->contents[$i])== FALSE) 
      {                     
        $this->contents = delArrayElem($this->contents,$i);  // delete element
        if ($i==$this->titleImgNo)
        {
          $this->titleImgNo+=1;  //update cover img
        }
                
      }
    }    
    if (count($this->contents)==0) 
    { // folder should not be displayed.
      throw new Exception('No supported formats inside album');
    }
  }

//--------------------------------------
// checks if we can work with format
//--------------------------------------
//TODO: 
//1)add gip, png ,etc
//2)add video
//3)add support for dizables


  function isExtentionOk($file) 
  {
    if (strpos(strtolower($file) , '.jpg') != false) // TODO: add more formats soon
    {
      return true;
    }
// TODO: add some msg place : + we do not support this extention yet
    return FALSE;
  }



//class end
}



?>
