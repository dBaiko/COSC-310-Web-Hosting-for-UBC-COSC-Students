<?php

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/checkPass.php';
//require '../vendor/autoload.php';

class checkPassTest extends TestCase
{
    
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $db = null;
    private $conn = null;
    
    protected $passChecker;
    
    
    
    public function __construct() {
        parent::__construct();
        $this->passChecker = new passwordChecker();
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
            $userName = "testUserP";
            $t = "test";
            $testPass = "test123";
            $testSalt = "12345";
            $toHash = $testPass . $testSalt;
            $hashed = hash('sha256', $toHash);
            $sql->bind_param("ssssss", $userName, $t, $t, $t, $hashed, $testSalt);
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
    
    protected function deleteTestData(){
        $this->getConnection();
        $stm = "DELETE FROM User WHERE userName = ?";
        if($sql = $this->conn->prepare($stm)){
            $userName = "testUserP";
            $sql->bind_param("s", $userName);
            if($sql->execute()){
                return true;
            }
            else{
                return false;
            }
        }
        else{
            return false;
        }
        return false;
    }
    
    public function testDatabaseConnection(){
        $this->getConnection();
        $this->assertNotNull($this->conn);
    }
    public function testInsertTestData(){
        $this->getConnection();
        $this->assertTrue($this->insertTestData());
    }
    public function testCheckUser(){
        $this->getConnection();
        $this->insertTestData();
        $actual = $this->passChecker->checkPass("testUserP","test123");
        $expected = "1";
        $this->assertEquals($expected, $actual);
    }
    public function testDeleteTestData(){
        $this->getConnection();
        $this->assertTrue($this->deleteTestData());
    }
    
}
