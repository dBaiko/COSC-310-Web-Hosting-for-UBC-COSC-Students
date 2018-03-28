<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class passwordChecker{
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    
    private $conn = null;
    private  $db = null;
    
    private $toEcho = "2";
    
    public function __construct() {
        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
        if(!$this->conn){
            die('Could not connect: ' .mysqli_error());
            $this->toEcho = "2";
        }
        else{
            $this->db = mysqli_select_db($this->conn, $this->db_name);
            if(!$this->db){
                die('Could not connect: ' .mysqli_error());
                $this->toEcho = "2";
            }
        }
    }
    
    private function hashPassword($password, $salt){
        $toHash = $password . $salt;
        return hash('sha256', $toHash);
    }
    
    public function checkPass($user, $pass){
        $user = mysqli_real_escape_string($this->conn,$user);
        
        $stm = "SELECT password, salt FROM User WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s", $user);
            $sql->execute();
            $sql->bind_result($dbPass, $dbSalt);
            $sql->fetch();
            
            
            $hashed = $this->hashPassword($pass, $dbSalt);
            
            if($dbPass == $hashed)
                $this->toEcho = "1";
            else
                $this->toEcho = "0";
                    
        }
        else{
            $error = $conn->errno . ' ' . $conn->error;
            $this->toEcho = $error;
        }
        
        mysqli_close($this->conn);
        return $this->toEcho;
    }
    
}

$check = new passwordChecker();
if(isset($_POST["username"])){
    echo $check->checkPass($_POST["username"], $_POST["pass"]);
}



?>