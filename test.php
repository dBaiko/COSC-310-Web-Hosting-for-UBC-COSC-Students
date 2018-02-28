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

	
	if(isset($_POST["submit"])){
	    $check = getimagesize($_FILES["file"]["tmp_name"]);
	    if($check !== false){
	        $image = $_FILES["file"]["tmp_name"];
	        $imgContent = file_get_contents($image);
	        
	        
	        $conn =  mysqli_connect($servername, $username, $password, $username);
	        
	       
	        #inserting
	        $sql = $conn->prepare("INSERT INTO Test (userName,file) VALUES (?,?);");
	        
	        $null = NULL;
	        $t = "fuck";
	        
	        $sql->bind_param("sb", $t,$null);
	        
	        $sql->send_long_data(1, $imgContent);
	        
	        $sql->execute();
	        
	        #retreiving
	        $stmt = "SELECT file FROM Test";
	        
	        
	        
	        
	        
	        $res = $conn->query($stmt);
	        
	        while($result=mysqli_fetch_array($res)){;
	        
	        echo '<img src="data:image/png;base64,'.base64_encode($result['file']).'"/>';
	        
	        }
	        
	        

	        
	        
	    }
	}
	
	
	?>
	
	</body>
</html>
