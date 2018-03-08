<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$username = $_SESSION["user"];
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    echo $username;
    $title = $_POST["title"];
    echo "<br>" . $title;
    $desc = $_POST["description"];
    echo "<br>" . $desc;
    $contributors = array();
    if ($_POST['contributor'] != null) {
        foreach ($_POST['contributor'] as $index => $value) {
            $contributors[] = $value;
        }
        foreach ($contributors as $x => $value) {
            echo "<br>Value= " . $value;
        }
    }
    
    $link = $_POST["link"];
    echo "<br>" . $link;
    
    $picsFileNames = NULL;
    $pdfsFileNames = NULL;
    $picFileTypes = NULL;
    $pdfsFileTypes = NULL;
    $pdfFiles = NULL;
    $picFiles = NULL;
    
    if ($_FILES['pics']['name'] != null) {
        $picsFileNames = array();
        $picFileTypes = array();
        $picFiles = array();
        foreach ($_FILES['pics']['name'] as $x => $value) {
            $picsFileNames[] = $value;
            $tmp = substr($value, strrpos($value, "."));
            $picFileTypes[] = substr($tmp, 1);
        }
        
        array_pop($picFileTypes);
        array_pop($picsFileNames);
        foreach ($_FILES["pics"]["tmp_name"] as $x => $value) {
            if ($value != null) {
                $content = file_get_contents($value);
                $picFiles[] = $content;
            }
        }
    }
    
    if ($_FILES['pdfs']['name'] != null) {
        $pdfsFileNames = array();
        $pdfsFileTypes = array();
        $pdfFiles = array();
        foreach ($_FILES['pdfs']['name'] as $i => $value) {
            $pdfsFileNames[] = $value;
            $tmp = substr($value, strrpos($value, "."));
            $pdfsFileTypes[] = substr($tmp, 1);
        }
        
        array_pop($pdfsFileNames);
        array_pop($pdfsFileTypes);
        foreach ($_FILES["pdfs"]["tmp_name"] as $x => $value) {
            if ($value != null) {
                $content = file_get_contents($value);
                $picFiles[] = $content;
            }
        }
    }
    
    foreach ($picsFileNames as $x => $value) {
        echo "<br>Value= " . $value;
    }
    
    foreach ($picFileTypes as $x => $value) {
        echo "<br>Value= " . $value;
    }
    
    foreach ($pdfsFileNames as $x => $value) {
        echo "<br>Value= " . $value;
    }
    
    foreach ($pdfsFileTypes as $x => $value) {
        echo "<br>Value= " . $value;
    }
    
    $servername = "localhost";
    $db_user = "cswebhosting";
    $db_pass = "a9zEkajA";
    $db = "cswebhosting";
    
    $conn = mysqli_connect($servername, $db_user, $db_pass, $db);
    $id = null;
    $confirm = false;
    $title = chop($title);
    $desc = chop($desc);
    $link = chop($link);
    $stm = "INSERT INTO Project (projectTitle, projDesc, demoUrl, date) VALUES (?,?,?, NOW())";
    if ($sql = $conn->prepare($stm)) {
        $sql->bind_param("sss", $title, $desc, $link);
        $sql->execute();
        $id = mysqli_insert_id($conn);
        echo "<br>" . $id;
        $confirm = true;
    } else {
        $error = $conn->errno . ' ' . $conn->error;
        echo $error;
    }
    
    $studentNum = "";
    
    if ($confirm == true) {
        $stm = "SELECT studentNum FROM Student WHERE userName = ?";
        if($s = $conn->prepare($stm)){
            $s->bind_param("s", $username);
            $s->execute();
            $s->bind_result($studentNum);
            $s->fetch();
        }else{
            $error = $conn->errno . ' ' . $conn->error;
            echo $error;
        }
        echo "<br>".$studentNum;
        $s = "INSERT INTO Published (userName, studentNum, projectId) VALUES (?,?,?)";
        if($sq = $conn->prepare($s)){
            $sq->bind_param("sss",$username,$studentNum,$id);
            $sq->execute();
           $sq->close();
            if(!empty($contributors)){
                echo "<br>HERE";
                $sqlAdd = $conn->prepare($s);
                $sqlAdd->bind_param("sss", $val, $stu, $id);
                foreach ($contributors as $x => $val){
                    echo "<br>HERE2";
                    $stu = "";
                    $stmGetStu = "SELECT studentNum FROM Student WHERE userName = ?";
                    if($sqlStu = $conn->prepare($stmGetStu)){
                        echo "<br>HERE3";
                        $sqlStu->bind_param("s", $val);
                        $sqlStu->execute();
                        $sqlStu->bind_result($stu);
                        $sqlStu->fetch();
                        $sqlStu->close();
                    }else{
                        $error = $conn->errno . ' ' . $conn->error;
                        echo $error;
                    }
                    echo "<br>HERE4 ".$stu . " " . $val . " " . $id;
                        $sqlAdd->bind_param("sss",$val,$stu,$id);
                        $sqlAdd->execute();
                       
                    
                }
            }
        }else{
            $error = $conn->errno . ' ' . $conn->error;
            echo $error;
        }
    }


    








}