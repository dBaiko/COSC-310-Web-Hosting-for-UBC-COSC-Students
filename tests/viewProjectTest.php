<?php
/* protected function selectTestData($id){
    $this->getConnection();
    $stm = "SELECT * FROM Project WHERE projectId = ?";
    if($sql = $this->conn->prepare($stm)){
        $sql->bind_param($id);
        if($sql->execute()){
            $pid = $title = $desc =  $url = $date = $type = $logo = $author = null;
            $sql->bind_param($pid,$title,$desc,$url,$date,$type,$logo,$author);
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
} */