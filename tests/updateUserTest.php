<?php

//in Xampp --> phpunit C:\xampp\htdocs\COSC-310-Web-Hosting-For-UBC-COSC-Students\tests

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/newUser.php';


require __DIR__ . '/../php/updateUser.php';

class updateUserTest extends TestCase{
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $db = null;
    private $conn = null;
    
    protected $user;
    
    protected $updater;
    
    public function __construct() {
        parent::__construct();
        $this->updater = new userUpdater();
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
            $stm = "SELECT username, firstName, lastName, email FROM User WHERE username = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$userName);
                if($sql->execute()){
                    $u = $f = $l = $e = null;
                    $sql->bind_result($u,$f,$l,$e);
                    $sql->fetch();
                    $result = array("userName"=>$u, "firstName"=>$f, "lastName"=>$l, "email"=>$e);
                    return $result;
                }
            }
        }
        else if($type == "prof"){
            $stm = "SELECT username, faculty, school FROM Professor WHERE username = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$userName);
                if($sql->execute()){
                    $u = $f = $s = null;
                    $sql->bind_result($u,$f,$s);
                    $sql->fetch();
                    $result = array("userName"=>$u,"faculty"=>$f, "school"=>$s);
                    return $result;                    
                }
            }
        }
        else if($type == "student"){
            $stm = "SELECT username, studentNum, school, major FROM Student WHERE username = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$userName);
                if($sql->execute()){
                    $u = $sn = $s = $m = null;
                    $sql->bind_result($u,$sn,$s,$m);
                    $sql->fetch();
                    $result = array("userName"=>$u, "studentNum"=>$sn, "school"=>$s, "major"=>$m);
                    return $result;
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
    
    //Testing test class methods
    public function testDatabaseConnection(){
        $this->getConnection();
        $this->assertNotNull($this->conn);
        $this->conn->close();
    }
    
    public function testSelectTestData(){
        $this->getConnection();
        
        $expected = array("userName"=>"testUserU", "firstName"=>"test", "lastName"=>"test", "email"=>"test@test.com");
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
    
    //Testing updateUser.php
    public function testUpdateText_FirstName(){
        $this->getConnection();
        
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$n,$n);
        
        $expected = "NAME";
        
        $this->updater->updateText($userName, "firstName", "NAME");
        
        $actual = $this->selectTestData("user", $userName)['firstName'];
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($userName);
        $this->conn->close();
        
    }
    
    public function testUpdateText_LastName(){
        $this->getConnection();
        
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$n,$n);
        
        $expected = "NAME";
        
        $this->updater->updateText($userName, "lastName", "NAME");
        
        $actual = $this->selectTestData("user", $userName)['lastName'];
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($userName);
        $this->conn->close();
        
    }
    
    public function testUpdateText_Email(){
        $this->getConnection();
        
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$n,$n);
        
        $expected = "email@email.com";
        
        $this->updater->updateText($userName, "email", "email@email.com");
        
        $actual = $this->selectTestData("user", $userName)['email'];
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($userName);
        $this->conn->close();
        
    }
    
    public function testUpdateTextStudent_StudentNum(){
        $this->getConnection();
        
        $userName = "testUserU";
        $studentNum = "12345678";
        $school = "school";
        $major = "major";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$studentNum,$studentNum,$major,$n,$n);
        
        $expected = "87654321";
        
        $this->updater->updateTextStudent($userName, "studentNum", "87654321");
        
        $actual = $this->selectTestData("student", $userName)['studentNum'];
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($userName);
        $this->conn->close();
        
    }
    
    public function testUpdateTextStudent_School(){
        $this->getConnection();
        
        $userName = "testUserU";
        $studentNum = "12345678";
        $school = "school";
        $major = "major";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$studentNum,$studentNum,$major,$n,$n);
        
        $expected = "NEWSCHOOL";
        
        $this->updater->updateTextStudent($userName, "school", "NEWSCHOOL");
        
        $actual = $this->selectTestData("student", $userName)['school'];
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($userName);
        $this->conn->close();
        
    }
    
    public function testUpdateTextStudent_Major(){
        $this->getConnection();
        
        $userName = "testUserU";
        $studentNum = "12345678";
        $school = "school";
        $major = "major";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$studentNum,$studentNum,$major,$n,$n);
        
        $expected = "NEWMAJOR";
        
        $this->updater->updateTextStudent($userName, "major", "NEWMAJOR");
        
        $actual = $this->selectTestData("student", $userName)['major'];
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($userName);
        $this->conn->close();
        
    }
    
    public function testUpdateTextProf_Faculty(){
        $this->getConnection();
        
        $userName = "testUserU";
        $faculty = "COSC";
        $school = "school";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$school,$faculty);
        
        $expected = "NEWFACULTY";
        
        $this->updater->updateTextProf($userName, "faculty", "NEWFACULTY");
        
        $actual = $this->selectTestData("prof", $userName)['faculty'];
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($userName);
        $this->conn->close();
        
    }
    
    public function testUpdateTextProf_School(){
        $this->getConnection();
        
        $userName = "testUserU";
        $faculty = "COSC";
        $school = "school";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$school,$faculty);
        
        $expected = "NEWSCHOOL";
        
        $this->updater->updateTextProf($userName, "school", "NEWSCHOOL");
        
        $actual = $this->selectTestData("prof", $userName)['school'];
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($userName);
        $this->conn->close();
        
    }
    
    public function testUpdate(){
        $this->getConnection();
        
        $userName = "testUserU";
        $t = "test";
        $e = "test@test.com";
        $n = null;
        $this->user->createNewUser($userName,$t,$t,$e,$t,$t,$n,$n,$n,$n,$n);
        
        $expected = "NAME";
        
        $this->updater->update($userName, "firstName", "NAME");
        
        $actual = $this->selectTestData("user", $userName)['firstName'];
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($userName);
        $this->conn->close();
        $this->updater = null;
        $this->user = null;
        
    }
    
}