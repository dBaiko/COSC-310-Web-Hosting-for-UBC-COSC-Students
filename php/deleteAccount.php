<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

class accountDeleter{
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
    
    public function isStudent($userName){
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        
        $stm = "SELECT userName FROM Student WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s",$userName);
            if($sql->execute()){
                $sql->bind_result($u);
                if($sql->fetch()){
                    $sql->close();
                    return true;
                }
                else{
                    return false;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
    }
    
    public function isProf($userName){
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        
        $stm = "SELECT userName FROM Professor WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s",$userName);
            if($sql->execute()){
                $sql->bind_result($u);
                if($sql->fetch()){
                    $sql->close();
                    return true;
                }
                else{
                    return false;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
    }
    
    public function getAllProjectIds($userName){//returns an array of projectIds for all projects for which user is a contributor, or null if none
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        
        
        $stm = "SELECT projectId FROM Published WHERE userName= ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s",$userName);
            if($sql->execute()){
                $sql->bind_result($id);
                $toReturn = array();
                while($sql->fetch()){
                    array_push($toReturn, $id);
                }
                $sql->close();
                if(sizeof($toReturn) > 0){
                    return $toReturn;
                }
                else{
                    return null;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
        
    }
    
    public function onlyContributor($id){//returns true if a project only has one contributor, false otherwise
        $id = intval($id);
        
        $stm = "SELECT COUNT(userName) FROM Published WHERE projectId = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("i",$id);
            if($sql->execute()){
                $sql->bind_result($count);
                if($sql->fetch()){
                    if($count == "1"){
                        $sql->close();
                        return true;
                    }
                    else{
                        $sql->close();
                        return false;
                    }
                }
                else{
                    $sql->close();
                    return false;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
            $sql->close();
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
        
    }
    
    public function deleteFromFiles($id){
        $id = intval($id);
        
        $stm = "DELETE FROM Files WHERE projectId = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("i", $id);
            if($sql->execute()){
                $sql->close();
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
        
    }
    
    public function deleteFromPublished($userName){
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        
        $stm = "DELETE FROM Published WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s", $userName);
            if($sql->execute()){
                $sql->close();
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
        
    }
    
    public function deleteFromProject($id){
        $id = intval($id);
        
        $stm = "DELETE FROM Project WHERE projectId = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("i", $id);
            if($sql->execute()){
                $sql->close();
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
        
    }
    
    public function deleteFromStudent($userName){
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        
        $stm = "DELETE FROM Student WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s", $userName);
            if($sql->execute()){
                $sql->close();
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
        
    }
    
    public function deleteFromProf($userName){
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        
        $stm = "DELETE FROM Prof WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s", $userName);
            if($sql->execute()){
                $sql->close();
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
        
    }
    
    public function deleteFromUser($userName){
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        
        $stm = "DELETE FROM User WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s", $userName);
            if($sql->execute()){
                $sql->close();
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die($error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
        }
        
    }
    
    
    public function deleteAccount($userName){
        $userName = chop($userName);
        $userName = mysqli_real_escape_string($this->conn, $userName);
        
        if($this->isStudent($userName)){
            $projects  = $this->getAllProjectIds($userName);
            if($projects != null){
                foreach ($projects as $id){
                    if($this->onlyContributor($id)){
                        $this->deleteFromFiles($id);
                        $this->deleteFromPublished($userName);
                        $this->deleteFromProject($id);
                    }
                    else{
                      $this->deleteFromPublished($userName);  
                    }
                }
            }
            $this->deleteFromStudent($userName);
        }
        else if($this->isProf($userName)){
            $this->deleteFromProf($userName);
        }
        $this->deleteFromUser($userName);
        return true;
    }
    
}


if(isset($_SERVER["REQUEST_METHOD"])){
    
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $deleter = new accountDeleter();
        if($deleter->deleteAccount($user)){
            unset($_SESSION['user']);
            $deleter = null;
            ?>
            <meta http-equiv="refresh" content="0; URL='../index.php'"/>
            <?php
        }
        else{
            $deleter = null;
            ?>
            <meta http-equiv="refresh" content="0; URL='../yourAccount.php'"/>
            <?php
        }
        
        
    }
    
}

