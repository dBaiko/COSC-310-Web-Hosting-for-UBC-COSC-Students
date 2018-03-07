<html>
 <head>
 </head>
 <body>
 <h1>Testing database</h1>
 
<?php
$servername = "localhost";
$username = "cswebhosting";
$password = "a9zEkajA";
$dbname = "cswebhosting";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$sql = "SELECT * FROM Project where projectId = 1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<br> id: ". $row["projectId"]."<br>";
        echo "<br> Title: ". $row["projectTitle"]."<br>";
        echo "<br> Description: ". $row["projDesc"]."<br>";
        echo "<br> URL: ". $row["demoUrl"]."<br>";
        echo "<br> Date: ". $row["date"]."<br>";
        
    }
} else {
    echo "0 results";
}

$conn->close();
?> 
</body>
</html>


