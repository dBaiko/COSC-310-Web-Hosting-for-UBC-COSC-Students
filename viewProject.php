<?php
session_start();
$user = $_SESSION["user"];
?>
<!DOCTYPE html> 
<html>
<head>
<meta charset="UTF-8">
<title>CSPUB-Browse Projects</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/viewProject.css">
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
	<article id="Project1">
		<table class = "Project">
			<caption ><h2 id = "title">How To Build An Awesome Website</h2></caption>
			<thead>
				<tr>
					<th><a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' id = 'logo'/></a></th>
					<th>By: <a href ="">Dbroomfield</a></th>
					<th> Contributors: <a href ="">Dylan</a>, <a href ="">Noman</a>, <a href ="">Karanmeet</a>, and <a href ="">Harman</a> 
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan = "3">
						<p id = "desc">Maecenas volutpat blandit aliquam etiam erat velit scelerisque 
						in dictum. Ornare massa eget egestas purus viverra. Quis risus sed 
						vulputate odio ut enim blandit volutpat maecenas. Odio eu feugiat 
						pretium nibh ipsum. Dignissim enim sit amet venenatis urna. Sed 
						ullamcorper morbi tincidunt ornare massa eget egestas purus viverra. 
						Ac felis donec et odio pellentesque diam volutpat commodo. Semper 
						eget duis at tellus at urna condimentum mattis. Eget nulla facilisi 
						etiam dignissim. Commodo ullamcorper a lacus vestibulum sed arcu non 
						odio euismod. Tincidunt praesent semper feugiat nibh sed pulvinar 
						proin gravida. Porttitor leo a diam sollicitudin tempor id eu nisl. 
						In hac habitasse platea dictumst vestibulum rhoncus. Vulputate eu 
						scelerisque felis imperdiet proin fermentum leo vel. Ligula ullamcorper
						malesuada proin libero nunc. Ullamcorper a lacus vestibulum sed arcu. 
						Sit amet cursus sit amet dictum sit amet. Lectus magna fringilla urna 
						porttitor.Condimentum mattis pellentesque id nibh tortor id. Vitae 
						et leo duis ut diam quam nulla. In ornare quam viverra orci sagittis. 
						Amet est placerat in egestas. Elementum pulvinar etiam non quam lacus 
						suspendisse faucibus interdum posuere. Felis bibendum ut tristique et 
						egestas. Scelerisque varius morbi enim nunc. Ut eu sem integer vitae 
						justo eget magna fermentum iaculis. Pellentesque dignissim enim sit 
						amet venenatis urna cursus eget nunc. Facilisi etiam dignissim diam 
						quis enim. Gravida dictum fusce ut placerat orci nulla pellentesque
						dignissim. Commodo quis imperdiet massa tincidunt nunc. Tortor vitae 
						purus faucibus ornare suspendisse. Libero enim sed faucibus turpis in 
						eu mi. Eget arcu dictum varius duis at consectetur lorem donec. Pharetra 
						vel turpis nunc eget lorem dolor sed viverra.
						</p>
					</td>
				<tr>
					<td>
						<p id = "links">  Links: <a href ="">abasasndaks</a> </p>
					</td>
				</tr>
			</tbody>
		</table>
	</article>
<div id = "extraImages">
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'pdf'/>
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
	<a href = ''><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
	<a href = '' ><img src = 'Images/SunsLogo.png' alt = 'Project Image' class = 'img'/>
</div>
	<p id = "copyright"> Copyright &copy; 2018 How To Build An Awesome Website  </p>
</div>



<footer>
	<ul>
		<li class = "footerlinks"> <a href = "Browse.php">Browse</a>
	</ul>
	<p> Copyright &copy; 2018 CSPub</p>
</footer>
</body>
</html>