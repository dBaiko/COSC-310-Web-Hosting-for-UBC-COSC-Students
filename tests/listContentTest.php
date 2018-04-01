<?php

//in Xampp --> phpunit C:\xampp\htdocs\COSC-310-Web-Hosting-For-UBC-COSC-Students\tests

use PHPUnit\Framework\TestCase;

require_once __DIR__ . '/../php/newProjectClass.php';


require __DIR__ . '/../php/listContentClass.php';

class listContentTest extends TestCase{
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $db = null;
    private $conn = null;
    
    protected $project;
    
    protected $contentGetter;
    
    public function __construct() {
        parent::__construct();
        $this->contentGetter = new listContent();
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
    
    protected function selectTestData(){
        $this->getConnection();
        $stm = "SELECT projectId FROM Project";
        if($sql = $this->conn->prepare($stm)){
            if($sql->execute()){
                $pid  = null;
                $sql->bind_result($pid);
                $result =array();
                while($sql->fetch()){
                    array_push($result, $pid);
                }
                $sql->close();
                return $result;
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
        $t = "test";
        
        $insertId = $this->project->createNewProject($user, $t, $t, $t, $n, $n, $n, $n, $n, $n, $n, $author);
        $includesId = false;
        
        $ids = $this->selectTestData();
        
        foreach ($ids as $id){
            if($id == $insertId)
                $includesId = true;
        }
        
        $this->assertTrue($includesId);
        $this->conn->close();
        $this->project = null;
    }
    
    public function testDeleteTestData(){
        $this->getConnection();
        $this->assertTrue($this->deleteTestData($this->getLastId()-1));
        $this->conn->close();
    }
    
    //Testing class methods
    public function testQueryAll(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $t = "test";
        
        $insertId = $this->project->createNewProject($user, $t, $t, $t, $n, $n, $n, $n, $n, $n, $n, $author);
        $includesId = false;
        
        
        $actualResult = $this->contentGetter->query_all();
        while($row = mysqli_fetch_array($actualResult)){
            if($row['projectId'] == $insertId)
                $includesId = true;
        }
        
        $this->assertTrue($includesId);
        $this->deleteTestData($insertId);
        $this->conn->close();
        
        
    }
    
    public function testSortedQueryTypes_Basic(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $t = "test";
        $type = "Games";
        
        $insertId = $this->project->createNewProject($user, $t, $t, $type, $n, $n, $n, $n, $n, $n, $n, $author);
        $includesId = false;
        
        
        
        $actualResult = $this->contentGetter->sortedQuery_types($type);
        while($row = mysqli_fetch_array($actualResult)){
            if($row['projectId'] == $insertId)
                $includesId = true;
        }
        
        $this->assertTrue($includesId);
        $this->deleteTestData($insertId);
        $this->conn->close();
        
        
    }
    
    public function testSortedQueryTypes_EmptyStringForType(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $t = "test";
        $type = "";
        
        $insertId = $this->project->createNewProject($user, $t, $t, $type, $n, $n, $n, $n, $n, $n, $n, $author);
        $includesId = false;
        
        
        
        $actualResult = $this->contentGetter->sortedQuery_types($type);
        while($row = mysqli_fetch_array($actualResult)){
            if($row['projectId'] == $insertId)
                $includesId = true;
        }
        
        $this->assertFalse($includesId);
        $this->deleteTestData($insertId);
        $this->conn->close();
        
        
    }
    
    public function testSortedQueryTypes_NullForType(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $t = "test";
        $type = "";
        
        $insertId = $this->project->createNewProject($user, $t, $t, $type, $n, $n, $n, $n, $n, $n, $n, $author);
        $includesId = false;
        
        
        
        $actualResult = $this->contentGetter->sortedQuery_types($type);
        while($row = mysqli_fetch_array($actualResult)){
            if($row['projectId'] == $insertId)
                $includesId = true;
        }
        
        $this->assertFalse($includesId);
        $this->deleteTestData($insertId);
        $this->conn->close();
        
        
    }
    
    public function testSortedQueryTypes_TypeNotSame(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $t = "test";
        $type = "Games";
        
        $insertId = $this->project->createNewProject($user, $t, $t, $type, $n, $n, $n, $n, $n, $n, $n, $author);
        $includesId = false;
        
        
        
        $actualResult = $this->contentGetter->sortedQuery_types("Data Science");
        while($row = mysqli_fetch_array($actualResult)){
            if($row['projectId'] == $insertId)
                $includesId = true;
        }
        
        $this->assertFalse($includesId);
        $this->deleteTestData($insertId);
        $this->conn->close();
        
        
    }
    
    public function testSortedQuerySearch_Basic(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $t = "test";
        $search = "TEST";
        
        $insertId = $this->project->createNewProject($user, $search, $t, $t, $n, $n, $n, $n, $n, $n, $n, $author);
        $includesId = false;
        
        
        
        $actualResult = $this->contentGetter->sortedQuery_search($search);
        while($row = mysqli_fetch_array($actualResult)){
            if($row['projectId'] == $insertId)
                $includesId = true;
        }
        
        $this->assertTrue($includesId);
        $this->deleteTestData($insertId);
        $this->conn->close();
        
        
    }
    
    public function testSortedQuerySearch_OneCharacter(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $t = "test";
        $search = "TEST";
        
        $insertId = $this->project->createNewProject($user, $search, $t, $t, $n, $n, $n, $n, $n, $n, $n, $author);
        $includesId = false;
        
        $actualResult = $this->contentGetter->sortedQuery_search("t");
        while($row = mysqli_fetch_array($actualResult)){
            if($row['projectId'] == $insertId)
                $includesId = true;
        }
        
        $this->assertTrue($includesId);
        $this->deleteTestData($insertId);
        $this->conn->close();
        
        
    }
    
    
    public function testSortedQuerySearch_MoreCharacters(){
        $this->getConnection();
        
        $user = $author = "dillyjb";
        $n = null;
        $t = "test";
        $search = "TEST";
        
        $insertId = $this->project->createNewProject($user, $search, $t, $t, $n, $n, $n, $n, $n, $n, $n, $author);
        $includesId = false;
        
        $actualResult = $this->contentGetter->sortedQuery_search("TEST_EXTRA_CHARS");
        while($row = mysqli_fetch_array($actualResult)){
            if($row['projectId'] == $insertId)
                $includesId = true;
        }
        
        $this->assertFalse($includesId);
        $this->deleteTestData($insertId);
        $this->conn->close();
        
        
    }
    
    
    
    
}