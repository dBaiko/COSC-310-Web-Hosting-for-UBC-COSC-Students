<?php

//in Xampp --> phpunit C:\xampp\htdocs\COSC-310-Web-Hosting-For-UBC-COSC-Students\tests

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/newProjectClass.php';


require_once __DIR__ . '/../php/updateProject.php';

class updateProjectTest extends TestCase{
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $db = null;
    private $conn = null;
    
    protected $project;
    
    protected $updater;
    
    public function __construct() {
        parent::__construct();
        $this->updater = new projectUpdater();
        $this->project = new newProject();
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
    
    protected function selectTestData($id){
        $this->getConnection();
        $stm = "SELECT * FROM Project WHERE projectId = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s",$id);
            if($sql->execute()){
                $pid = $title = $desc =  $url = $date = $type = $logo = $author = null;
                $sql->bind_result($pid,$title,$desc,$url,$date,$type,$logo,$author);
                if($sql->fetch()){
                    $result = array("projectId"=>$pid,"projectTitle"=>$title, "projDesc"=>$desc, "demoUrl"=>$url, "date"=>$date, "projType"=>$type, "logoImage"=>$logo, "author"=>$author);
                    $sql->close();
                    return $result;
                }
                else{
                    return null;
                }
            }
        }else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die($error);
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
    
    public function testSelectTestData(){
        $this->getConnection();
        $user = $author = "dillyjb";
        $n = null;
        $title = "title";
        $desc = "desc";
        $type = "type";
        $link = "link";
        $date = null;
        
        $insertId = $this->project->createNewProject($user, $title, $desc, $type, $link, $n, $n, $n, $n, $n, $date, $author);
        
        $result = $this->selectTestData($insertId);
        
        $this->assertTrue($result['projectId'] == $insertId && $result['projectTitle'] == "title" && $result['projDesc'] == 'desc' && $result['demoUrl'] = "link" && $result['projType'] == "type");
        
        $this->conn->close();
        $this->project = null;
    }
    
    public function testDeleteTestData(){
        $this->getConnection();
        $this->assertTrue($this->deleteTestData($this->getLastId()-1));
        $this->conn->close();
    }
    
    //Tests for updateProject.php
    public function testGetAuthor(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $title = "title";
        $desc = "desc";
        $type = "type";
        $link = "link";
        $date = null;
        $logo = null;
        $insertId = $this->project->createNewProject($user, $title, $desc, $type, $link, $n, $n, $n, $n, $n, $date, $author);
        
        $expected = "dillyjb";
        
        $actual = $this->updater->getAuthor($insertId);
        
        $this->assertEquals($expected,$actual);
        
        $this->deleteTestData($insertId);
        
        $this->conn->close();
    }
    
    public function testBuildContribArray(){
        $this->getConnection();
        
        $contribs = array("Kanu","noman123");
        
        $expected = array("Kanu","noman123");
        $actual = $this->updater->buildOldContribArray($contribs);
        
        $this->assertEquals($expected,$actual);
        
        $this->conn->close();
    }
    
    public function testDeleteProject(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $title = "title";
        $desc = "desc";
        $type = "type";
        $link = "link";
        $date = null;
        $logo = null;
        $insertId = $this->project->createNewProject($user, $title, $desc, $type, $link, $n, $n, $n, $n, $n, $date, $author);
        
        $this->updater->deleteProject($insertId);
        
        $result = $this->selectTestData($insertId);
        
        $this->assertNull($result);
        
        $this->conn->close();
    }
    
}