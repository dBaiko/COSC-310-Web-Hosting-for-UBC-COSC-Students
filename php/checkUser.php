<?php
class userNameChecker{
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
    
    public function checkUser($user){ 
        $user = mysqli_real_escape_string($this->conn,$user);
        $e = "";
        $s = "SELECT userName FROM User WHERE userName = ?";
        if($stm = $this->conn->prepare($s)){
            $stm->bind_param("s", $user);
            $stm->execute();
            $stm->bind_result($u);
            
            $stm->fetch();
            
            if(!$u){
                $e = "0";
            }
            else{
                $e = "1";
            }
        }
        else{
            $error = $conn->errno . ' ' . $conn->error;
            $e = $error;
        }
        mysqli_close($this->conn);
        return $e;
    }
    
}

$check = new userNameChecker();
if(isset($_POST['username'])){
    echo $check->checkUser($_POST['username']);
}







?>