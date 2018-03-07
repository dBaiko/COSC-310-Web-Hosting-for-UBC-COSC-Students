<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>CSPUB-Create A Project</title>
<link rel="stylesheet" type="text/css" href="CSS/Default.css">
<link rel="stylesheet" type="text/css" href="CSS/CreateAProject.css">
<script src="http://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="Javascript/jquery-3.1.1.min.js"></script>
<!--<script type="text/javascript" src="Javascript/CreateAProject.js"></script>-->
</head>
<body>
<header>
	<div class = "dropdown">
		<p> <img src = "Images/Bars.png" class = "icons"/> </p>
		<div class = "dropdown-content">
			<ul>
				<li> <a href = "home.html"> Home</a></li> 
				<li> <a href = "Portfolio.html">Portfolio</a></li> 
				<li> <a href = "Browse.html">Browse</a></li> 
				<li> <a href = "CreateAProject.html">Create A Project</a></li>
			</ul>
		</div>
	</div>
	<h1>CSPub</h1>
	<div class = "right">
		<a href = "home.html" ><img src = "Images/Home.png" alt = "Home" class = "icons"/></a>
		<a href = "notfication.html" ><img src = "Images/Notification.png" alt = "Notifications"class = "icons"/></a>
		<p class = "icons"><a href = "SignIn.html">Sign In</a></p>
	</div>
</header>

<div id="main">
		<form method = "post" action = "php/newProject.php" id = "create" enctype="multipart/form-data">
			<fieldset>
				<legend> Create a Project </legend>
					<p>
						<label>Title: </label>
						<input type = "text" name = "title" placeholder="Enter Project title" class = "required"/>
					</p>
			
						<label>Description: </label>
						<div id="description" >
							<textarea name="description" rows="15" cols ="80" class = "required"></textarea>
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
						<input type="file" accept=".pdf" onchange="addPdfFile(this)"/>
						</div>
					</div>
					<p id="pdfPreview">
					</p>
					<p>
						<label>Project Links: </label>
						<input type = "text" name = "link" placeholder="Project Links" name="pdfs[]"/>
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
				$("#pdfs").append("<div><input type=\"file\" accept=\".pdf\" onchange=\"addPdfFile(this)\" name=\"pics[]\"/></div>")
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

function addC(){
	if($("#moreC").prop('checked')){
		$("#contributors").append("<input type=\"text\" name=\"contributor[]\" class=\"cont\"/>");
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
	$("#contributors").append("<input type=\"text\" name=\"contributor[]\" class=\"cont\"/>");
	$("#contributors").append("<button type=\"button\" onclick=\"removeContributor(this);\" style=\"margin-right: 0.5em\">X</button>");
	$("#contributors").append("<button type=\"button\" onclick=\"addContributor();\" style=\"margin-right: 0.5em\">Add another</button>");
	numC++;
}

function removeContributor(e){
	$(e).next().remove();
	$(e).prev().remove();
	$(e).remove();
	numC--;
	if(numC == 0){
		$("#moreC").prop("checked", false);
	}
}

</script>
</html>