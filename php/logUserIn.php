<?php

session_start();

$user = $_POST["username"];
$_SESSION["user"] = $user;

?>

<meta http-equiv="refresh" content="0; URL='../Browse.php'"/>