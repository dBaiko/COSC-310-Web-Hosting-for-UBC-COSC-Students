<?php
class projectInfo{
    
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
                    $c = array();
                    while($sql->fetch()){
                        array_push($c, $u);
                    }
                    $sql->close();
                    return $c;
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
            
            $stm = "SELECT fileName, file FROM Files WHERE projectId = ? AND (fileType = 'png' OR fileType = 'jpg' or fileType = 'jpeg')";
            if($sql = $this->conn->prepare($stm)){
                $sql->bind_param("s", $projectId);
                if($sql->execute()){
                    $sql->bind_result($n, $f);
                    while($sql->fetch()){
                        ?>
                        <button type="button" onclick="removeOrigonal(this)">X</button>
                        <img src = 'data:image/png;base64,<?php echo  base64_encode($f)?>' alt = 'Project Image'  style="width: 30%; display: block;"/>
                        <input type="hidden" name="hiddenFileNames[]" value="<?php echo $n;?>"/>
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
                        <button type="button" onclick="removeOrigonal(this)">X</button>
                        <object style="display: block;" data="data:application/pdf;base64,<?php echo base64_encode($f) ?>" type="application/pdf"></object>
                        <input type="hidden" name="hiddenFileNames[]" value="<?php echo $n;?>"/>
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

ini_set('display_errors', 1);
session_start();

if(isset($_SERVER["REQUEST_METHOD"])){
    
    if(isset($_SESSION['user'])){
        $user = $_SESSION['user'];
        $project = new projectInfo();
        $projInfo = null;
        $id = null;
        if(isset($_GET['projectId'])){
            $id = $_GET['projectId'];
            if(is_numeric($id)){
                if($id <= $project->getLargestId()){
                    $projInfo = $project->getProjectInfo($id);
                }else{
                    echo $project->getLargestId();
                    $projViewer = null;
                    ?>
        		<meta http-equiv="refresh" content="0; URL='Browse.php'" />
        		<?php
            }
        }else{
            $project = null;
            ?>
        	<meta http-equiv="refresh" content="0; URL='Browse.php'" />
        	<?php
        }
    }
    else{
        $project = null;
        ?>
        <meta http-equiv="refresh" content="0; URL='Browse.php'" />
        <?php
    }
        ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>CSPUB-Create A Project</title>
        <link rel="stylesheet" type="text/css" href="CSS/Default.css">
        <link rel="stylesheet" type="text/css" href="CSS/CreateAProject.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="Javascript/jquery-3.1.1.min.js"></script>
    </head>
	<body>
		<?php echo "<p id=\"u\" style=\"display:none;\">".$user."</p>";?>
		<?php include "header.php"?>

    <div id="main">
    		<form method = "post" action = "php/updateProject.php" id = "create" enctype="multipart/form-data">
    			<fieldset>
    				<legend> Edit Project </legend>
    					<p>
    						<input type="hidden" value="<?php echo $projInfo['date'];?>" name="date">
    						<input type="hidden" value="<?php echo $id;?>" name="projectId">
    						<label>Title: </label>
    						<input type = "text" name = "title" class = "required" id="title" value="<?php echo $projInfo['projectTitle'];?>"/>
    					</p>
    			
    						<label>Description: </label>
    						<div id="description" >
    							<textarea name="description" rows="15" cols ="80" class = "required" id="desc"><?php echo $projInfo['projDesc'];?></textarea>
    						</div>
    					<p>
    						<label>Contributors:</label><br>
    						<?php 
    						$con = $project->getContribInfo($id);
    						array_shift($con);
    						if(sizeof($con) > 0){
    						    foreach ($con as $x){
    						        ?>
    						        <input type="hidden" value="<?php echo $x;?>" name="oldContribs[]">
    						        <input type="text" value="<?php echo $x;?>" disabled="disabled"/>
    						        <button type="button" onclick="removeC(this)">X</button>
    						        <?php
    						    }
    						    ?>
    						    <br><label>Any other contributors?</label>
    							<input type="checkbox" id="moreC" onclick="addC()"/>
    						    <?php
    						}
    						else{
    						  ?>
    						  <label>Any other contributors?</label>
    						  <input type="checkbox" id="moreC" onclick="addC()"/>
    						  <?php
    						}
    						
    						?>
    						
    					</p>
    					<p id="contributors">
    					</p>
    					<div>
    						<label>Logo Image (The main image or logo to be displayed with your project):</label><br>
    						<img src = 'data:image/png;base64,<?php echo  base64_encode($projInfo['logoImage'])?>' alt = 'Project Image' id="logo" width="25%"/><br>
    						<input type="file" accept=".png, .jpg, .jpeg" onchange="previewFile(this)" name="logo" />
    						<button  type="button" onclick="remove(this)">Remove</button>
    					</div>
    					<div id = "pics">
    						<label>Images (PNG, JPG, JPEG):</label><br>
    						<?php $project->getPicFiles($id)?>
    						<div>
    						<input type="file" accept=".png, .jpg, .jpeg" onchange="addPicFile(this)" name="pics[]"/>
    						</div>
    					</div>
    					<div id="pdfs">
    						<label>Additional Documents (PDF only):</label><br>
    						<?php $project->getPdfFiles($id)?>
    						<div>
    						<input type="file" accept=".pdf" onchange="addPdfFile(this)" name="pdfs[]"/>
    						</div>
    					</div>
    					<p id="pdfPreview">
    					</p>
    					<p>
    						<label>Project Links (GitHub, Youtube Demos etc.): </label>
    						<input type = "text" name = "link" value="<?php echo $projInfo['demoUrl']?>" />
    					</p>
    					<p>
    						<label>Project Type:</label>
    						<select name="projType" class="required" id="type">
    							<?php 
    							$options = array("Web Development", "Mobile Application", "Data Science" , "Object Oriented Programs (Java, C# etc.)", "Robotics/Arduino/Raspberry Pi", "Biology Technology",
    							    "Parallel Computing", "Games", "Virtual Reality", "3D Modeling/Printing", "Math/Optimization", "Algorithm Development", "Other");
    							foreach ($options as $x){
    							    if($x == $projInfo['projType']){
    							        echo "<option selected>".$x."</option>";
    							    }
    							    else{
    							        echo "<option>".$x."</option>";
    							    }
    							}
    							?>
    						</select>
    					</p>
    					
    					<p id = "center">
    						<input type = "submit" value = "Save"/>
    					</p>
    			</fieldset>
    			</form>
    			<form action="php/deleteProject.php" method="post" id="delete" >
        			<input type="hidden" value="<?php echo $id;?>" name="delId"/>
           			<button class="changeButton" onclick="deleteAccount(this)">Delete Project</button>
        		</form>
    	</div>
    	
    	<footer>
    		<ul>
    			<li class="footerlinks"><a href="Browse.php">Browse</a></li>
    		</ul>
    		<p>Copyright &copy; 2018 CSPub</p>
    	</footer>
	</body>
<script>
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

function removeC(e){
	$(e).prev().prev().remove();
	$(e).prev().remove();
	$(e).remove();
}

function previewFile(e) {
	var file    = document.querySelector('input[name=logo]').files[0];  
	if(checkFileType(file) == true){
    	  var preview = document.querySelector('#logo');
    	  
    	  var reader  = new FileReader();

    	  reader.onloadend = function () {
    	    preview.src = reader.result;
    	  }

    	  if (file) {
    	    reader.readAsDataURL(file);
    	  } else {
    	    preview.src = "Images/default.png";
    	  }
	  }
	else{
		document.querySelector('input[name=logo]').value = "";
	}
	}
function remove(e){
	var preview = document.querySelector('#logo');
	preview.src = "Images/default.png";
	document.querySelector('input[name=logo]').value = "";
	$(e).after("<input name='removed' value='true' hidden='hidden'/>");
}
function checkFileType(file){
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

function removeOrigonal(e){
	$(e).next().next().remove();
	$(e).next().remove();
	$(e).remove();
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
        header('Location: Browse.php');
    }
    
}