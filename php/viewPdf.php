<?php
$projectId = $_GET['projectId'];
$fileName = $_GET['fileName'];

$db_host = 'localhost';
$db_name = 'cswebhosting';
$db_user = 'cswebhosting';
$db_pass = 'a9zEkajA';
$db = 'cswebhosting';

$conn =  mysqli_connect($db_host, $db_user, $db_pass, $db);

$stm = "SELECT file, fileType FROM Files WHERE projectId = ? AND fileName = ?";
if($sql = $conn->prepare($stm)){
    $sql->bind_param("ss",$projectId,$fileName);
    $sql->execute();
    $sql->bind_result($f,$t);
    $sql->fetch();
    
    header('Content-type: application/pdf'  );
    echo $f;
}