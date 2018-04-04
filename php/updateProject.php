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
    
    public function getLogo($projectId){
        $stm = "SELECT logoImage FROM Project WHERE projectId = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s",$projectId);
            if($sql->execute()){
                $logo = null;
                $sql->bind_result($logo);
                $sql->fetch();
                $sql->close();
                return $logo;
            }
        } else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die( $error);
        }
    }
    
    public function getAuthor($projectId){
        $stm = "SELECT author FROM Project WHERE projectId = ?";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("s",$projectId);
            if($sql->execute()){
                $author = null;
                $sql->bind_result($author);
                $sql->fetch();
                $sql->close();
                return $author;
            }
        } else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            die( $error);
        }
    }
    
    public function buildOldFileArrays($files, $projectId){
        $oldFiles = array();
        foreach($files as $fileName){
            $stm = "SELECT fileName, file FROM Files WHERE fileName = ? AND projectId = ?";
                if($sql = $this->conn->prepare($stm)){
                    $sql->bind_param("ss",$fileName, $projectId);
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
    
    public function insertFile($projectId,$fileName,$file){
        $tmp = $tmp = substr($fileName, strrpos($fileName, "."));
        $fileType = substr($tmp, 1);
        $null = null;
        $stm = "INSERT INTO Files (projectId, fileName, file, fileType) VALUES (?,?,?,?)";
        if($sql = $this->conn->prepare($stm)){
            $sql->bind_param("ssbs",$projectId,$fileName,$null,$fileType);
            $sql->send_long_data(2, $file);
            if($sql->execute()){
                $sql->close();
                return true;
            }
            else{
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
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_SERVER["REQUEST_METHOD"])){
    require 'newProjectClass.php';
    
    $id = $_POST['projectId'];
    $user = $_SESSION['user'];
    
    $updater = new projectUpdater();
    $newProjectCreator = new newProject();
    
    $author = $updater->getAuthor($id);
    
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
    
    
    if($_FILES['pdfs'] != null){
        $newProjectCreator->buildFileArrays($_FILES['pdfs']);
    }
    
    if($_FILES['pics'] != null){
        $newProjectCreator->buildFileArrays($_FILES['pics']);
    }
    
    
    $oldFiles = NULL;
    if(isset($_POST['hiddenFileNames'])){
        $oldFiles = $updater->buildOldFileArrays($_POST['hiddenFileNames'],$id);
    }
    
    
    
    $logo = $updater->getLogo($id);
    
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
    
    
    
    $logoFile = $_FILES['logo']['tmp_name'];
    if($logoFile != null){
        $newProjectCreator->logo = file_get_contents($logoFile);
    }
    else {
        if($logo == file_get_contents("../Images/default.png") || isset($_POST['removed']) ){
            $newProjectCreator->logo = file_get_contents("../Images/default.png");
        }
        else{
            $newProjectCreator->logo = $logo;
        }
        
    }
    
    if($pid = $newProjectCreator->createNewProject($newProjectCreator->userName, $newProjectCreator->title, $newProjectCreator->desc, $newProjectCreator->type, $newProjectCreator->link, $newProjectCreator->contribArray, $newProjectCreator->fileNames, $newProjectCreator->fileTypes, $newProjectCreator->files, $newProjectCreator->logo, $_POST['date'], $author)){
        
        if($oldFiles != null){
            foreach ($oldFiles as $v){
                $updater->insertFile($pid, $v['name'], $v['tmp_name']);
            }
        }
        
        $updater = null;
        $newProjectCreator = null;
        ?>
       <meta http-equiv="refresh" content="0; URL='../viewProject.php?projectId=<?php echo $pid;?>'" />
            <?php
        }
        else{
           ?>
        <meta http-equiv="refresh" content="0; URL='../Browse.php'" />
           <?php 
        }
    
    
}