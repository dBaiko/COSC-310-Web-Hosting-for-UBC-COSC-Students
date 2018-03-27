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

    public function displayContent($param1, $param2, $param3, $param4, $param5, $param6)
    {
        echo "<a href=\"viewProject.php?projectId=$param6\" style=\"\"><table class=\"project\" id=\"website\">" . "<caption>" . $param1 . "</caption>" . "<thead>" . "<tr>" . "<th> By: " . $param2 . "</th>" . "<th class=\"textright\">" . $param3 . "</th>" . "</tr>" . "</thead>" . "<tbody>" . "<tr>" . "<td colspan=\"2\"><img src=\"data:image/png;base64,".base64_encode($param5)."\"name=\"web\"class=\"images\" alt=\"logo here\" />" . "<p>" . $param4 . "</p></td>" . "</tr>" . "</tbody>" . "<tfoot>
    <tr>
    <td colspan=\"2\">
    <p id=\"copyright\">Copyright &copy; " . $param1 . "</p>
    </td>
    </tr>
    </tfoot>
    </table></a>";
    }

    public function query_all()
    {
        include 'php/all_projects.php';
        if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
        }

        $sql = "SELECT p.projectId, p.projectTitle, pub.userName, p.date, p.projDesc, p.logoImage FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId GROUP BY pub.projectId ORDER BY p.date DESC"; 

        
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

            $sql = "SELECT p.projectId, p.projectTitle, pub.userName, p.date, p.projDesc, p.logoImage FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId GROUP BY pub.projectId ORDER BY p.date DESC";
            

            $result = mysqli_query($conn, $sql);
            return $result;
        }
        if ($time == "Oldest") {

            $sql = "SELECT p.projectId, p.projectTitle, pub.userName, p.date, p.projDesc, p.logoImage FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId GROUP BY pub.projectId ORDER BY p.date ASC";
            

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

        $sql = $sql = "SELECT p.projectId, p.projectTitle, pub.userName, p.date, p.projDesc, p.logoImage FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId AND p.projType = \"$type\" GROUP BY pub.projectId ORDER BY p.date DESC";
        

        $result = mysqli_query($conn, $sql);
        return $result;
    }

    public function sortedQuery_search($search)
    {
        include 'php/all_projects.php';
        if ($conn->connect_error) {
            die("Connection failed:" . $conn->connect_error);
        }

        $sql = $sql = "SELECT * FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId AND p.projectTitle LIKE \"%$search%\" GROUP BY pub.projectId ORDER BY p.date DESC";
        

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
	<?php include "header.php"?>
	<div id="main">
		<div id="search">
			<h2>Search</h2>
			<form method="get" action="Browse.php" id="searchbar">
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
							<option value="Robotics/Arduino/Raspberry Pi">Robotics/Arduino/Raspberry
								Pi</option>
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
				<button><a href="Browse.php">Reset</a></button>
			<div id="dummyProject" style="width: 80%;">
				<h2>Projects</h2>
				<?php
    
    $contentGet = new listContent();
    if (isset($_GET["Times"])) {
        $time = $_GET["Times"];
        $result = $contentGet->sortedQuery_time($time);
        $resultCheck = mysqli_num_rows($result);
        
        if ($resultCheck == 0) {
            echo "<em>No projects available</em>";
        } elseif ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $contentGet->displayContent($row['projectTitle'], $row['userName'],   date('Y-m-d', strtotime($row['date'])), $row['projDesc'], $row['logoImage'], $row['projectId']);
                
            }
        }
    }
    elseif (isset($_GET["Types"])) {
        $type = $_GET["Types"];
        $result = $contentGet->sortedQuery_types($type);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            echo "<em>No projects of the type <b>" .$type. "</b> available</em>";
            ?>
            <link rel="stylesheet" type="text/css" href="CSS/footer2.css">
            <?php 
        } elseif ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
              
                $contentGet->displayContent($row['projectTitle'], $row['userName'],   date('Y-m-d', strtotime($row['date'])), $row['projDesc'], $row['logoImage'], $row['projectId']);

            }
        }
    }
    
    elseif (isset($_GET["search"])) {
        $search = $_GET["search"];
        $result = $contentGet->sortedQuery_search($search);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck == 0) {
            echo "<em>No projects matched your search <b>'" .$search. "'</b> </em>";
            ?>
            <link rel="stylesheet" type="text/css" href="CSS/footer2.css">
            <?php 
        } elseif ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $contentGet->displayContent($row['projectTitle'], $row['userName'],   date('Y-m-d', strtotime($row['date'])), $row['projDesc'], $row['logoImage'], $row['projectId']);
                
            }
        }
    } else
        $result = $contentGet->query_all();
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $contentGet->displayContent($row['projectTitle'], $row['userName'],   date('Y-m-d', strtotime($row['date'])), $row['projDesc'], $row['logoImage'], $row['projectId']);
            
        }
    }
    $conn->close();
    ?>
    		</div>
		</div>
	</div>
	<footer>
		<ul>
			<li class="footerlinks"><a href="Browse.php">Browse</a></li>
		</ul>
		<p>Copyright &copy; 2018 CSPub</p>
	</footer>

</body>
</html>