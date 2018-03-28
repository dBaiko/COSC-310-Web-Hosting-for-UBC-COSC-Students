<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class userUpdater{
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $conn = null;
    private $db = null;
    
    
    public function __construct() {
        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
        if(!$this->conn){
            die('Could not connect: ' .mysqli_error());
        }
        else{
            $this->db = mysqli_select_db($this->conn, $this->db_name);
            if(!$this->db){
                die('Could not connect: ' .mysqli_error());
            }
        }
    }
    
    public function __destruct(){
        $this->conn->close();
        $this->conn = null;
    }
    
    public function updatePassword($userName, $password) {
        $toEcho = null;
        if($this->conn != null){
            $userName = chop($userName);
            $userName = mysqli_real_escape_string($this->conn, $userName);
            
            $salt = date("U");
            $toHash = $password . $salt;
            $dbPass = hash('sha256', $toHash);
            
            $stm = "UPDATE User SET password = ?, salt = ? WHERE userName = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("sss", $dbPass, $salt, $userName);
                if($sql->execute()){
                    $toEcho =  "1";
                }
                else{
                    $toEcho =  "0";
                }
                $sql->close();
            }
            else{
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
            }
            
        }
        else{
            $toEcho = "2";
        }
        return $toEcho;
    }
    
    
    
    public function updateText($userName, $toUpdate, $changeVal) {
        $toEcho = null;
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        $changeVal = mysqli_real_escape_string($this->conn,$changeVal);
        $stm = "UPDATE User SET ".$toUpdate." = ? WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("ss", $changeVal, $userName);
            if($sql->execute()){
                $toEcho = "1";
            }
            else{
                $toEcho =  "0";
            }
            $sql->close();
        }
        else{
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        }
        return $toEcho;
    }
    
    public function updateTextStudent($userName, $toUpdate, $changeVal) {
        $toEcho = null;
        if($toUpdate == "schoolS")
            $toUpdate = "school";
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        $changeVal = mysqli_real_escape_string($this->conn,$changeVal);
        
        
        $stm = "UPDATE Student SET ".$toUpdate." = ? WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("ss", $changeVal, $userName);
            if($sql->execute()){
                $toEcho = "1";
            }
            else{
                $error = $this->conn->errno . ' ' . $this->conn->error;
                $toEcho =  $error;
            }
            $sql->close();
        }
        else{
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        }
        return $toEcho;
    }
    
    public function updateTextProf($userName, $toUpdate, $changeVal) {
        $toEcho = null;
        if($toUpdate == "schoolP")
            $toUpdate = "school";
            $userName = chop($userName);
            $userName = mysqli_real_escape_string($this->conn, $userName);
            $changeVal = mysqli_real_escape_string($this->conn,$changeVal);
            $stm = "UPDATE Professor SET ".$toUpdate." = ? WHERE userName = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("ss", $changeVal, $userName);
                if($sql->execute()){
                    $toEcho =  "1";
                }
                else{
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    $toEcho =  $error;
                }
                $sql->close();
            }
            else{
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
            }
    }
    
    
    
    public function update($userName, $toUpdate, $changeVal) {
        $toEcho = NULL;
        if($toUpdate == "password"){
            $toEcho = $this->updatePassword($userName, $changeVal);
        }
        else if($toUpdate == "studentNum" || $toUpdate == "schoolS" || $toUpdate == "major"){
            $toEcho = $this->updateTextStudent($userName, $toUpdate, $changeVal);
        }
        else if($toUpdate == "faculty" || $toUpdate == "schoolP"){
            $toEcho = $this->updateTextProf($userName, $toUpdate, $changeVal);
        }
        else{
            $toEcho = $this->updateText($userName, $toUpdate, $changeVal);
        }
        return $toEcho;
    }
    
}

if(isset($_SERVER["REQUEST_METHOD"])){
    
    if(isset($_POST['username'])){
        $user = $_POST['username'];
        $toUpdate = $_POST['toUpdate'];
        $changeVal = $_POST['changeVal'];
        $updater = new userUpdater();
        //echo $toUpdate;
        echo $updater->update($user, $toUpdate, $changeVal);
        $updater = null; 
        
    }
    
}