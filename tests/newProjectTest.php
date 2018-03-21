<?php

//in Xampp --> phpunit C:\xampp\htdocs\COSC-310-Web-Hosting-For-UBC-COSC-Students\tests

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
        $stm = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'cswebhosting' AND   TABLE_NAME   = 'Project'";
        if($sql = $this->conn->prepare($stm)){
            $sql->execute();
            $sql->bind_result($u);
            $sql->fetch();
            $sql->close();
            return $u;
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
    
    protected function selectTestData($type, $id) {
        $this->getConnection();
        $id = strval($id);
        if($type == "project"){
            $stm = "SELECT projectId FROM Project WHERE projectId = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$id);
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
        else if($type == "published"){
            $stm = "SELECT projectId FROM Published WHERE projectId = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$id);
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
        else if($type == "files"){
            $stm = "SELECT projectId FROM Files WHERE projectId = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$id);
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
        $this->conn->close();
    }
    
    public function testGetLastId(){
        $this->getConnection();
        $expected = "";
        $stm = "SELECT `AUTO_INCREMENT` FROM  INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = 'cswebhosting' AND   TABLE_NAME   = 'Project'";
        if($sql = $this->conn->prepare($stm)){
            $sql->execute();
            $sql->bind_result($u);
            $sql->fetch();
            $sql->close();
            $expected = $u;
        }
        $actual = $this->getLastId();
        $this->assertEquals($expected, $actual);
        $this->conn->close();
    }
    
    public function testInsertTestData(){
        $this->getConnection();
        $this->assertNotNull($this->insertTestData());
        $this->conn->close();
    }
    
    public function testSelectTestData(){
        $this->getConnection();
        $expected = $this->getLastId()-1;
        $actual = $this->selectTestData("project",$this->getLastId()-1);
        $this->assertEquals($expected, $actual);
        $this->conn->close();
    }
    
    public function testDeleteTestData(){
        $this->getConnection();
        $this->assertTrue($this->deleteTestData($this->getLastId()-1));
        $this->conn->close();
    }
    
    public function testInsertNewProjectBasic(){
        $this->getConnection();
        $id = $this->getLastId();
        $id = (int)$id;
        $expected = $id;
        
        $user = "dillyjb";
        $t = "test";
        $n = null;
        
        $this->newProjectCreator->createNewProject($user, $t, $t, $t, $n, $n, $n, $n, $n);
        
        $proj = false;
        $pub = false;
        if($this->selectTestData("published", $id) == $expected){
            $pub = true;
        }
        if($this->selectTestData("project", $id) == $expected){
            $proj = true;
        }
        $this->deleteTestData($id);
        $this->assertTrue($proj && $pub);
        $this->conn->close();
        $this->newProjectCreator = null;
    }
    
    
    
}