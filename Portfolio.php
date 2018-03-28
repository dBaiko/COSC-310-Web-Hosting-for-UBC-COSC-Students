<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if (isset($_SESSION['user'])) {
    $user = $_SESSION['user'];
    
    $db_host = 'localhost';
    $db_name = 'cswebhosting';
    $db_user = 'cswebhosting';
    $db_pass = 'a9zEkajA';
    $db = 'cswebhosting';
    
    $conn = mysqli_connect($db_host, $db_user, $db_pass, $db);
    
    $stm = "SELECT userName FROM Student WHERE userName = ?";
    if ($sql = $conn->prepare($stm)) {
        $sql->bind_param("s", $_SESSION['user']);
        if ($sql->execute()) {
            $sql->bind_result($u);
            $sql->fetch();
            if ($u) {

                class listContent
                {

                    private $db_host = 'localhost';

                    private $db_name = 'cswebhosting';

                    private $db_user = 'cswebhosting';

                    private $db_pass = 'a9zEkajA';

                    private $conn = null;

                    private $db = null;

                    public function __construct()
                    {
                        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
                        if (! $this->conn) {
                            die('Could not connect: ' . mysqli_error());
                        } else {
                            $this->db = mysqli_select_db($this->conn, $this->db_name);
                            if (! $this->db) {
                                die('Could not connect: ' . mysqli_error());
                            }
                        }
                    }

                    public function __destruct()
                    {
                        $this->conn->close();
                        $this->conn = null;
                    }

                    // This function takes in username, firstname, lastname, studentnumber, email, school, major
                    public function displayContent($param1, $param2, $param3, $param4, $param5, $param6, $param7)
                    {
                        echo '<h2 id = "name">' . $param1 . '</h2>
				<table  id ="info">
				<thead>
					<tr>
						<th>Name</th>
						<th>Email</th>
						<th>School</th>
                         <th>Major</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>' . $param2 . ' ' . $param3 . '</td>
						<td>' . $param5 . '</td>
                        <td>' . $param6 . '</td>
                        <td>' . $param7 . '</td>
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

                    public function displayAllProjects($userName)
                    {
                        if ($this->conn != null) {
                            $stm = "SELECT p.projectId, p.projectTitle, pub.userName, p.date, p.projDesc, p.logoImage, p.author FROM Project AS p, Published AS pub WHERE p.projectId = pub.projectId AND pub.userName = ? GROUP BY pub.projectId ORDER BY p.date DESC";
                            if ($sql = $this->conn->prepare($stm)) {
                                $sql->bind_param("s", $userName);
                                if ($sql->execute()) {
                                    $sql->bind_result($id, $title, $u, $date, $desc, $logo,$author);
                                    $numOfProjects = 0;
                                    while ($sql->fetch()) {
                                        $numOfProjects = $numOfProjects + 1;
                                        $this->displayPContent($title, $u, $date, $desc, $logo, $id,$author);
                                    }
                                    if ($numOfProjects == 0) {
                                        echo "<p> No Projects from this user </p>";
                                        ?>
<link rel="stylesheet" type="text/css" href="CSS/footer0.css">
<?php
                                    }
                                    if ($numOfProjects == 1) {
                                        ?>
<link rel="stylesheet" type="text/css" href="CSS/footer1.css">
<?php
                                    }
                                    return true;
                                } else {
                                    $error = $this->conn->errno . ' ' . $this->conn->error;
                                    echo $error;
                                    return false;
                                }
                            } else {
                                $error = $this->conn->errno . ' ' . $this->conn->error;
                                echo $error;
                                return false;
                            }
                        } else {
                            return false;
                        }
                    }

                    public function displayPContent($title, $userName, $date, $desc, $logo, $id, $author)
                    {
                        echo "<a href=\"viewProject.php?projectId=$id\" style=\"\"><table class=\"project\" id=\"website\">" . "<caption>" . $title . "</caption>" . "<thead>" . "<tr>" . "<th class=\"textleft\"> By: " . $author . "</th>" . "<th class=\"textright\">" . $date . "</th>" . "</tr>" . "</thead>" . "<tbody>" . "<tr>" . "<td colspan=\"2\"><img src=\"data:image/png;base64," . base64_encode($logo) . "\"name=\"web\"class=\"images\" alt=\"logo here\" />" . "<p class=\"desc\">" . substr($desc, 0,1500) . "..." . "</p></td>" . "</tr>" . "</tbody>" . "<tfoot>
    <tr>
    <td colspan=\"2\">
    <p id=\"copyright\">Copyright &copy; " . $title . "</p>
    </td>
    </tr>
    </tfoot>
    </table></a>";
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
<?php include "header.php"?>

<div id="main">
		<div id="profileInfo">
<?php
                if (isset($_GET['user'])) {
                    $user = $_GET['user'];
                    $contentGet = new listContent();
                    
                    $result = $contentGet->query_userInfo($user);
                    $resultCheck = mysqli_num_rows($result);
                    
                    if ($resultCheck > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $contentGet->displayContent($row['userName'], $row['firstName'], $row['lastName'], $row['studentNum'], $row['email'], $row['school'], $row['major']);
                        }
                    } else
                        echo "Information not available at the moment!";
                    ?>
	</div>
		<div id="background">
			<h2>Projects:</h2>
			<div id="projects">

				<!-- 	display user project goes here -->
	<?php
                    $contentGet->displayAllProjects($user);
                    $contentGet = null;
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
<?php
        }
        else{
           $conn->close();
           ?>
<meta http-equiv="refresh" content="0; URL='Browse.php'" />
<?php
        }
        }
    }
}

?>


