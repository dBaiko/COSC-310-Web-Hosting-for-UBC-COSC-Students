<?php
session_start();
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}
?>

<?php 
if(isset($_SESSION['user'])){

  class listContent{
      
      //This function takes in username, firstname, lastname, studentnumber, email, school, major
    public function displayContent($param1, $param2, $param3, $param4, $param5, $param6, $param7){
          echo '<h2 id = "name">'.$param1.'</h2>
				<table  id ="info">
				<thead>
					<tr>
						<th>Name</th>
                        <th>Student Number</th>
						<th>Email</th>
						<th>School</th>
                         <th>Major</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>'.$param2.' '.$param3.'</td>
						<td>'.$param4.'</td>
						<td>'.$param5.'</td>
                        <td>'.$param6.'</td>
                        <td>'.$param7.'</td>
					</tr>
				</tbody>
			</table>';
 
      }
      
      public function query_userInfo($param1)
      {
          include 'php/all_projects.php';
          if ($conn->connect_error) {
              die("Connection failed:" . $conn->connect_error);
          }
             $sql = "SELECT *
                     FROM User JOIN Student ON User.userName = Student.userName
                     WHERE User.userName = \"$param1\"
                     GROUP BY User.UserName;";
          
          $result = mysqli_query($conn, $sql);
          return $result;
      }
      
       
    }
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CSPUB-Portfolio</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/Portfolio.css">
</head>
<body>
<header>
<h1>CSPub</h1>
<div class = "right">
		<?php 
		if(isset($_SESSION["user"])){ 
		    echo "<p id = 'signIn'><a href = 'php/logUserOut.php'>Log Out</a></p>";
		    ?>
		    <div class = "dropdown">
		<p id = "dropimg"> <img src = "Images/Bars.png" class = "icons"/> </p>
		<div class = "dropdown-content">
			<ul>					
				<li> <a href = "Portfolio.php">Portfolio</a></li> 
				<li> <a href = "Browse.php">Browse</a></li> 
				<li> <a href = "CreateAProject.php">Create A Project</a></li>
			</ul>
		</div>
	</div>
		    <?php
		}
		else{
		    echo "<p id = 'signIn'><a href = 'SignIn.php'>Sign In</a></p>";
		}
		?>
	</div>
</header>

<div id = "main">
	<div id ="profileInfo">
<?php 
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}
    $contentGet = new listContent();

        $result = $contentGet->query_userInfo($user);
        $resultCheck = mysqli_num_rows($result);
        
        if($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $contentGet->displayContent($row['userName'], $row['firstName'], $row['lastName'], $row['studentNum'], $row['email'], $row['school'], $row['major']);
            }
        }else echo "Information not available at the moment!";
    ?>
	</div>
	<div id = "background">
	<h2>Projects:</h2>
	<div id = "projects">
	
<!-- 	display user project goes here -->
	
	</div>
	</div>
</div>


<footer>
	<ul>
		<li class = "footerlinks"> <a href = "Browse.php">Browse</a>
	</ul>
	<p> Copyright &copy; 2018 CSPub</p>
</footer>
</body>
</html>
<?php   
}
else{
    ?>
    <meta http-equiv="refresh" content="0; URL='Browse.php'"/>
    <?php
}

?>
