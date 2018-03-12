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

    public function displayContent($param1, $param2, $param3, $param4)
    {
        echo "<table class=\"project\" id=\"website\">" . "<caption>" . $param1 . "</caption>" . "<thead>" . "<tr>" . "<th> By: " . $param2 . "</th>" . "<th class=\"textright\">" . $param3 . "</th>" . "</tr>" . "</thead>" . "<tbody>" . "<tr>" . "<td colspan=\"2\"><img src=\"Images/BuildingWebsite.jpg\"name=\"web\"class=\"images\" />" . "<p>" . $param4 . "</p></td>" . "</tr>" . "</tbody>" . "<tfoot>
    <tr>
    <td colspan=\"2\">
    <p id=\"copyright\">Copyright &copy; ".$param1."</p>
    </td>
    </tr>
    </tfoot>
    </table>";
    }

    public function query_all()
    {
        include 'php/all_projects.php';
        if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
        }
        $sql = "SELECT Published.userName AS username, projectTitle, projDesc, Project.date AS date, file 
                     FROM Project LEFT JOIN Files ON Project.projectId = Files.projectId
                     JOIN Published ON Project.projectId = Published.projectId
                     JOIN User ON Published.userName = User.userName   
                     ORDER BY date DESC;";
        
        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function sortedQuery_time($time)
    {
        include 'php/all_projects.php';
        if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
        }
        if ($time == "Newest") {
            $sql = "SELECT Published.userName AS username, projectTitle, projDesc, Project.date AS date, file
                       FROM Project LEFT JOIN Files ON Project.projectId = Files.projectId
                     JOIN Published ON Project.projectId = Published.projectId
                     JOIN User ON Published.userName = User.userName
                     ORDER BY date DESC;";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
        if ($time == "Oldest") {
            $sql = "SELECT Published.userName AS username, projectTitle, projDesc, Project.date AS date, file
                FROM Project LEFT JOIN Files ON Project.projectId = Files.projectId
                     JOIN Published ON Project.projectId = Published.projectId
                     JOIN User ON Published.userName = User.userName
                     WHERE 1
                     ORDER BY date ASC;";
            $result = mysqli_query($conn, $sql);
            return $result;
        }
    }

    public function sortedQuery_types($type)
    {
        include 'php/all_projects.php';
        if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
        }
        $sql = "SELECT Published.userName AS username, projectTitle, projDesc, Project.date AS date, file, projType
                FROM Project LEFT JOIN Files ON Project.projectId = Files.projectId
                     JOIN Published ON Project.projectId = Published.projectId
                     JOIN User ON Published.userName = User.userName
                     WHERE Project.projType = \"$type\"
                     ORDER BY date DESC;";
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
					<form method="get" action="Browse.php" name="sort_Time">
						<select name="Times" onchange='this.form.submit()'>
							<option disabled selected>Filter projects by time</option>
							<option value="Newest">Newest to oldest</option>
							<option value="Oldest">Oldest to Newest</option>
						</select>
					</form>
				</div>
				<div id="type">
					<form method="get" action="Browse.php" name="sort_Time">
						<select name="Types" onchange='this.form.submit()'>
							<option disabled selected>Filter projects by type</option>
							<option value="Web Development">Web Development</option>
							<option value="Mobile Application">Mobile Application</option>
							<option value="Data Science">Data Science</option>
							<option value="Object Oriented Programs (Java, C# etc.)">Object
								Oriented Programs (Java, C# etc.)</option>
							<option value="Robotics/Arduino/Raspberry Pi">Robotics/Arduino/Raspberry Pi</option>
							<option value="Biology Technology">Biology Technology</option>
							<option value="Parallel Computing">Parallel Computing</option>
							<option value="Games">Games</option>
							<option value="Virtual Reality">Virtual Reality</option>
							<option value="3D Modeling/Printing">3D Modeling/Printing</option>
							<option value="Math/Optimization">Math/Optimization</option>
							<option value="Algorithm Development">Algorithm Development</option>
							<option value="Other">Other</option>
						</select>
					</form>
				</div>
			</div>
			<div id="dummyProject">
				<h2>Projects</h2>
				<?php
				
    $test = new listContent();
    if (isset($_GET["Times"])) {
        $time = $_GET["Times"];
        $result = $test->sortedQuery_time($time);
        $resultCheck = mysqli_num_rows($result);
        
        if ($resultCheck == 0) {
            echo "<em>No projects available</em>";
        } elseif ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $test->displayContent($row['projectTitle'], $row['username'], $row['date'], $row['projDesc']);
            }
        }
        $conn->close();
    } elseif (isset($_GET["Types"])) {
        $type = $_GET["Types"];
        $result = $test->sortedQuery_types($type);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            echo "<em>No projects available</em>";
        } elseif ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $test->displayContent($row['projectTitle'], $row['username'], $row['date'], $row['projDesc']);
            }
        }
        $conn->close();
    } else
        $result = $test->query_all();
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $test->displayContent($row['projectTitle'], $row['username'], $row['date'], $row['projDesc']);
        }
    }
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