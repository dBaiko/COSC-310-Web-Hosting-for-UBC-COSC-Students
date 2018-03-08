<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION["user"];
if($_SERVER['REQUEST_METHOD'] == 'POST'){
   echo $username;
   $title =  $_POST["title"];
   echo "<br>" . $title;
   $desc =  $_POST["description"];
   echo "<br>" . $desc;
   $contributors = array();
   if($_POST['contributor'] != null){
       foreach($_POST['contributor'] as $index => $value) {
           $contributors[] = $value;
       }
       foreach ($contributors as $x => $value){
           echo "<br>Value= " . $value;
       }
   }
   
   
   $picsFileNames = NULL;
   $pdfsFileNames = NULL;
   $picFileTypes = NULL;
   $pdfsFileTypes = NULL;
   $pdfFiles = NULL;
   $picFiles = NULL;
   
   if($_FILES['pics']['name'] != null){
       $picsFileNames = array();
       $picFileTypes = array();
       $picFiles = array();
       foreach ($_FILES['pics']['name'] as $x => $value){
           $picsFileNames[] = $value;
           $tmp = substr($value, strrpos($value, "."));
           $picFileTypes[] = substr($tmp, 1);
       }
       
       array_pop($picFileTypes);
       array_pop($picsFileNames);
       foreach ($_FILES["pics"]["tmp_name"] as $x => $value){
           if($value != null){
               $content = file_get_contents($value);
               $picFiles[] = $content;
           }
       }
   }
   
   if($_FILES['pdfs']['name'] != null){
       $pdfsFileNames = array();
       $pdfsFileTypes = array();
       $pdfFiles = array();
       foreach ($_FILES['pdfs']['name'] as $i => $value){
           $pdfsFileNames[] = $value;
           $tmp = substr($value, strrpos($value, "."));
           $pdfsFileTypes[] = substr($tmp, 1);
       }
       
       array_pop($pdfsFileNames);
       array_pop($pdfsFileTypes);
       foreach ($_FILES["pdfs"]["tmp_name"] as $x => $value){
           if($value != null){
               $content = file_get_contents($value);
               $picFiles[] = $content;
           }
       }
   }
   
   foreach ($picsFileNames as $x => $value){
       echo "<br>Value= " . $value;
   }
   
   foreach ($picFileTypes as $x => $value){
       echo "<br>Value= " . $value;
   }
   
   foreach ($pdfsFileNames as $x => $value){
       echo "<br>Value= " . $value;
   }
   
   foreach ($pdfsFileTypes as $x => $value){
       echo "<br>Value= " . $value;
   }
   
   
   
   
   
   
   
   
   
   
   
 
}