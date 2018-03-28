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
<title>CSPub ~ Sign In</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/SignIn.css">
<script src="Javascript/jquery-3.1.1.min.js"></script>
<script type="text/javascript" src="Javascript/SignInPage.js"></script>

</head>
<body>
<?php include "header.php"?>
	<div id="main">
	<section class = "central">
	<div>
		<h2>The Ultimate Project Database</h2>
	</div>
	<div id = "form"><form method = "post" action = "php/logUserIn.php" id="loginForm">
	<fieldset>
		<div>
		<p class = "info"> 
			<input id="username" type = "text" name = "username" placeholder = "Username" class = "info1" onChange="checkUser()"/>
		</p>
		<p id="warnUser" style="color: red;"></p>
		<p class = "info">
			<input id="password" type = "password" name = "password" placeholder = "Password" class = "info1" oninput="checkPass()"/>
		</p>
		<p id="warnPass" style="color: red;"></p>
		</div>
		<input type = "submit" class = "button" value = "Sign In" id="sub">
	</fieldset>
	</form>	
	</div>
	<div>
	<h3>WHAT? You are new to CSPub? <a href = "Register.php">Sign up</a> ASAP Then!</h3>
	</div>
	</section>
	</div>
<footer>
	<ul>
		<li class = "footerlinks"> <a href = "Browse.php">Browse</a>
	</ul>
	<p> Copyright &copy; 2018 CSPub</p>
</footer>
</body>
<script>
//$("#sub").prop('disabled', true);
var validUser = false;
var validPass = false;



function checkUser(){
	var user = $("#username").val();
	$.ajax({
		type: 'POST',
		url: 'php/checkUser.php',
		data: {'username': ''+user},
		success: function(responce){
			console.log(responce);
			if(responce==0){
				console.log(responce);
				//username does not extist
				$("#warnUser").html("Username does not exist");
				validUser = false;
			}
			else if (responce==1) {
				//userName exists
				$("#warnUser").html("");
				validUser = true;
			}
			else if(responce==2){
				//connection failed
				console.log("connection failed");
			}
			checkEnable();
		}
	});

}

function checkPass(){
	if(validUser === true){
		var pass = $("#password").val();
		var user = $("#username").val();
		$.ajax({
			type: 'POST',
			url: 'php/checkPass.php',
			data: {'pass': ''+pass, 'username': ''+user},
			success: function(responce){
				console.log(responce);
				if(responce==0){
					//username does not extist
					validPass = false;
				}
				else if (responce==1) {
					//userName exists
					$("#warnPass").html("");
					validPass = true;
				}
				else if(responce==2){
					//connection failed
					console.log("connection failed");
				}
				checkEnable();
			}
		});
	
	}
}

function checkEnable(){
	if(validUser == true && validPass == true){
		//$("#sub").prop("disabled", false)
	}
}

$("#loginForm").on("submit", function(e){
	e.preventDefault();
	checkUser();
	checkPass();
	if(validUser == true && validPass == true){
		$("#loginForm")[0].submit();
	}
	else if(validPass==false){
		$("#warnPass").html("Incorrect Password");
	}
});



</script>
</html>