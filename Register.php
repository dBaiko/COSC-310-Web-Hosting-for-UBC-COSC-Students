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
<title>CSPub ~ Register</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/Register.css">
<script src="Javascript/jquery-3.1.1.min.js"></script>
</head>
<body>
<?php include "header.php"?>
	<section class = "central">
	<div>
		<h2>The Ultimate Project Database</h2>
	</div>
	<div id = "form"><form id="signUpForm" method = "post" action = "php/newUser.php">
	<fieldset>
		<div>
		<p class = "info"> 
			<input type = "text" name = "username" id="username" placeholder = "Username" class = "info1" maxLength="30" onChange="checkUserName()"/>
		</p>
		<p class="info" id="taken" style="color: red;"></p>
		<p class = "info"> 
			<input type = "text" name = "firstName" id="firstName" placeholder = "First Name" class = "info1" maxLength="30"/>
		</p>
		<p class = "info"> 
			<input type = "text" name = "lastName" id="lastName" placeholder = "Last Name" class = "info1" maxLength="30"/>
		</p>
		<p class = "info">
			<input type = "email" name = "email" id="email" placeholder = "Email" class = "info1" maxLength="30"/>
		</p>
		<p class = "info">
			<input type = "password" name = "pass" id="pass" placeholder = "Password" class = "info1"/>
		</p>
		<p class = "info">
			<input type = "password" name = "passConf" id="passConf" placeholder = "Confirm Password" class = "info1"/>
		</p>
		<label>Are you a student or a professor? (Optional)</label><br>
		<input type="radio" name="userType" value= "student" id="student" onchange="addtoForm()">Student
		<input type="radio" name="userType" value= "prof"  id="prof" onchange="addtoForm()">Professor
		<span id="none"><input type="radio" name="userType" value= "none" onchange="addtoForm()">No</span><br>
		<div id="studentForm">
			<p class = "info"> 
				<input type = "text" name = "studentNum" id="studentNum" placeholder = "Student Number" class = "info1"  onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="8"/>
			</p>
			<p class = "info"> 
			<input type="text" name="stuSchool" list="sschool" id="stuSchool" class="info1" maxLength="255" placeholder="University"/>
			<datalist id="sschool">
                  <option>University of Britsh Columbia - Okanagan</option>
                  <option>University of British Columbia - Vancouver</option>
                  <option>Okanagan College - Vernon</option>
                  <option>Okanagan College - Kelowna</option>
            </datalist><br>
            <input type="text" name="major" id="major" list="m"  class="info1" maxLength="30" placeholder="Major"/>
			<datalist id="m">
                  <option>COSC</option>
            </datalist>
			</p>
		</div>
		<div id="profForm">
			<p class = "info"> 
			<input type="text" name="profSchool" id="profSchool" maxLength="255" list="pschool" class="info1" placeholder="University"/>
			<datalist id="pschool">
                  <option>University of Britsh Columbia - Okanagan</option>
                  <option>University of British Columbia - Vancouver</option>
                  <option>Okanagan College - Vernon</option>
                  <option>Okanagan College - Kelowna</option>
            </datalist><br>
            <input type="text" name="faculty" id="faculty" list="f" maxLength="30" class="info1" placeholder="Faculty"/>
			<datalist id="f">
                  <option>COSC</option>
            </datalist>
			</p>
		</div>
		<p class="info" id="warning" style="color: red;"></p>
		</div>
		<input type = "submit" class = "button" value = "Register">
	</fieldset>
	</form>	
	</div>
	<div>
	<h3>Already have an account? Great News!<a href = "SignIn.php"> Sign In </a>Now</h3>
	</div>
	</section>

<footer>
	<ul>
		<li class = "footerlinks"> <a href = "Browse.php">Browse</a>
	</ul>
	<p id = 'copy'> Copyright &copy; 2018 CSPub</p>
</footer>
</body>

<script type="text/javascript">
var validUser = false;
checkUserName();


$("#none").hide();
$("#studentForm").hide();
$("#profForm").hide();

addtoForm();

function checkUserName(){
	var user = $("#username").val();
	$.ajax({
		type: 'POST',
		url: 'php/checkUser.php',
		data: {'username': ''+user},
		success: function(responce){
			console.log(responce);
			if(responce==0){
				//username is valid
				console.log("username valid");
				$("#username").removeClass("error");
				$("#taken").html("");
				validUser = true;
			}
			else if (responce==1) {
				//userName is alreader taken
				$("#username").val("");
				$("#username").addClass("error");
				$("#taken").html("Username already taken");
				validUser = false;
			}
			else if(responce==2){
				//connection failed
				console.log("connection failed");
			}
		}
		});
}

function addtoForm(){
	if($("#student").is(":checked")){
		console.log("student");
		$("#none").show();
		$("#profForm").hide();
		$("#studentForm").show();
	}
	else if($("#prof").is(":checked")){
		console.log("prof");
		$("#none").show();
		$("#studentForm").hide();
		$("#profForm").show();
	}
	else if($("#none input").is(":checked")){
		console.log("none");
		$("#studentForm").hide();
		$("#profForm").hide();
	}

}

function highlightText(e) {
	if (e.val() == "") {
		e.addClass("error");
	} else {
		e.removeClass("error");
	}
}


$("#username").on("input", function(){
	highlightText($(this));
});

$("#firstName").on("input", function(){
	highlightText($(this));
});

$("#lastName").on("input", function(){
	highlightText($(this));
});

$("#email").on("input", function(){
	highlightText($(this));
});

$("#pass").on("input", function(){
	highlightText($(this));
});

$("#passConf").on("input", function(){
	highlightText($(this));
});

$("#studentNum").on("input", function(){
	highlightText($(this));
});

$("#stuSchool").on("input", function(){
	highlightText($(this));
});

$("#profSchool").on("input", function(){
	highlightText($(this));
});

$("#major").on("input", function(){
	highlightText($(this));
});

$("#faculty").on("input", function(){
	highlightText($(this));
});

$("#signUpForm").on("submit", function(e){
	console.log(validUser);
	e.preventDefault();
	$("#warning").html("");
	if($("#pass").val() == $("#passConf").val() && $("#pass").val() != null && $("#pass").val() != "" && $("#passConf").val() != null && $("#passConf").val() != ""){
		if($("#email").val().includes("@") && $("#email").val().includes(".") && $("#email").val() != null && $("#email").val() != ""){
			if($("#username").val() != null && $("#username").val() != "" && $("#firstName").val() != null && $("#firstName").val() != "" && $("#lastName").val() != null && $("#lastName").val() != ""){
				if($("#student").is(":checked")){
					if($("#stuSchool").val() != null && $("#stuSchool").val() != "" && $("#studentNum").val() != null && $("#studentNum").val() != "" && $("#major").val() != null && $("#major").val() != ""){
						if(validUser == true){
							$("#signUpForm")[0].submit();
						}
					}
					else{
						highlightText($("#username"));
						highlightText($("#firstName"));
						highlightText($("#lastName"));
						highlightText($("email"));
						highlightText($("#pass"));
						highlightText($("#passConf"));
						highlightText($("#stuSchool"));
						highlightText($("#studentNum"));
						highlightText($("#major"));
					}
				}
				else if($("#prof").is(":checked")){
					if($("#profSchool").val() != null && $("#profSchool").val() != "" && $("#faculty").val() != null && $("#faculty").val() != ""){
						if(validUser == true){
							$("#signUpForm")[0].submit();
						}
					}
					else{
						highlightText($("#username"));
						highlightText($("#firstName"));
						highlightText($("#lastName"));
						highlightText($("email"));
						highlightText($("#pass"));
						highlightText($("#passConf"));
						highlightText($("#profSchool"));
						highlightText($("#faculty"));
					}
				}
				else{
					if(validUser == true){
						$("#signUpForm")[0].submit();
					}
				}
			}
			else{
				highlightText($("#username"));
				highlightText($("#firstName"));
				highlightText($("#lastName"));
				highlightText($("email"));
				highlightText($("#pass"));
				highlightText($("#passConf"));
				highlightText($("#stuSchool"));
				highlightText($("#studentNum"));
				highlightText($("#major"));
				highlightText($("#profSchool"));
				highlightText($("#faculty"));
			}
			
		}
		else{
			highlightText($("email"));
			$("#warning").html("*Invalid email");
		}
	}
	else{
		highlightText($("#username"));
		highlightText($("#firstName"));
		highlightText($("#lastName"));
		highlightText($("email"));
		highlightText($("#pass"));
		highlightText($("#passConf"));
		highlightText($("#stuSchool"));
		highlightText($("#studentNum"));
		highlightText($("#major"));
		highlightText($("#profSchool"));
		highlightText($("#faculty"));
		if($("#pass").val() == null || $("#pass").val() == "")
			$("#warning").html("*The password cannont be empty");
		else
			$("#warning").html("*The passwords do not match");
	}
	
});
</script>

</html>