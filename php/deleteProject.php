<?php
class projectDeleter{
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
    
    public function deleteProject($projectId){
        $stm = "DELETE FROM Files WHERE projectId = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s",$projectId);
            if($sql->execute()){
                $sql->close();
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die( $error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die( $error);
        }
        
        $stm = "DELETE FROM Published WHERE projectId = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s",$projectId);
            if($sql->execute()){
                $sql->close();
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die( $error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die( $error);
        }
        
        $stm = "DELETE FROM Project WHERE projectId = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s",$projectId);
            if($sql->execute()){
                $sql->close();
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die( $error);
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die( $error);
        }
        
    }
}


error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if(isset($_SERVER["REQUEST_METHOD"])){
    $id = $_POST['delId'];
    $deleter = new projectDeleter();
    $deleter->deleteProject($id);
    $deleter = null;
    ?>
    <meta http-equiv="refresh" content="0; URL='../Browse.php'" /> 
    <?php
}