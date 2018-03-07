<?php 
session_start();
$user = $_SESSION["user"];
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
		if($user!=null){
		    echo "<p id = 'signIn'><a href = 'index.php'>Log Out</a></p>";
		}
		else{
		    echo "<p id = 'signIn'><a href = 'SignIn.php'>Sign In</a></p>";
		}
		?>
	</div>
</header>

<div id = "main">
	<div id ="profileInfo">
		<img src = "Images/SunsLogo.png" alt = "ProfileImage" id = "profile"/>
		<div>
			<h2 id = "name"> DBroomfield</h2>
				<table  id ="info">
				<thead>
					<tr>
						<th>Name</th>
						<th>User Type</th>
						<th>School/Business</th>
						<th>	Degree</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Darrien Broomfield</td>
						<td>Student</td>
						<td> UBC Okanagan</td>
						<td> Math / COSC </td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	<div id = "background">
	<h2>Projects:</h2>
	<div id = "projects">
		<table id = "project">
						<caption >COSC 310 Project</caption>
						<thead>
							<tr>
								<th>By: DBroomfield</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<img src = "Images/BuildingWebsite.jpg" name = "web" id = "web"/>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In pellentesque 
									iaculis arcu, non consequat lacus maximus et. Quisque a nulla imperdiet, 
									blandit mauris eget, fermentum quam. Maecenas dapibus vitae arcu ut varius. 
									Interdum et malesuada fames ac ante ipsum primis in faucibus. Vivamus vel 
									aliquam massa. Aliquam id metus dui. In vitae lacus porta, ullamcorper massa ultricies, 
									rhoncus leo. Donec mattis tellus imperdiet ex finibus, eget porttitor elit pharetra. 
									In at quam dapibus, auctor odio a, feugiat metus. Proin pretium fringilla nisl convallis hendrerit. 
									Fusce vehicula molestie metus et elementum. Nullam egestas egestas sapien sed mattis.
									Vestibulum eget dictum augue. Aenean fringilla, ipsum non tempor cursus, urna nunc semper ipsum, 
									et tempus sapien magna eget lacus. Curabitur rutrum ex felis, et dapibus purus faucibus ac. 
									Morbi pharetra risus ac felis auctor, et pretium magna auctor. Quisque a sem lobortis, 
									vulputate turpis eget, eleifend ante. Suspendisse fringilla sapien quis nibh euismod dictum. 
									Sed eleifend quis dui nec pellentesque. Vestibulum placerat enim consequat eros consectetur 
									ultricies. Nulla eu dui ut enim porta efficitur. Mauris nibh nisl, vulputate non iaculis et, 
									lobortis vel odio. Aliquam erat volutpat. Pellentesque dolor nisl, egestas sit amet nisl at, 
									molestie volutpat metus. Sed posuere nunc neque, in luctus magna pretium at.
									</p>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td>
									<p id = "copyright"> Copyright &copy; 2018 COSC 310 Project </p>
								</td>
							</tr>
						</tfoot>	
					</table>
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