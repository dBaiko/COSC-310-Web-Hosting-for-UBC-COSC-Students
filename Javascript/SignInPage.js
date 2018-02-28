window.onload = function() {
	document.getElementById('form').addEventListener('submit',function(event){
		var signin;
		signin = document.getElementsByClassName("info1");
		for (var i = 0; i < signin.length; i++) {
			if (signin[i].value == null || signin[i].value == "") {
				event.preventDefault();
				emptySpace(signin[i]);
			}
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
}