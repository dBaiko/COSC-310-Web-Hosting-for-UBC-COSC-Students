<?php
session_start();
if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
}
?>
<?php 
if(isset($_SESSION['user'])){
    ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CSPUB-Create A Project</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/CreateAProject.css">
<script src="Javascript/jquery-3.1.1.min.js"></script>
<!--<script type="text/javascript" src="Javascript/CreateAProject.js"></script>-->
</head>
<body>
<?php echo "<p id=\"u\" style=\"display:none;\">".$user."</p>";?>
<header>
<h1>CSPub</h1>
<div class = "right">
		<?php 
		if(isset($_SESSION["user"])){
		    echo "<p id = 'signIn'><a href = 'php/logUserOut.php'>Log Out</a></p>";
		    ?>
		    <div class = "dropdown">
		<p id = "dropimg"> <img src = "Images/Bars.png" class = "icons"/> </p>
		<div class = "dropdown-content">
			<ul>					
				<li> <a href = "Portfolio.php">Portfolio</a></li> 
				<li> <a href = "Browse.php">Browse</a></li> 
				<li> <a href = "CreateAProject.php">Create A Project</a></li>
			</ul>
		</div>
	</div>
		    <?php
		}
		else{
		    echo "<p id = 'signIn'><a href = 'SignIn.php'>Sign In</a></p>";
		}
		?>
	</div>
</header>

<div id="main">
		<form method = "post" action = "php/newProject.php" id = "create" enctype="multipart/form-data">
			<fieldset>
				<legend> Create a Project </legend>
					<p>
						<label>Title: </label>
						<input type = "text" name = "title" placeholder="Enter Project title" class = "required" id="title"/>
					</p>
			
						<label>Description: </label>
						<div id="description" >
							<textarea name="description" rows="15" cols ="80" class = "required" id="desc"></textarea>
						</div>
					<p>
						<label>Any other contributors?</label>
						<input type="checkbox" id="moreC" onclick="addC()"/>
					</p>
					<p id="contributors">
					</p>
					<div id = "pics">
						<label>Images (PNG, JPG, JPEG):</label><br>
						<div>
						<input type="file" accept=".png, .jpg, .jpeg" onchange="addPicFile(this)" name="pics[]"/>
						</div>
					</div>
					<div id="pdfs">
						<label>Additional Documents (PDF only):</label>
						<div>
						<input type="file" accept=".pdf" onchange="addPdfFile(this)" name="pdfs[]"/>
						</div>
					</div>
					<p id="pdfPreview">
					</p>
					<p>
						<label>Project Links (GitHub, Youtube Demos etc.): </label>
						<input type = "text" name = "link" placeholder="Project Links" />
					</p>
					<p>
						<label>Project Type:</label>
						<select name="projType" class="required" id="type">
							<option value="" disabled selected>Select your option</option>
							<option>Web Development</option>
							<option>Mobile Application</option>
							<option>Data Science</option>
							<option>Object Oriented Programs (Java, C# etc.)</option>
							<option>Robotics/Arduino/Raspberry Pi</option>
							<option>Biology Technology</option>
							<option>Parallel Computing</option>
							<option>Games</option>
							<option>Virtual Reality</option>
							<option>3D Modeling/Printing</option>
							<option>Math/Optimization</option>
							<option>Algorithm Development</option>
							<option>Other</option>
						</select>
					</p>
					
					<p id = "center">
						<input type = "submit" value = "Create"/>
					</p>
			</fieldset>
			</form>
	</div>
	
<footer>
	<ul>
		<li class = "footerlinks"> <a href = "home.html">Home</a>
		<li class = "footerlinks"> <a href = "About.html">About</a> </li>
	</ul>
	<p> Copyright &copy; 2018 CSPub</p>
</footer>
</body>
<script>
numPdf = 0;

function addPdfFile(e){
	var file = e.files[0];
	if(checkPdfFile(file) == true){
		var reader = new FileReader();
		
		reader.onload = function(em){
			if($(e).next().next().length){
				console.log("what");
				$(e).next().next().attr("data", em.target.result);
			}
			else{
				$(e).parent().append("<button type=\"button\" onclick=\"removePdf(this)\">X</button><object data=\""+em.target.result+"\"type=\"application/pdf\" style=\"height:50%;width:30%\"></object>");
				$("#pdfs").append("<div><input type=\"file\" accept=\".pdf\" onchange=\"addPdfFile(this)\" name=\"pdfs[]\"/></div>")
			}
			
		}
		
		reader.readAsDataURL(file);
	}
	else{
		$(e).val("");
	}
	numPdf++;
	
}

function checkPdfFile(file){
	if(!file)
		return false;
	var correct = false;
	var name = file.name;
	var type = name.split(".")[1];
	if(type == "pdf"){
		return true;
	}
	else{
		alert("Please only choose PNG or JPG file type");
		return false;
	}
	
}


function removePdf(e){
	console.log("het");
	$(e).prev().val("");
	$(e).parent().remove();
	numPdf--;
}



numPic = 0;

function addPicFile(e){
	var file = e.files[0];
	if(checkPicFile(file) == true){
		var reader = new FileReader();
		
		reader.onload = function(em){
			if($(e).next().next().length){
				console.log("what");
				$(e).next().next().attr("src", em.target.result);
			}
			else{
				$(e).parent().append("<button type=\"button\" onclick=\"removePic(this)\">X</button><img src=\""+em.target.result+"\" style=\"width:30%;\" style=\"display:block;\"/>");
				$("#pics").append("<div><input type=\"file\" accept=\".png, .jpg, .jpeg\" onchange=\"addPicFile(this)\" name=\"pics[]\"/></div>")
			}
			
		}
		
		reader.readAsDataURL(file);
	}
	else{
		$(e).val("");
	}
	numPic++;
}

function removePic(e){
	console.log("het");
	$(e).prev().val("");
	$(e).parent().remove();
	numPic--;
}

function checkPicFile(file){
	if(!file)
		return false;
	var correct = false;
	var name = file.name;
	var type = name.split(".")[1];
	if(type == "jpg" || type == "png" || type == "jpeg"){
		return true;
	}
	else{
		alert("Please only choose PNG or JPG file type");
		return false;
	}
	
}



var numC = 0;
var contrib = [];

function addC(){
	if($("#moreC").prop('checked')){
		$("#contributors").append("<input type=\"text\" name=\"contributor[]\" class=\"cont\" onchange=\"checkUser(this)\"/>");
		$("#contributors").append("<span></span>")
		$("#contributors").append("<button type=\"button\" onclick=\"removeContributor(this);\" class=\"cont\">X</button>");
		$("#contributors").append("<button type=\"button\" onclick=\"addContributor();\" class=\"cont\">Add another</button>");
		numC++;
	}
	else if($("#moreC").prop('checked') == false){
		$("#contributors").empty();
		numC = 0;
	}
}

function addContributor(){
	$("#contributors").append("<input type=\"text\" name=\"contributor[]\" class=\"cont\" onchange=\"checkUser(this)\"/>");
	$("#contributors").append("<span></span>");
	$("#contributors").append("<button type=\"button\" onclick=\"removeContributor(this);\" style=\"margin-right: 0.5em\">X</button>");
	$("#contributors").append("<button type=\"button\" onclick=\"addContributor();\" style=\"margin-right: 0.5em\">Add another</button>");
	numC++;
}

function removeContributor(e){
	$(e).next().remove();
	$(e).prev().remove();
	$(e).prev().remove();
	$(e).remove();
	numC--;
	var index = contrib.indexOf($(e).val());
	contrib.splice(index, 1);
	if(numC == 0){
		$("#moreC").prop("checked", false);
	}
}



function checkUser(e){
	var user = $(e).val();
	$.ajax({
		type: 'POST',
		url: 'php/checkUser2.php',
		data: {'username': ''+user},
		success: function(responce){
			console.log(responce);
			if(responce==0){
				
				//username does not extist
				$(e).next().html("Username does not exist or User is not a student");
				$(e).val("");
				validUser = false;
			}
			else if (responce==1) {
				//userName exists
				var foundUser = false;
				if(contrib.includes(user)){
					foundUser = true;	
				}
				if(user == $("#u").html()){
					$(e).next().html("Cannot add yourself");
					$(e).val("");
					validUser = false;
				}
				else if(foundUser == true){
					$(e).next().html("Cannot add the same user twice");
					$(e).val("")
					validUser = false;
				}
				else{
					$(e).next().html("");
					validUser = true;
					contrib.push(user);
				}	
				
				
			}
			else if(responce==2){
				//connection failed
				console.log("connection failed");
			}
		}
	});
	
}

function highlightText(e) {
	if (e.val() == "") {
		e.addClass("empty");
	} else {
		e.removeClass("empty");
	}
}

function highlightDrop(e) {
	if (e.val() == "" || e.val() == null) {
		e.addClass("empty");
	} else {
		e.removeClass("empty");
	}
}


$("#title").on("input", function(){
	highlightText($(this));
});

$("#desc").on("input", function(){
	highlightText($(this));
});


$("#type").on("change", function(){
	highlightDrop($(this));
});

$("#create").on("submit",function(e){
	e.preventDefault();
	if($("#title").val() != "" && $("#title").val() != "" && $("#desc").val() != null && $("#desc").val() != "" && $("#type").val() != null && $("#type").val() != ""){
		console.log("true");
		$("#create")[0].submit();
	}
	else{
		console.log("false");
		highlightText($("#title"));
		highlightText($("#desc"));
		highlightDrop($("#type"));
	}	
});



</script>
</html>    
    <?php  
}
else{
    ?>
    <meta http-equiv="refresh" content="0; URL='Browse.php'"/>
    <?php
}
?>
