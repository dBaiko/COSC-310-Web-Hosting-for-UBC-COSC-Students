<?php

use PHPUnit\Framework\TestCase;

require __DIR__ . '/../php/newUser.php';

class newUserTest extends TestCase{
    
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $db = null;
    private $conn = null;
    
    protected $newUserBuilder;

    public function __construct() {
        parent::__construct();
        $this->newUserBuilder = new newUser();
    }
    
    protected function getConnection(){
        if($this->conn === null){
            $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
            $this->db = mysqli_select_db($this->conn, $this->db_name);
        }
        return $this->conn;
    }
    
    protected function insertTestData(){
        $this->getConnection();
        $stm = "INSERT INTO User VALUES (?,?,?,?,?,?)";
        if($sql = $this->conn->prepare($stm)){
            $userName = "testUserU";
            $t = "test";
            $sql->bind_param("ssssss", $userName, $t, $t, $t, $t, $t);
            if($sql->execute()){
                return true;
            }
            else{
                return false;
            }
        } else {
            return false;
        }
        return false;
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
    
    protected function selectTestData($type) {
        $this->getConnection();
        if($type == "user"){
            $stm = "SELECT username FROM User WHERE username = 'testUserU'";
            if($sql = $this->conn->prepare($stm)){
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
            $stm = "SELECT username FROM Professor WHERE username = 'testUserU'";
            if($sql = $this->conn->prepare($stm)){
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
            $stm = "SELECT username FROM Student WHERE username = 'testUserU'";
            if($sql = $this->conn->prepare($stm)){
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
    
    //Testing Test class methods
    public function testDatabaseConnection(){
        $this->getConnection();
        $this->assertNotNull($this->conn);
    }
    
    public function testInsertTestData(){
        $this->getConnection();
        $this->assertTrue($this->insertTestData());
    }
    
    public function testSelectTestData() {
        $this->getConnection();
        $this->assertNotNull($this->selectTestData("user"));
    }
    
    public function testDeleteTestData(){
        $this->getConnection();
        $this->assertTrue($this->deleteTestData("testUserU"));
    }
    
    //Testing newUser.php methods
    public function testCreateNewBasicUser(){
        $this->getConnection();
        $expected = "testUserU";
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->newUserBuilder->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$n,$n);
        $actual = $this->selectTestData("user");
        $this->assertEquals($expected, $actual);
        $this->deleteTestData("testUserU");
    }
    
    public function testCreateNewStudentUser(){
        $this->getConnection();
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->newUserBuilder->createNewUser($userName,$t,$t,$e,$t,$t,$t,$t,$t,$n,$n);
        $userInserted = false;
        if($this->selectTestData("user") != null){
            $userInserted = true;
        }
        $studentInserted = false;
        if($this->selectTestData("student") != null){
            $studentInserted = true;
        }
        $this->assertTrue($userInserted && $studentInserted);
        $this->deleteTestData("testUserU");
    }
    
    public function testCreateNewProfessorUser(){
        $this->getConnection();
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->newUserBuilder->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$t,$t);
        $userInserted = false;
        if($this->selectTestData("user") != null){
            $userInserted = true;
        }
        $profInserted = false;
        if($this->selectTestData("prof") != null){
            $profInserted = true;
        }
        $this->assertTrue($userInserted && $profInserted);
        $this->deleteTestData("testUserU");
    }
    
    public function testCreateNewUserNullValues() {
        $this->getConnection();
        $n = null;
        $this->newUserBuilder->createNewUser($n,$n,$n,$n,$n,$n,$n,$n,$n,$n,$n);
        $returned = $this->selectTestData("user");
        $this->assertNull($returned);
        $this->deleteTestData("testUserU");
    }
    
    public function testCreateNewUserUnmatchingPasswords(){
        $this->getConnection();
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $p1 = "password";
        $p2 = "notthesamepassword";
        $n = null;
        $this->newUserBuilder->createNewUser($userName,$t,$t,$e,$p1,$p2,$n,$n,$n,$n,$n);
        $actual = $this->selectTestData("user");
        $this->assertNull($actual);
        $this->deleteTestData("testUserU");
    }
    
    public function testCreateNewUserBadEmail(){
        $this->getConnection();
        $userName = "testUserU";
        $t = "test";
        $e = "notAnEmail";
        $n = null;
        $this->newUserBuilder->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$n,$n);
        $actual = $this->selectTestData("user");
        $this->assertNull($actual);
        $this->deleteTestData("testUserU");
    }
    
}