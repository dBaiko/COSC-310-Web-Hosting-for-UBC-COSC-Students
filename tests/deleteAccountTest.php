<?php

//in Xampp --> phpunit C:\xampp\htdocs\COSC-310-Web-Hosting-For-UBC-COSC-Students\tests

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/newUser.php';


require __DIR__ . '/../php/deleteAccount.php';

class deleteAccountTest extends TestCase{
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $db = null;
    private $conn = null;
    
    protected $project;
    
    protected $deleter;
    
    public function __construct() {
        parent::__construct();
        $this->deleter = new accountDeleter();
        $this->user = new newUser();
    }
    
    protected function getConnection(){
        if($this->conn === null){
            $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
            $this->db = mysqli_select_db($this->conn, $this->db_name);
        }
        return $this->conn;
    }
    
    
    protected function selectTestData($type, $userName) {
        $this->getConnection();
        if($type == "user"){
            $stm = "SELECT username FROM User WHERE username = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$userName);
                if($sql->execute()){
                    $sql->bind_result($u);
                    $sql->fetch();
                    if($u){
                        return $u;
                    }
                    else{
                        return null;
                    }
                    
                }
            }
        }
        else if($type == "prof"){
            $stm = "SELECT username FROM Professor WHERE username = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$userName);
                if($sql->execute()){
                    $sql->bind_result($u);
                    $sql->fetch();
                    if($u){
                        return $u;
                    }
                    else{
                        return null;
                    }
                    
                }
            }
        }
        else if($type == "student"){
            $stm = "SELECT username FROM Student WHERE username = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$userName);
                if($sql->execute()){
                    $sql->bind_result($u);
                    $sql->fetch();
                    if($u){
                        return $u;
                    }
                    else{
                        return null;
                    }
                    
                }
            }
        }
        
    }
    
    protected function deleteTestData($user){
        $deleteUser = false;
        $deleteProfessor = false;
        $deleteStudent = false;
        $this->getConnection();
        
        $stmS = "DELETE FROM Student WHERE userName = ?";
        if($sqlS = $this->conn->prepare($stmS)){
            $sqlS->bind_param("s", $user);
            if($sqlS->execute()){
                $deleteStudent = true;
            }
            $sqlS->close();
            
        }
        
        $stmP = "DELETE FROM Professor WHERE userName = ?";
        if($sqlP = $this->conn->prepare($stmP)){
            $sqlP->bind_param("s", $user);
            if($sqlP->execute()){
                $deleteProfessor = true;
            }
            $sqlP->close();
            
        }
        
        $stmU = "DELETE FROM User WHERE userName = ?";
        if($sqlU = $this->conn->prepare($stmU)){
            $sqlU->bind_param("s", $user);
            if($sqlU->execute()){
                $deleteUser = true;
            }
            $sqlU->close();
            
        }
        
        if($deleteUser == true && $deleteStudent == true && $deleteProfessor == true){
            return true;
        }
        else{
            return false;
        }
    }
    
    
    //Testing Test class methods
    public function testDatabaseConnection(){
        $this->getConnection();
        $this->assertNotNull($this->conn);
        $this->conn->close();
    }
    
    public function testSelectTestData(){
        $this->getConnection();
        
        $expected = "testUserU";
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$n,$n);
        
        $actual = $this->selectTestData("user", "testUserU");
        
        $this->assertEquals($expected,$actual);
        
        
    }
    
    public function testDeleteTestData(){
        $this->getConnection();
        $this->assertTrue($this->deleteTestData("testUserU"));
    }
    
    
    //Tests for deleteAccount.php
    public function testDeleteAccount_Basic(){
        $this->getConnection();
        
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$n,$n);
        
        $this->deleter->deleteAccount($userName);
        
        $result = $this->selectTestData("user", $userName);
        
        $this->assertNull($result);
        
    }
    
    public function testDeleteAccount_Student(){
        $this->getConnection();
        
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$t,$t,$t,$n,$n);
        
        $this->deleter->deleteAccount($userName);
        
        $resultS = $this->selectTestData("student", $userName);
        $resultU = $this->selectTestData("user", $userName);
        
        $this->assertTrue($resultS == null && $resultU == null);
        
    }
    
    public function testDeleteAccount_Prof(){
        $this->getConnection();
        
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$t,$t);
        
        $this->deleter->deleteAccount($userName);
        
        $resultS = $this->selectTestData("student", $userName);
        $resultU = $this->selectTestData("user", $userName);
        
        $this->assertTrue($resultS == null && $resultU == null);
        
        $this->conn->close();
        $this->user = null;
        $this->deleter = null;
        
    }
    
    
    
    

}