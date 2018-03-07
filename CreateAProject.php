<?php 
session_start();
$user = $_SESSION["user"];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CSPUB-Create A Project</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/CreateAProject.css">
<script type="text/javascript" src="Javascript/CreateAProject.js"></script>
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

<div id="main">
		<form method = "post" action = "http://www.randyconnolly.com/tests/process.php" id = "create" enctype="multipart/form-data">
			<fieldset>
				<legend> Create a Project </legend>
					<p>
						<label>Title: </label>
						<input type = "text" name = "title" placeholder="Enter Project title" class = "required"/>
					</p>
			
						<label>Description: </label>
						<div id="description" >
							<textarea name="description" rows="15" cols ="80" class = "required"></textarea>
						</div>
					<p>
						<label>Number of Contributors:</label>
							<input type="number" min="1" max="10" name="contributors" id = "numOfCont"/>
					</p>
					<div id = "contributors" class = "hidden">
					<p>
						<label>Contributors names:</label>
						<input type = "text" name = "contributor" placeholder="Contributor 1" class = "hidden"/>
						<input type = "text" name = "contributor" placeholder="Contributor 2" class = "hidden"/>
						<input type = "text" name = "contributor" placeholder="Contributor 3" class = "hidden"/>
						<input type = "text" name = "contributor" placeholder="Contributor 4" class = "hidden"/>
						<input type = "text" name = "contributor" placeholder="Contributor 5" class = "hidden"/>
						<input type = "text" name = "contributor" placeholder="Contributor 6" class = "hidden"/>
						<input type = "text" name = "contributor" placeholder="Contributor 7" class = "hidden"/>
						<input type = "text" name = "contributor" placeholder="Contributor 8" class = "hidden"/>
						<input type = "text" name = "contributor" placeholder="Contributor 9" class = "hidden"/>
						<input type = "text" name = "contributor" placeholder="Contributor 10" class = "hidden"/>
					</p>
					</div>
					<p>
						<label>Images: </label>
						<button type="button">attach</button>
					</p>
					<p>
						<label>Additional Documents: </label>
						<button type="button">attach</button>
					</p>
					<p>
						<label>Project Links: </label>
						<input type = "text" name = "link" placeholder="Project Links"/>
					</p>
					<p>
						<label>Copyright Info: </label>
						<input type = "text" name = "copyright" placeholder="Add any copyrights info on your project"/>
					</p>
					
					<p id = "center">
						<input type = "submit" value = "Create"/>
					</p>
			</fieldset>
			</form>
	</div>
	
<footer>
	<ul>
		<li class = "footerlinks"> <a href = "Browse.php">Browse</a>
	</ul>
	<p> Copyright &copy; 2018 CSPub</p>
</footer>
</body>
</html>