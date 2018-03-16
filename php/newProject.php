<?php

class newProject
{

    private $db_host = 'localhost';

    private $db_name = 'cswebhosting';

    private $db_user = 'cswebhosting';

    private $db_pass = 'a9zEkajA';

    private $conn = null;

    private $db = null;

    public $userName = null;

    public $title = null;

    public $desc = null;

    public $link = null;

    public $type = null;

    public $contribArray = array();

    public $fileNames = array();

    public $fileTypes = array();

    public $files = array();

    public function __construct()
    {
        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
        if (! $this->conn) {
            die('Could not connect: ' . mysqli_error());
        } else {
            $this->db = mysqli_select_db($this->conn, $this->db_name);
            if (! $this->db) {
                die('Could not connect: ' . mysqli_error());
            }
        }
    }
    
    public function __destruct(){
        $this->conn->close();
        $this->conn = null;
    }

    public function createNewProject($userName, $title, $desc, $type, $link, $contribArray, $fileNames, $fileTypes, $files)
    {
        if ($this->conn != null) {
            if ($userName != null && $title != null && $desc != null && $type != null) {
                $userName = chop($userName);
                $title = chop($title);
                $desc = chop($desc);
                $type = chop($type);
                $link = chop($link);
                
                $id = null;
                $confirm = false;
                $stm = "INSERT INTO Project (projectTitle, projDesc, demoUrl, date, projType) VALUES (?,?,?, NOW(),?)";
                if ($sql = $this->conn->prepare($stm)) {
                    $sql->bind_param("ssss", $title, $desc, $link, $type);
                    if ($sql->execute()) {
                        $id = mysqli_insert_id($this->conn);
                        $confirm = true;
                    } else {
                        $error = $this->conn->errno . ' ' . $this->conn->error;
                        echo $error;
                        return false;
                    }
                    
                    $sql->close();
                } else {
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return false;
                }
                
                $studentNum = "";
                
                if ($confirm == true) {
                    $stm = "SELECT studentNum FROM Student WHERE userName = ?";
                    if ($s = $this->conn->prepare($stm)) {
                        $s->bind_param("s", $userName);
                        $s->execute();
                        $s->bind_result($studentNum);
                        $s->fetch();
                        $s->close();
                    } else {
                        $error = $conn->errno . ' ' . $conn->error;
                        echo $error;
                        return false;
                    }
                    $s = "INSERT INTO Published (userName, studentNum, projectId) VALUES (?,?,?)";
                    if ($sq = $this->conn->prepare($s)) {
                        $sq->bind_param("sss", $userName, $studentNum, $id);
                        $sq->execute();
                        $sq->close();
                        if (! empty($contribArray)) {
                            $sqlAdd = $this->conn->prepare($s);
                            $sqlAdd->bind_param("sss", $val, $stu, $id);
                            foreach ($contribArray as $x => $val) {
                                $stu = "";
                                $stmGetStu = "SELECT studentNum FROM Student WHERE userName = ?";
                                if ($sqlStu = $this->conn->prepare($stmGetStu)) {
                                    $sqlStu->bind_param("s", $val);
                                    $sqlStu->execute();
                                    $sqlStu->bind_result($stu);
                                    $sqlStu->fetch();
                                    $sqlStu->close();
                                } else {
                                    $error = $this->conn->errno . ' ' . $this->conn->error;
                                    echo $error;
                                    return false;
                                }
                                $sqlAdd->execute();
                            }
                            $sqlAdd->close();
                        }
                    } else {
                        $error = $this->conn->errno . ' ' . $this->conn->error;
                        echo $error;
                        return false;
                    }
                    if(! empty($files)){
                    $stmFiles = "INSERT INTO Files (projectId, fileName, file, fileType) VALUES (?,?,?,?);";
                    if ($sqlFiles = $this->conn->prepare($stmFiles)) {
                        $name = "";
                        $filetype = "";
                        $fileC = "";
                        $null = NULL;
                        $sqlFiles->bind_param("ssbs", $id, $name, $null, $filetype);
                        foreach ($files as $key => $fValue) {
                            $name = $fileNames[$key];
                            $filetype = $fileTypes[$key];
                            $fileC = $fValue;
                            $sqlFiles->send_long_data(2, $fileC);
                            $sqlFiles->execute();
                        }
                    }
                    $sqlFiles->close();
                    return true;
                }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function setUserName($user)
    {
        $this->userName = $user;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setDesc($desc)
    {
        $this->desc = $desc;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function setType($type)
    {
        $this->type = $type;
    }

    public function buildContribArray($contrib)
    {
        foreach ($contrib as $index => $value) {
            $this->contribArray[] = $value;
        }
    }

    public function buildFileArrays($files)
    {
        if (isset($files['name'])) {
            $this->buildFileNameArray($files['name']);
            $this->buildFileTypeArray($files['name']);
        }
        if (isset($files['tmp_name'])) {
            $this->buildFiles($files['tmp_name']);
        }
    }

    public function buildFileNameArray($fileNames)
    {
        foreach ($fileNames as $x => $value) {
            if($value != "")
                $this->fileNames[] = $value;
        }
    }

    public function buildFileTypeArray($fileNames)
    {
        foreach ($fileNames as $x => $value) {
            if($value != ""){
                $tmp = substr($value, strrpos($value, "."));
                $this->fileTypes[] = substr($tmp, 1);
            }
            
        }
    }

    public function buildFiles($files)
    {
        foreach ($files as $x => $value) {
            if ($value != null) {
                $content = file_get_contents($value);
                $this->files[] = $content;
            }
        }
    }
}

error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

if(isset($_SERVER["REQUEST_METHOD"])){
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $username = $_SESSION["user"];
        
        $newProjectCreator = new newProject();
        
        $newProjectCreator->setUserName($username);
        
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
        
        if(isset($_POST["contributor"])){
            $newProjectCreator->buildContribArray($_POST["contributor"]);
        }
        
        if($_FILES['pics'] != null){
            $newProjectCreator->buildFileArrays($_FILES['pics']);
        }
        
        if(isset($_FILES['pdfs'])){
            $newProjectCreator->buildFileArrays($_FILES['pdfs']);
        }
        
        if($newProjectCreator->createNewProject($newProjectCreator->userName, $newProjectCreator->title, $newProjectCreator->desc, $newProjectCreator->type, $newProjectCreator->link, $newProjectCreator->contribArray, $newProjectCreator->fileNames, $newProjectCreator->fileTypes, $newProjectCreator->files)){
            $newProjectCreator = null;    
            ?>
            <meta http-equiv="refresh" content="0; URL='../confirmNewProject.php'" />
            <?php
        }
        else{
           ?>
           <meta http-equiv="refresh" content="0; URL='../CreateAProject.php'" />
           <?php 
        }
    }
}