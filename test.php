<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"/>
    	<title>Test PHP Results</title>
	</head>
	<body>
	
	<?php
	
	$servername = "localhost";
	$username = "cswebhosting";
	$password = "a9zEkajA";
		    
	$conn = new mysqli($servername, $username, $password, $username);
	
	
	if($conn->connect_error){
	    echo("Connection Failed");
	    die("Connection failed: " . $conn->connect_error);
	}
	
	$sql = "INSERT INTO Test VALUES ('Bob', 'test321')";
	
	
	if ($conn->query($sql) === TRUE) {
	    echo "New record created successfully";
	} else {
	    echo "Error: " . $sql . "<br>" . $conn->error;
	}
	
	$conn->close();
	
	
	#if(isset($_POST["submit"])){
	#    echo("Welcom: ".$_POST["userName"] . "<br> \n");
	#    echo("Password: " . $_POST["password"] . "<br>");
	 #   
	  #  $conn = new mysqli_connect($servername, $username, $password);
	    
	#}
	#else{
	#    echo("no data");
	#}
	
	?>
	
	</body>
</html>
