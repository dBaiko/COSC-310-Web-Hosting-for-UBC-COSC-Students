<?php
class projectUpdater{
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
    
    public function buildOldContribArray($contribs){
        $oldContribs = array();
        foreach ($contribs as $x => $value) {
            if($value != "")
                array_push($oldContribs, $value);
        }
        return $oldContribs;
    }
    
    public function joinContributors($oldContribs, $newContribs){
        return array_merge($oldContribs,$newContribs);
    }
    
    public function buildOldFileArrays($files, $projectId){
        $oldFiles = array();
        foreach ($files as $x => $fileName){
            $stm = "SELECT fileName, file FROM Files WHERE fileName = ? AND projectId = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("ss",$fileName,$projectId);
                if($sql->execute()){
                    $sql->bind_result($n,$f);
                    if($sql->fetch()){
                        $fileRow = array('name'=>$n, 'tmp_name'=>$f);
                        array_push($oldFiles, $fileRow);
                        $sql->close();
                    }
                }else {
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    die( $error);
                }
            } else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                die( $error);
            }
        }
        return $oldFiles;
    }
    
    public function joinFileArrays($oldFiles,$newFiles){
        return array_merge($oldFiles,$newFiles);
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
    require 'newProjectClass.php';
    
    $id = $_POST['projectId'];
    $user = $_SESSION['user'];
    
    $updater = new projectUpdater();
    $newProjectCreator = new newProject();
    
    $newContribs = array();
    if(isset($_POST['contributor'])){
        $newContribs = $_POST['contributor'];
    }
    
    $allContributors = null;
    if(isset($_POST['oldContribs'])){
        $oldContribs = $updater->buildOldContribArray($_POST['oldContribs']);
        $allContributors =  $updater->joinContributors($oldContribs, $newContribs);
    }
    else{
        $allContributors = $newContribs;
    }
    
    $allFiles = null;
    
    $newPdfFiles = array();
    if($_FILES['pdfs'] != null){
        $newPdfFiles = $_FILES['pdfs'];
    }
    
    $newPicFiles = array();
    if($_FILES['pics'] != null){
        $newPdfFiles = $_FILES['pics'];
    }
    
    $newFiles = array_merge($newPdfFiles, $newPicFiles);
    
    if(isset($_POST['hiddenFileNames'])){
        $oldFiles = $updater->buildOldFileArrays($_POST['hiddenFileNames'], $id);
        $allFiles = $updater->joinFileArrays($oldFiles, $newFiles);
    }
    else{
        $allFiles = $newFiles;
    }
    
    $updater->deleteProject($id);
    
    $newProjectCreator->setUserName($user);
    
    if(isset($_POST["title"])){
        $newProjectCreator->setTitle($_POST["title"]);
    }
    
    if(isset($_POST["description"])){
        $newProjectCreator->setDesc($_POST["description"]);
    }
    
    if(isset($_POST["link"])){
        $newProjectCreator->setLink($_POST["link"]);
    }
    
    if(isset($_POST["projType"])){
        $newProjectCreator->setType($_POST["projType"]);
    }
    
    $newProjectCreator->buildContribArray($allContributors);
    
    $newProjectCreator->buildFileArrays($allFiles);
    
    if(isset($_FILES['pdfs'])){
        $newProjectCreator->buildFileArrays($_FILES['pdfs']);
    }
    
    $logoFile = $_FILES['logo']['tmp_name'];
    if($logoFile != null){
        echo "here";
        $newProjectCreator->logo = file_get_contents($logoFile);
    }
    else{
        echo "HERE";
        $newProjectCreator->logo = file_get_contents("../Images/default.png");
        if($newProjectCreator->logo == null)
            echo "NULL";
        echo "YEAS";
    }
    
    if($newProjectCreator->createNewProject($newProjectCreator->userName, $newProjectCreator->title, $newProjectCreator->desc, $newProjectCreator->type, $newProjectCreator->link, $newProjectCreator->contribArray, $newProjectCreator->fileNames, $newProjectCreator->fileTypes, $newProjectCreator->files, $newProjectCreator->logo, $_POST['date'])){
        $newProjectCreator = null;
        ?>
            <meta http-equiv="refresh" content="0; URL='../viewProject.php?projectId=<?php echo $id+1;?>'" />
            <?php
        }
        else{
           ?>
           <meta http-equiv="refresh" content="0; URL='../Browse.php'" /> 
           <?php 
        }
    
    
}



