<?php

class newProject
{

    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    public $conn = null;
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
    public $logo = null;
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

    public function __destruct()
    {
        $this->conn->close();
        $this->conn = null;
    }

    public function createNewProject($userName, $title, $desc, $type, $link, $contribArray, $fileNames, $fileTypes, $files, $logo, $date, $author)
    {
        if ($this->conn != null) {
            if ($userName != null && $title != null && $desc != null && $type != null) {
                $userName = chop($userName);
                $title = chop($title);
                $desc = chop($desc);
                $type = chop($type);
                $link = chop($link);
                $author = chop($author);
                
                $id = null;
                $confirm = false;
                $stm = null;
                if ($date == null) {
                    $stm = "INSERT INTO Project (projectTitle, projDesc, demoUrl, date, projType, logoImage, author) VALUES (?,?,?, NOW(),?,?,?)";
                } else {
                    $stm = "INSERT INTO Project (projectTitle, projDesc, demoUrl, date, projType, logoImage, author) VALUES (?,?,?,?,?,?,?)";
                }
                
                if ($sql = $this->conn->prepare($stm)) {
                    $null = null;
                    if ($date == null) {
                        $sql->bind_param("ssssbs", $title, $desc, $link, $type, $null, $author);
                        $sql->send_long_data(4, $logo);
                    } else {
                        $sql->bind_param("sssssbs", $title, $desc, $link, $date, $type, $null, $author);
                        $sql->send_long_data(5, $logo);
                    }
                    
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
                    $s = "INSERT INTO Published (userName, projectId) VALUES (?,?)";
                    if ($sq = $this->conn->prepare($s)) {
                        $sq->bind_param("ss", $userName, $id);
                        $sq->execute();
                        $sq->close();
                        if (! empty($contribArray)) {
                            $sqlAdd = $this->conn->prepare($s);
                            $sqlAdd->bind_param("ss", $val, $id);
                            foreach ($contribArray as $x => $val) {
                                $sqlAdd->execute();
                            }
                            $sqlAdd->close();
                        }
                    } else {
                        $error = $this->conn->errno . ' ' . $this->conn->error;
                        echo $error;
                        return false;
                    }
                    if (! empty($files)) {
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
                        return $id;
                    }
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
        return $id;
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
            if ($value != "")
                $this->fileNames[] = $value;
        }
    }

    public function buildFileTypeArray($fileNames)
    {
        foreach ($fileNames as $x => $value) {
            if ($value != "") {
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