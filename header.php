<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

?>
<header>
	<a href="Browse.php"><h1>CSPub</h1></a>
	<div class="right">
		<?php
if (isset($_SESSION["user"])) {
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
                ?>
    			<p id='signIn'>
					<a href='php/logUserOut.php'>Log Out</a>
				</p>
				<div class="dropdown">
					<p id="dropimg">
						<img src="Images/Bars.png" class="icons" />
					</p>
					<div class="dropdown-content">
						<ul>
							<li><a href="Portfolio.php?user=<?php echo $u?>">Portfolio</a></li>
							<li><a href="Browse.php">Browse</a></li>
							<li><a href="CreateAProject.php">Create A Project</a></li>
							<li><a href="yourAccount.php">Your account</a></li>
						</ul>
					</div>
				</div>
		    	<?php
            } else {
                ?>
    			<p id='signIn'>
					<a href='php/logUserOut.php'>Log Out</a>
				</p>
				<div class="dropdown">
					<p id="dropimg">
						<img src="Images/Bars.png" class="icons" />
					</p>
					<div class="dropdown-content">
						<ul>
							<li><a href="Browse.php">Browse</a></li>
							<li><a href="yourAccount.php">Your account</a></li>
						</ul>
					</div>
				</div>
		    <?php
            }
        } else {
            $error = $this->conn->errno . ' ' . $this->conn->error;
            echo $error;
        }
    } else {
        $error = $this->conn->errno . ' ' . $this->conn->error;
        echo $error;
    }
} else {
    ?>
    	<p id='signIn'>
			<a href='SignIn.php'>Sign In</a>
		</p>
    <?php
}
?>
	</div>
</header>