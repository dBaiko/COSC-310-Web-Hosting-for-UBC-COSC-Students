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
$stm = "SELECT * FROM User WHERE userName = ?";
if($sql = $conn->prepare($stm)){
    $sql->bind_param("s", $username);
    $sql->execute();
    $result = mysqli_stmt_get_result($sql);
    $row = mysqli_fetch_array($result);
    ?>
    <h1>Congratulations <?php echo $row["firstName"]?>! Your account has been created</h1>
    <a href="SignIn.html">Proceed to login</a>
    <?php
} else {
    $error = $conn->errno . ' ' . $conn->error;
    echo $error;
}


?>