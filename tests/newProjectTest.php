<?php

use PHPUnit\Framework\TestCase;

require __DIR__ . '/../php/newProject.php';

class newProjectTest extends TestCase{
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $db = null;
    private $conn = null;
    
    protected $newProjectCreator;
   
    public function __construct() {
        parent::__construct();
        $this->newProjectCreator = new newProject();
    }
    
    protected function getConnection(){
        if($this->conn === null){
            $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
            $this->db = mysqli_select_db($this->conn, $this->db_name);
        }
        return $this->conn;
    }
    
    protected function getLastId(){
        $stm = "SELECT projectId FROM Project ORDER BY projectId DESC LIMIT 1";
        if($sql = $this->conn->prepare($stm)){
            if($sql->execute()){
                $sql->bind_result($id);
                $sql->fetch();
                return $id;
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }
    
    protected function insertTestData(){
        $this->getConnection();
        $stm = "INSERT INTO Project (projectTitle, projDesc, projType) VALUES (?,?,?)";
        if($sql = $this->conn->prepare($stm)){
            $title = "testProj";
            $desc = "testDesc";
            $type = "testType";
            $sql->bind_param("sss", $title,$desc,$type);
            if($sql->execute()){
                $id = mysqli_insert_id($this->conn);
                return $id;
            }
            else{
                return null;
            }
        }
        else{
            return null;
        }
    }
    
    protected function selectTestData($type) {
        $this->getConnection();
        if($type == "project"){
            $stm = "SELECT projectId FROM User WHERE username = 'testUserU'";
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
    
    protected function deleteTestData($id){
        $deleteProject = false;
        $deletePublished = false;
        $deleteFiles = false;
        $this->getConnection();
        
        $stmS = "DELETE FROM Files WHERE projectId = ?";
        if($sqlS = $this->conn->prepare($stmS)){
            $sqlS->bind_param("s", $id);
            if($sqlS->execute()){
                $deleteFiles = true;
            }
            $sqlS->close();
            
        }
        
        $stmP = "DELETE FROM Published WHERE projectId = ?";
        if($sqlP = $this->conn->prepare($stmP)){
            $sqlP->bind_param("s", $id);
            if($sqlP->execute()){
                $deletePublished = true;
            }
            $sqlP->close();
            
        }
        
        $stmU = "DELETE FROM Project WHERE projectId = ?";
        if($sqlU = $this->conn->prepare($stmU)){
            $sqlU->bind_param("s", $id);
            if($sqlU->execute()){
                $deleteProject = true;
            }
            $sqlU->close();
            
        }
        
        if($deletePublished == true && $deleteFiles == true && $deleteProject == true){
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
    }
    
    public function testGetLastId(){
        $this->getConnection();
        $expected = "35";
        $actual = $this->getLastId();
        $this->assertEquals($expected, $actual);
    }
    
    public function testInsertTestData(){
        $this->getConnection();
        $this->assertNotNull($this->insertTestData());
    }
    
    public function testDeleteTestData(){
        $this->getConnection();
        $this->assertTrue($this->deleteTestData("36"));
    }
    
    
    
}