<?php 
session_start();
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}
?>

<!DOCTYPE html> 
<html>
<head>
<meta charset="UTF-8">
<title>CSPUB-Browse Projects</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/Browse.css">
<script type="text/javascript" src="Javascript/Browse.js"></script >
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
<div id="main">
		<div id = "search">
			<h2> Search</h2>
			<form method = "post" action = "http://www.randyconnolly.com/tests/process.php" id = "searchbar">
				<input type = "text" name = "search" placeholder = "Search Projects" id = "userSearch"/> 
			</form>		
		</div>
		<div id = "background">
		<div id = "filters">
			<div id = "time">
				<p><a href = ""> Time</a> </p>
				<div class = "dropdown-content">
				<ul>
					<li> <a href =""> Any time</a> </li>
					<li> <a href =""> Past Year</a> </li>
					<li> <a href =""> Past Month</a> </li>
					<li> <a href =""> Past Week</a> </li>
					<li> <a href =""> Past 24 Hours</a> </li>
				</ul>
				</div>
			</div>
			<div id = "type">
				<p><a href = ""> Project Type</a> </p>
				<div class = "dropdown-content">
				<ul>
					<li> <a href =""> All Projects </a> </li>
					<li> <a href =""> Cosc Projects </a> </li>
					<li> <a href =""> Math Projects </a> </li>
					<li> <a href =""> Engineering Projects</a> </li>
					<li> <a href =""> Physics Projects</a> </li>
				</ul>
				</div>
			</div>
			<div id = "rating">
				<p><a href = ""> Project Rating</a> </p>
				<div class = "dropdown-content">
				<ul>
					<li> <a href =""> 5 Stars </a> </li>
					<li> <a href =""> 4 Stars </a> </li>
					<li> <a href =""> 3 Stars </a> </li>
					<li> <a href =""> 2 Stars</a> </li>
					<li> <a href =""> 1 Stars</a> </li>
				</ul>
				</div>
			</div>
		</div>
		<div id = "dummyProject">
				<h2>Projects:</h2>
					<table class = "project" id = "website">
						<caption>How To Build An Awesome Website</caption>
						<thead>
							<tr>
								<th>By: DBroomfield</th>
								<th class ="textright">Feb 24, 2018</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="2">
									<img src = "Images/BuildingWebsite.jpg" name = "web" class = "images"/>
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
								<td colspan="2">
									<p id = "copyright"> Copyright &copy; 2018 How To Build An Awesome Website  </p>
								</td>
							</tr>
						</tfoot>	
					</table>
					<table class = "project" id = "project">
						<caption>Managing A Successful Project</caption>
						<thead>
							<tr>
								<th>By: KKhatra</th>
								<th class ="textright">Dec 18,  2017</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="2">
									<img src = "Images/Success.jpg" name = "success" class = "images"/>
									<p>Maecenas volutpat blandit aliquam etiam erat velit scelerisque 
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
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2">
									<p id = "copyright"> Copyright &copy; 2017  Managing A Successful Project</p>
								</td>
							</tr>
						</tfoot>	
						</table>
						<table class = "project" id = "database">
						<caption>Building An Efficient Database </caption>
						<thead>
							<tr>
								<th>By: DillyJB</th>
								<th class ="textright">Sep 15, 2016</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td colspan="2">
									<img src = "Images/Database.png" name = "database" class = "images"/>
									<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed 
									do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
									Fermentum odio eu feugiat pretium nibh. Felis imperdiet proin 
									fermentum leo vel orci porta non pulvinar. Urna neque viverra 
									justo nec ultrices dui. Est velit egestas dui id ornare arcu 
									odio ut sem. Turpis nunc eget lorem dolor sed viverra ipsum nunc 
									aliquet. Bibendum at varius vel pharetra vel turpis. Sodales ut eu 
									sem integer. Netus et malesuada fames ac turpis egestas integer eget. 
									Fringilla ut morbi tincidunt augue interdum velit euismod in. Tellus 
									molestie nunc non blandit massa. Sed turpis tincidunt id aliquet risus 
									feugiat in. Diam phasellus vestibulum lorem sed risus ultricies tristique 
									nulla aliquet. Tincidunt dui ut ornare lectus sit amet est placerat.
									Elit duis tristique sollicitudin nibh sit amet. Sociis natoque penatibus 
									et magnis. Lobortis scelerisque fermentum dui faucibus in ornare quam 
									viverra orci. Nunc mattis enim ut tellus elementum sagittis. Sed sed 
									risus pretium quam vulputate dignissim suspendisse. Nunc sed velit 
									dignissim sodales ut eu sem. Adipiscing commodo elit at imperdiet dui
									accumsan sit amet nulla. Nunc congue nisi vitae suscipit tellus mauris 
									a diam. Cum sociis natoque penatibus et. Cum sociis natoque penatibus 
									et magnis. Ac tortor vitae purus faucibus ornare suspendisse. Eu lobortis 
									elementum nibh tellus molestie nunc. Egestas maecenas pharetra convallis 
									posuere. Maecenas ultricies mi eget mauris pharetra. Sollicitudin aliquam 
									ultrices sagittis orci a. Ut sem viverra aliquet eget sit amet tellus cras. 
									Libero id faucibus nisl tincidunt eget nullam non nisi est. Ipsum dolor sit 
									amet consectetur adipiscing. A cras semper auctor neque vitae. Lectus mauris 
									ultrices eros in cursus turpis. Erat velit scelerisque in dictum non. Nec 
									tincidunt praesent semper feugiat nibh. Malesuada fames ac turpis egestas 
									maecenas pharetra convallis posuere morbi. Consequat nisl vel pretium lectus 
									quam id leo in vitae. Eu turpis egestas pretium aenean pharetra magna. Tellus 
									in hac habitasse platea dictumst vestibulum. Id velit ut tortor pretium 
									viverra suspendisse. In iaculis nunc sed augue lacus. Sed arcu non odio 
									euismod lacinia at quis. Amet aliquam id diam maecenas ultricies mi eget. 
									Nunc sed blandit libero volutpat sed cras ornare. Nullam vehicula ipsum a 
									arcu cursus vitae. Nunc consequat interdum varius sit amet mattis vulputate 
									xenim nulla. Amet venenatis urna cursus eget.
									</p>
								</td>
							</tr>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="2">
									<p id = "copyright"> Copyright &copy; 2016 Building An Efficient Database </p>
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