<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
$servername = "localhost";
$db_user = "cswebhosting";
$db_pass = "a9zEkajA";
$db = "cswebhosting";

$username = $_SESSION["user"];
$username = chop($username);

$conn =  mysqli_connect($servername, $db_user, $db_pass, $db);
$stm = "SELECT firstName FROM User WHERE userName = ?";
if($sql = $conn->prepare($stm)){
    $sql->bind_param("s", $username);
    $sql->execute();
    $sql->bind_result($u);
    $sql->fetch();
    ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Congratulations!</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/Browse.css">
<script type="text/javascript" src="Javascript/Browse.js"></script>
</head>
<body>
	<?php include "header.php"?>
	<div id="main">
    <h1>Congratulations <?php echo $u?>! Your new project has been uploaded</h1>
    <h1><a href="viewProject.php?projectId=<?php echo $_SESSION['projectId']?>">View</a></h1>
    </div>
	<?php unset($_SESSION['projectId']);?>
</body>
</html>
    
    <?php
} else {
    $error = $conn->errno . ' ' . $conn->error;
    echo $error;
}


?>