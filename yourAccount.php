<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}


class userInfo{
    private $db_host = 'localhost';
    private $db_name = 'cswebhosting';
    private $db_user = 'cswebhosting';
    private $db_pass = 'a9zEkajA';
    private $conn = null;
    private $db = null;
    
    
    public function __construct() {
        $this->conn = mysqli_connect($this->db_host, $this->db_user, $this->db_pass);
        if(!$this->conn){
            die('Could not connect: ' .mysqli_error());
        }
        else{
            $this->db = mysqli_select_db($this->conn, $this->db_name);
            if(!$this->db){
                die('Could not connect: ' .mysqli_error());
            }
        }
    }
    
    public function __destruct(){
        $this->conn->close();
        $this->conn = null;
    }
    
    public function getBasicInfo($userName){
        if($this->conn != null){
            
            $userName = chop($userName);
            $userName = mysqli_real_escape_string($this->conn, $userName);
            
            $stm = "SELECT userName, firstName, lastName, email FROM User WHERE userName = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$userName);
                if($sql->execute()){
                    $sql->bind_result($u,$f,$l,$e);
                    $sql->fetch();
                    $toReturn = array("userName"=>$u,"firstName"=>$f,"lastName"=>$l,"email"=>$e);
                    $sql->close();
                    return $toReturn;
                }else {
                    $sql->close();
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return false;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
                return false;
            }
            
        }
        else{
            return false;
        }
    }
    
    public function getStudentInfo($userName){
        if($this->conn != null){
            
            $userName = chop($userName);
            $userName = mysqli_real_escape_string($this->conn, $userName);
            
            $stm = "SELECT studentNum, school, major FROM Student WHERE userName = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$userName);
                if($sql->execute()){
                    $sql->bind_result($n,$s,$m);
                    if($sql->fetch()){
                        $toReturn = array("studentNum"=>$n,"school"=>$s,"major"=>$m);
                        $sql->close();
                        return $toReturn;
                    }
                    else{
                        $sql->close();
                        return false;
                    }
                    
                }else {
                    $sql->close();
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return false;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
                return false;
            }
            
        }
        else{
            return false;
        }
    }
    
    public function getProfInfo($userName){
        if($this->conn != null){
            
            $userName = chop($userName);
            $userName = mysqli_real_escape_string($this->conn, $userName);
            
            $stm = "SELECT faculty, school FROM Professor WHERE userName = ?";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s",$userName);
                if($sql->execute()){
                    $sql->bind_result($f,$s);
                    if($sql->fetch()){
                        $toReturn = array("faculty"=>$f,"school"=>$s);
                        $sql->close();
                        return $toReturn;
                    }
                    else{
                        $sql->close();
                        return false;
                    }
                    
                }else {
                    $sql->close();
                    $error = $this->conn->errno . ' ' . $this->conn->error;
                    echo $error;
                    return false;
                }
            }else {
                $error = $this->conn->errno . ' ' . $this->conn->error;
                echo $error;
                return false;
            }
            
        }
        else{
            return false;
        }
    }
    
    
    
}


if(isset($_SERVER["REQUEST_METHOD"])){
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $info = new userInfo();
        $basic = $info->getBasicInfo($user);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CSPUB Your Account</title>
        <link rel="stylesheet" type="text/css" href="CSS/Default.css">
        <link rel="stylesheet" type="text/css" href="CSS/youraccount.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="Javascript/jquery-3.1.1.min.js"></script>
    </head>
	<body>
	<?php include 'header.php';?>
	<!-- ATTN: KARANMEET/DARRIEN
	       When styling this page, it is important that you do not change id's or change the structure of
	       the html inside the div's or remove the empty span tag's. The JavaScript methods in the script
	       at the bottom rely on the dom tree inside the div's being in the structure that they are
	       and if that structure is changed the methods will break. You can change the parent structure in any way
	       if needed, just as long as the divs and everything inside them keeps the same id, names, and structure
	       
	       Also keep in mind when styling that although the span tags are empty now, Javascript will fill them with
	       "Updated successfully" messages when the user clicks any of the buttons. So keep that in mind when figuring out
	       spacing and what not.
	 -->
	<fieldset>
		<legend>Account Info For User: <span id="user"><?php echo $basic['userName']?></span></legend>
		
		<div class = "input1">
		<div>
    		<label>First Name: </label>
    		<input class=""type="text" name="firstName" maxLength="30" value="<?php echo $basic['firstName'];?>">
    		<button class="changeButton2" onclick="update(this)">Change First Name</button><span></span><br>
    	</div>	
		
		<div>
    		<label>Last Name: </label>
    		<input class="" type="text" name="lastName" maxLength="30" value="<?php echo $basic['lastName'];?>">
    		<button class="changeButton2" onclick="update(this)">Change Last Name</button><span></span><br>
    	</div>	
		
		<div>
			<label>Email: </label>
			<input  type="text" name="email"  value="<?php echo $basic['email'];?>">
			<button class="changeButton2" onclick="update(this)">Change Email</button><span></span><br>
		</div>	
		</div>
		<br>
		
		<div class = "input1">
		<div>	
			<label>Old Password: </label>
			<input class="" type="password" id="oldPass" name="oldPass" onchange="checkPass()"><span></span><br>
			<label>New Password: </label>
			<input class="" type="password" id="password" name="password" onchange="checkPassMatch()"><br>
			<label>Password Confirm: </label>
			<input class="" type="password" id="passConf" name="passConf" onchange="checkPassMatch()">
			<button class="changeButton2" onclick="changePassword(this)">Change Password</button><span id="passWarn"></span><br>
		</div>
		</div>
		<br>
		
		<?php 
		if($student = $info->getStudentInfo($user)){
		?>
		<p id = "info">Student info:</p>
		<div class = "input1">
		<div>
			<label>Student Number: </label>
        	<input class="" type="text" name="studentNum" maxLength="8" onkeypress='return event.charCode >= 48 && event.charCode <= 57' value="<?php echo $student['studentNum'];?>">
        	<button class="changeButton2" onclick="update(this)">Change SN#</button><span></span><br>
		</div>
		
		<div>
			<label>School: </label>
    		<input class="" type="text" name="schoolS"  value="<?php echo $student['school'];?>">
    		<button class="changeButton2" onclick="update(this)">Change School</button><span></span><br>
		</div>
		
		<div>
			<label>Major: </label>
    		<input class="" type="text" name="major"  value="<?php echo $student['major'];?>">
    		<button class="changeButton2" onclick="update(this)">Change Major</button><span></span><br>
		</div>
		</div>
		<?php
		}
		else if($prof = $info->getProfInfo($user)){
		?>
		<p id = "info">Professor info:</p>
		<div class = "input1">
		<div>
			<label>Faculty: </label>
    		<input class="" type="text" name="faculty"  value="<?php echo $prof['faculty'];?>">
    		<button class="changeButton2" onclick="update(this)">Change Student Number</button><span></span><br>
		</div>
		
		<div>
			<label>School: </label>
    		<input class="" type="text" name="schoolP"  value="<?php echo $prof['school'];?>">
    		<button class="changeButton2" onclick="update(this)">Change School</button><span></span><br>
		</div>
		</div>
		<?php
		}
		
		?>
		
		<br>
		
		<form action="php/deleteAccount.php" id="delete" >
        	<input type="hidden" value="<?php echo $user?>"/>
           	<button class="changeButton" style="background: " onclick="deleteAccount(this)">Delete Account</button>
        </form>
		<?php
		
		$info = null;
		?>
	
	</fieldset>
	</body>
	<script type="text/javascript">

	$("#delete").on("submit",function(e){
		e.preventDefault();
        });

	function deleteAccount(e){
		$(e).after("<label>Are you sure?</label>");
		$(e).next().after("<button class \"changeButton\" onclick=\"yesDelete(this)\">Yes</button>");
		$(e).next().next().after("<button class \"changeButton\" onclick=\"noDelete(this)\">No</button>");
	}

	function noDelete(e){
		$(e).prev().prev().remove();
		$(e).prev().remove();
		$(e).remove();
	}

	function yesDelete(e){
		$("#delete")[0].submit();
	}

	var oldPassCorrect = false;

	function checkPassMatch(){
		if(oldPassCorrect){
			var password = $("#password").val();
			var passConf = $("#passConf").val();
			if(password == passConf){
				$("#passWarn").html("");
			}
			else{
				$("#passWarn").html("Passwords do not match");
			}
		}
	}


	function changePassword(e){
		checkPass();
		if(oldPassCorrect){

			var password = $("#password").val();
			var passConf = $("#passConf").val();

			if(password == passConf){

				update($(e).prev().prev().prev());
				$("#password").val("");
				$("#passConf").val("");
				$("#oldPass").val("");
				
			}
			else{

				$("#passWarn").html("Passwords do not match");
				
			}

		}
	}

	function checkPass(){
			var pass = $("#oldPass").val();
			var user = $("#user").html();
			$.ajax({
				type: 'POST',
				url: 'php/checkPass.php',
				data: {'pass': ''+pass, 'username': ''+user},
				success: function(responce){
					console.log(responce);
					if(responce==0){
						oldPassCorrect = false;
						$("#passWarn").html("Old Password Incorrect");
					}
					else if (responce==1) {
						var password = $("#password").val();
						var passConf = $("#passConf").val();
						if(password == passConf){
							$("#passWarn").html("");
						}
						else{
							$("#passWarn").html("Passwords do not match");
						}
						oldPassCorrect = true;
					}
					else if(responce==2){
						//connection failed
						console.log("connection failed");
					}
				}
			});
		
	}

	function update(e){
		var toUpdate = $(e).prev().prop('name');
		toUpdate = toUpdate.trim();
		var changeVal = $(e).prev().val();
		changeVal = changeVal.trim();
		var userToChange = $("#user").html();
		userToChange = userToChange.trim();
		var canUpdate = true;
			$.ajax({
        		type: 'POST',
        		url: 'php/updateUser.php',
        		data: {'username': ''+userToChange, 'toUpdate': ''+toUpdate, 'changeVal': ''+changeVal},
        		success: function(responce){
        			console.log(responce);
        			if(responce==0){
            			if(toUpdate == "password"){
							$("#passWarn").html("Not updated successfully");
                		}
            			else{
            				$(e).next().html("Not updated successfully")
            			}
        				
        			}
        			else if (responce==1) {
        				if(toUpdate == "password"){
							$("#passWarn").html("Updated successfully");
                		}
            			else{
            				$(e).next().html("Updated successfully")
            			}
    				}
        			else if(responce==2){
        				//connection failed
        				console.log("connection failed");
        			}
        		}
        	});
	}
	

	</script>
</html>
<?php
    }else{
        ?>
    <meta http-equiv="refresh" content="0; URL='browse.php'" />
    <?php 
}
}
?>