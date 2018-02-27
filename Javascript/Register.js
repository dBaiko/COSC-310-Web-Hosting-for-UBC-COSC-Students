window.onload = function() {
	document.getElementById('form').addEventListener('submit',function(event){
		var signup;
		signup = document.getElementsByClassName("info1");
		for (var i = 0; i < signup.length; i++) {
			if (signup[i].value == null || signup[i].value == "") {
				event.preventDefault();
				emptySpace(signup[i]);
			}
		}
		var password = signup[2];
		var confirm = signup[3];
		if(password != confirm){
			event.preventDefault();
			alert("Password do not Match");
		}
	});
	
	var values = document.getElementsByClassName("info1");
	function emptySpace(e){
		if(e.value == "" )
			e.classList.add("error");//adding if its empty
		else
			e.classList.remove("error");//removing if its not
	}
	
			values[0].addEventListener('input',function(){
				emptySpace(values[0]);
			})
			values[1].addEventListener('input',function(){
				emptySpace(values[1]);
			})
			values[2].addEventListener('input',function(){
				emptySpace(values[2]);
			})
			values[3].addEventListener('input',function(){
				emptySpace(values[3]);
			})}
	
