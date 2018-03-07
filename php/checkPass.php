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
    echo "";
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
        
        $stm = "SELECT password, salt FROM User WHERE userName = ?";
        if($sql = $link->prepare($stm)){
            $sql->bind_param("s", $username);
            $sql->execute();
            $result = mysqli_stmt_get_result($sql);
            
            $row = mysqli_fetch_array($result);
            
            $dbPass = $row['password'];
            $dbSalt = $row['salt'];
            
            $pass = $_POST["pass"];
            
            $toHash = $pass . $dbSalt;
            
            $hashed = hash('sha256', $toHash);
            
            if($dbPass == $hashed)
                echo "1";
            else
                echo "0";
            
        }
        else{
            $error = $conn->errno . ' ' . $conn->error;
            echo $error;
        }
        
        
        mysqli_close($link);
    }
}





?>