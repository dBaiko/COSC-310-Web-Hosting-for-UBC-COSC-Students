<?php
class projectVeiwer{
    
    //database attributes
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $conn = null;
    private $db = null;
    
    public function __construct(){
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
    
    public function __destruct(){
        $this->conn->close();
        $this->conn = null;
    }
    
    public function getLargestId(){
        if($this->conn != null){
            $stm = "SELECT projectId FROM Project ORDER BY projectId DESC LIMIT 1";
            if($sql = $this->conn->prepare($stm)){
                if($sql->execute()){
                    $id = null;
                    $sql->bind_result($id);
                    $sql->fetch();
                    $sql->close();
                    return $id;
                }else {
                    $sql->close();
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return null;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
                return null;
            }
        }
        
    }
    
    public function getProjectInfo($projectId){
        if($this->conn != null){
           
            $stm = "SELECT projectTitle, projDesc, demoUrl, date, projType, logoImage FROM Project WHERE projectId = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s", $projectId);
                if($sql->execute()){
                    $title = $desc =  $demoUrl = $date = $type = $logo = null;
                    $sql->bind_result($title, $desc, $demoUrl, $date, $type, $logo);
                    $sql->fetch();
                    $resultSet = array("projectTitle"=>$title, "projDesc"=>$desc, "demoUrl"=>$demoUrl, "date"=>$date, "projType"=>$type, "logoImage"=>$logo);
                    $sql->close();
                    return $resultSet;
                }else {
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return null;
                }
            }else {
                $sql->close();
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
                return null;
            }
            
        }
        else{
            return null;
        }
    }
    
    public function getContribInfo($projectId){
        if($this->conn != null){
            
            $stm = "SELECT userName FROM Published WHERE projectId = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s", $projectId);
                if($sql->execute()){
                    $sql->bind_result($u);
                    while($sql->fetch()){
                        echo " <a href='Portfolio.php?userName=".$u."'>".$u."</a> <br>";
                    }
                    $sql->close();
                    return false;                    
                }else {
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return false;
                }
            }else {
                $sql->close();
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
                return false;
            }
            
        }
        else{
            return false;
        }
    }
    
    public function getAuthor($projectId){
        if($this->conn != null){
            $stm = "SELECT userName FROM Published WHERE projectId = ? LIMIT 1";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$projectId);
                if($sql->execute()){
                    $sql->bind_result($u);
                    $sql->fetch();
                    $us = $u;
                    $sql->close();
                    return $us;
                }else {
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return null;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
                return null;
            }
        }
    }
    
    public function getPicFiles($projectId){
        if($this->conn != null){
            
            $stm = "SELECT file, fileName FROM Files WHERE projectId = ? AND (fileType = 'png' OR fileType = 'jpg' or fileType = 'jpeg')";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s", $projectId);
                if($sql->execute()){
                    $sql->bind_result($f,$n);
                    while($sql->fetch()){
                        ?>
                        <a href = 'php/viewPicture.php?projectId=<?php echo $projectId?>&fileName=<?php echo $n?>' ><img src = 'data:image/png;base64,<?php echo  base64_encode($f)?>' alt = 'Project Image' class = 'img'/></a>
                        <?php
                    }
                    $sql->close();
                    return true;
                }else {
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return null;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
                return null;
            }
            
        }
        else{
            return null;
        }
    }
    
    public function getPdfFiles($projectId){
        if($this->conn != null){
            
            $stm = "SELECT file, fileName FROM Files WHERE projectId = ? AND fileType = 'pdf'";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s", $projectId);
                if($sql->execute()){
                    $sql->bind_result($f, $n);
                    while($sql->fetch()){
                        ?>
                        <object data="data:application/pdf;base64,<?php echo base64_encode($f) ?>" type="application/pdf"></object><a href = 'php/viewPdf.php?projectId=<?php echo $projectId?>&fileName=<?php echo $n?>' ><button>View</button></a> 
                        <?php
                    }
                    $sql->close();
                    return true;
                }else {
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return null;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
                return null;
            }
            
        }
        else{
            return null;
        }
    }
    
    
}
//error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
if(isset($_SESSION['user'])){
    $user = $_SESSION["user"];
}


if(isset($_SERVER["REQUEST_METHOD"])){//to prevent code running during testing
  
    $projViewer = new projectVeiwer();
    $projInfo = null;
    $id = null;
    if(isset($_GET['projectId'])){
        $id = $_GET['projectId'];
        if(is_numeric($id)){
            if($id <= $projViewer->getLargestId()){
                $projInfo = $projViewer->getProjectInfo($id);
            }else{
               echo $projViewer->getLargestId();
                $projViewer = null;
                ?>
        		<meta http-equiv="refresh" content="0; URL='Browse.php'" />
        		<?php
            }
        }else{
            $projViewer = null;
            ?>
        	<meta http-equiv="refresh" content="0; URL='Browse.php'" />
        	<?php
        }
    }
    else{
        $projViewer = null;
        ?>
        <meta http-equiv="refresh" content="0; URL='Browse.php'" />
        <?php
    }
    
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
<?php include "header.php"?>
<div id="main">
	<article id="Project1">
		<?php 
		if(isset($_SESSION['user'])){
    		if($projViewer->getAuthor($id) == $user){
    		    ?>
    		    <a href="editProject.php?projectId=<?php echo $id;?>"><button style="float: right;">Edit this project</button></a>
    		    <?php
    		}
		}
		?>
		<table class = "Project">
			<caption id = "title"><h2 ><?php echo $projInfo['projectTitle']?></h2></caption>
			<thead>
				<tr>
					<th><img class="blogImg" src="data:image/png;base64,<?php echo base64_encode($projInfo['logoImage'])?>" alt="blog picture" width="30%"></th>
					<th> Contributors:<br> 
					<?php 
					$projViewer->getContribInfo($id);
					?>
					</th>
					<th>Publish Date: <br><?php echo substr($projInfo['date'],0,strpos($projInfo['date'], ' '))?></th> 
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan = "3">
						<p id = "desc"><?php echo $projInfo['projDesc']?></p>
					</td>
				<tr>
					<?php 
					if($projInfo['demoUrl'] != ""){
					    if(strpos($projInfo['demoUrl'], "http") !== false){
					        ?>
					   		<td>
							<p id = "links">Demo Link: <a href ="<?php echo $projInfo['demoUrl']?>"><?php echo $projInfo['demoUrl']?></a> </p>
							</td>
					   <?php
					    }else{
					   ?>
					   <td>
						<p id = "links">Demo Link: <a href ="http://<?php echo $projInfo['demoUrl']?>"><?php echo $projInfo['demoUrl']?></a> </p>
						</td>
					   <?php
					    }
					}
					?>
				</tr>
			</tbody>
		</table>
	</article>
<div id = "extraImages">
	<table class = "Project">
	<caption>Additional Images:</caption>
		<tr>
			<td>
				<?php 
	            $projViewer->getPicFiles($id);
	            ?>
            </td>
		<tr>
	</table>
</div>
<div id = "extraImages">
	<table class = "Project">
	<caption>Additional Files:</caption>
		<tr>
			<td>
                	<?php 
                	$projViewer->getPdfFiles($id);
                	?>
	 		</td>
		<tr>
	</table>
</div>
	<p id = "copyright"> Copyright &copy; 2018 <?php echo $projInfo['projectTitle']?>  </p>
</div>



<footer>
	<ul>
		<li class = "footerlinks"> <a href = "Browse.php">Browse</a>
	</ul>
	<p> Copyright &copy; 2018 CSPub</p>
</footer>
</body>
</html>
  <?php  
}
?>
