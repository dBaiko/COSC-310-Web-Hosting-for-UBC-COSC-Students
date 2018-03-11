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
    $type = $_POST["projType"];
    if($type == null || $type == ""){
        $type = "Other";
    }
    echo "<br>".$type;
    if (isset($_POST['contributor'])) {
        foreach ($_POST['contributor'] as $index => $value) {
            $contributors[] = $value;
        }
        foreach ($contributors as $x => $value) {
            echo "<br>Value= " . $value;
        }
    }
    
    $link = $_POST["link"];
    echo "<br>" . $link;
    
    $fileNames = array();
    $fileTypes = array();
    $files = array();
    
    if ($_FILES['pics']['name'] != null) {
        foreach ($_FILES['pics']['name'] as $x => $value) {
            if($value != null){
                $fileNames[] = $value;
                $tmp = substr($value, strrpos($value, "."));
                $fileTypes[] = substr($tmp, 1);
            }
            
        }
        foreach ($_FILES["pics"]["tmp_name"] as $x => $value) {
            if ($value != null) {
                $content = file_get_contents($value);
                $files[] = $content;
            }
        }
    }
    
    if ($_FILES['pdfs']['name'] != null) {
        foreach ($_FILES['pdfs']['name'] as $i => $value) {
            if($value != null){
                $fileNames[] = $value;
                $tmp = substr($value, strrpos($value, "."));
                $fileTypes[] = substr($tmp, 1);
            }
            
        }
        foreach ($_FILES["pdfs"]["tmp_name"] as $x => $value) {
            if ($value != null) {
                $content = file_get_contents($value);
                $files[] = $content;
            }
        }
    }
    
    foreach ($fileNames as $x => $value) {
        echo "<br>Key= ". $x ." Value= " . $value;
    }
    
    foreach ($fileTypes as $x => $value) {
        echo "<br>Key= ". $x ." Value= " . $value;
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
    $stm = "INSERT INTO Project (projectTitle, projDesc, demoUrl, date, projType) VALUES (?,?,?, NOW(),?)";
    if ($sql = $conn->prepare($stm)) {
        $sql->bind_param("ssss", $title, $desc, $link, $type);
        if($sql->execute()){
            $id = mysqli_insert_id($conn);
            echo "<br>" . $id;
            $confirm = true;
        }else {
            $error = $conn->errno . ' ' . $conn->error;
            echo $error;
        }
        
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
                $sqlAdd = $conn->prepare($s);
                $sqlAdd->bind_param("sss", $val, $stu, $id);
                foreach ($contributors as $x => $val){
                    $stu = "";
                    $stmGetStu = "SELECT studentNum FROM Student WHERE userName = ?";
                    if($sqlStu = $conn->prepare($stmGetStu)){
                        $sqlStu->bind_param("s", $val);
                        $sqlStu->execute();
                        $sqlStu->bind_result($stu);
                        $sqlStu->fetch();
                        $sqlStu->close();
                    }else{
                        $error = $conn->errno . ' ' . $conn->error;
                        echo $error;
                    }
                        $sqlAdd->execute();
                       
                    
                }
                $sqlAdd->close();
            }
        }else{
            $error = $conn->errno . ' ' . $conn->error;
            echo $error;
        }
        
        $stmFiles = "INSERT INTO Files (projectId, fileName, file, fileType) VALUES (?,?,?,?);";
        if($sqlFiles = $conn->prepare($stmFiles)){
            $name = "";
            $type = "";
            $fileC = "";
            $null = NULL;
            $sqlFiles->bind_param("ssbs", $id,$name,$null,$type);
            foreach ($files as $key => $fValue){
                $name = $fileNames[$key];
                $type = $fileTypes[$key];
                $fileC = $fValue;
                $sqlFiles->send_long_data(2,$fileC);
                $sqlFiles->execute();
            }
        }
        $sqlFiles->close();
        $conn->close();
        ?>
         <meta http-equiv="refresh" content="0; URL='../confirmNewProject.php'"/>
        <?php    
    
    }


}