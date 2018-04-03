<?php
date_default_timezone_set('America/Los_Angeles');
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
}
?>


<?php

require 'php/listContentClass.php';

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
				<input type= 'submit' value = '&#128269' id = 'searchButton'/>
			</form>
		</div>
		<div id="background">
			<div id="filters">
				<div id="time">
					<form method="get" action="Browse.php" name="sort_Time">
						<select name="Times" onchange='this.form.submit()' class = "options">
							<option disabled selected>Filter projects by time</option>
							<option value="Newest">Newest to oldest</option>
							<option value="Oldest">Oldest to Newest</option>
						</select>
					</form>
				</div>
				<div id="type">
					<form method="get" action="Browse.php" name="sort_Time">
						<select name="Types" onchange='this.form.submit()' class = "options">
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
				<button id = 'reset'><a href="Browse.php" id = "resetFont">Reset</a></button>
			<div id="dummyProject" style="width: 80%;">
				<h2>Projects</h2>
				<?php
    
    $contentGet = new listContent();
    if (isset($_GET["Times"])) {
        $time = $_GET["Times"];
        $result = $contentGet->sortedQuery_time($time);
        $resultCheck = mysqli_num_rows($result);
        
        if ($resultCheck == 0) {
            ?>
            <link rel="stylesheet" type="text/css" href="CSS/footer2.css">
            <?php 
            echo "<em>No projects available</em>";
        } elseif ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $contentGet->displayContent($row['projectTitle'], $row['userName'],   date('Y-m-d', strtotime($row['date'])), $row['projDesc'], $row['logoImage'], $row['projectId'], $row['author']);
                
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
              
                $contentGet->displayContent($row['projectTitle'], $row['userName'],   date('Y-m-d', strtotime($row['date'])), $row['projDesc'], $row['logoImage'], $row['projectId'], $row['author']);

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

                $contentGet->displayContent($row['projectTitle'], $row['userName'],   date('Y-m-d', strtotime($row['date'])), $row['projDesc'], $row['logoImage'], $row['projectId'], $row['author']);
                
            }
        }
    } else
        $result = $contentGet->query_all();
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck == 0) {
        echo "<em>No projects matched your search</em>";
        ?>
            <link rel="stylesheet" type="text/css" href="CSS/footer2.css">
            <?php 
    } elseif ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {

            $contentGet->displayContent($row['projectTitle'], $row['userName'],   date('Y-m-d', strtotime($row['date'])), $row['projDesc'], $row['logoImage'], $row['projectId'], $row['author']);
            
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
		<p id = "copy">Copyright &copy; 2018 CSPub</p>
	</footer>

</body>
</html>