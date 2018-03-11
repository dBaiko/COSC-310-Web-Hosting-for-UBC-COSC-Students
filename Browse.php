<?php
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>
<?php
include 'php/all_projects.php';
?>

<?php
class listContent
{
    public function query_all()
    {
        include 'php/all_projects.php';
        if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
        }
        $sql = "SELECT Published.userName AS username, projectTitle, projDesc, Project.date AS date FROM Project, Published, User
                WHERE Project.projectId = Published.projectId AND Published.userName = User.userName ORDER BY date DESC;";
        $result = mysqli_query($conn, $sql);
        return $result;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CSPUB-Browse Projects</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/Browse.css">
<script type="text/javascript" src="Javascript/Browse.js"></script>
</head>
<body>
	<header>
		<h1>CSPub</h1>
		<div class="right">
		<?php
if (isset($_SESSION["user"])) {
    echo "<p id = 'signIn'><a href = 'php/logUserOut.php'>Log Out</a></p>";
    ?>
		    <div class="dropdown">
				<p id="dropimg">
					<img src="Images/Bars.png" class="icons" />
				</p>
				<div class="dropdown-content">
					<ul>
						<li><a href="Portfolio.php">Portfolio</a></li>
						<li><a href="Browse.php">Browse</a></li>
						<li><a href="CreateAProject.php">Create A Project</a></li>
					</ul>
				</div>
			</div>
		    <?php
} else {
    echo "<p id = 'signIn'><a href = 'SignIn.php'>Sign In</a></p>";
}
?>
	</div>
	</header>
	<div id="main">
		<div id="search">
			<h2>Search</h2>
			<form method="post"
				action="http://www.randyconnolly.com/tests/process.php"
				id="searchbar">
				<input type="text" name="search" placeholder="Search Projects"
					id="userSearch" />
			</form>
		</div>
		<div id="background">
			<div id="filters">
				<div id="time">
					<p>
						<a href=""> Time</a>
					</p>
					<div class="dropdown-content">
						<ul>
							<li><a href=""> Any time</a></li>
							<li><a href=""> Past Year</a></li>
							<li><a href=""> Past Month</a></li>
							<li><a href=""> Past Week</a></li>
							<li><a href=""> Past 24 Hours</a></li>
						</ul>
					</div>
				</div>
				<div id="type">
					<p>
						<a href=""> Project Type</a>
					</p>
					<div class="dropdown-content">
						<ul>
							<li><a href=""> All Projects </a></li>
							<li><a href=""> Cosc Projects </a></li>
							<li><a href=""> Math Projects </a></li>
							<li><a href=""> Engineering Projects</a></li>
							<li><a href=""> Physics Projects</a></li>
						</ul>
					</div>
				</div>
				<div id="rating">
					<p>
						<a href=""> Project Rating</a>
					</p>
					<div class="dropdown-content">
						<ul>
							<li><a href=""> 5 Stars </a></li>
							<li><a href=""> 4 Stars </a></li>
							<li><a href=""> 3 Stars </a></li>
							<li><a href=""> 2 Stars</a></li>
							<li><a href=""> 1 Stars</a></li>
						</ul>
					</div>
				</div>
			</div>
			<div id="dummyProject">
				<h2>Projects</h2>
				<?php
    // Just Testing a database query
    if ($conn->connect_error) {
        die("Connection failed:" . $conn->connect_error);
    }
    $test = new listContent();
    $result = $test->query_all();
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            
        echo "<table class=\"project\" id=\"website\">"
            ."<caption>".$row['projectTitle']."</caption>"
            ."<thead>"
            ."<tr>"
            ."<th> By: ".$row['username']."</th>"
                    ."<th class=\"textright\">".$row['date']."</th>"
            ."</tr>"
            ."</thead>"
            ."<tbody>"
            ."<tr>"
            ."<td colspan=\"2\"><img src=\"Images/BuildingWebsite.jpg\" name=\"web\"
                  class=\"images\" />"
    ."<p>".$row['projDesc']."</p></td>"
    ."</tr>"
    ."</tbody>"
    ."<tfoot>
    <tr>
    <td colspan=\"2\">
    <p id=\"copyright\">Copyright &copy; ".$row['projectTitle']."</p>
    </td>
    </tr>
    </tfoot>
    </table>";
        }
    }else{
        echo "0 results";
    }
    $conn->close();
    ?>
    
    		</div>
		</div>
	</div>
	<footer>
		<ul>
			<li class="footerlinks"><a href="Browse.php">Browse</a>
		
		</ul>
		<p>Copyright &copy; 2018 CSPub</p>
	</footer>
</body>
</html>