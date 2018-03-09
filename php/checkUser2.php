<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
define('DB_NAME', 'cswebhosting');
define('DB_USER', 'cswebhosting');
define('DB_PASSWORD', 'a9zEkajA');
define('DB_HOST', 'localhost');

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD);

if(!$link){
    die('Could not connect: ' .mysqli_error());
    echo "2";
}
else{
    $db = mysqli_select_db($link, DB_NAME);
    
    if(!$db){
        die('Could not connect: ' .mysqli_connect_error());
        echo "2";
    }
    else{
        $username = $_POST["username"];
        $username = mysqli_real_escape_string($link,$username);
        
        $s = "SELECT userName FROM Student WHERE userName = ?";
        if($stm = $link->prepare($s)){
            $stm->bind_param("s", $username);
            $stm->execute();
            $stm->bind_result($u);
            
            $stm->fetch();
            
            if(!$u){
                echo "0";
            }
            else{
                echo "1";
            }
        }
        else{
            $error = $link->errno . ' ' . $link->error;
            echo $error;
        }
        
        
        mysqli_close($link);
    }
}





?>