window.onload = function() {
	var contributors = document.getElementById("numOfCont");
	contributors.addEventListener("input", function(e){
		var num = contributors.value;
		var cont = document.getElementsByName("contributor");
		if(num >= 1){
			var div = document.getElementById("contributors")
			div.classList.remove("hidden");
			for(i=0; i < num; i++){
				cont[i].classList.remove("hidden");
			}
		}else{
			var div = document.getElementById("contributors")
			div.classList.add("hidden");
		}
		if(num<10){
			for(i=10; i > num; i--){
				cont[i-1].classList.add("hidden");
			}
		}
		
	});
	
	var submit = document.getElementById("create");
	submit.addEventListener("submit", function(e){checkIfValid(e);});
	function checkIfValid(e){
		var required = document.getElementsByClassName("required");
		for (var i = 0; i < required.length; i++) {
			var inputValue = required[i].value;
			if(inputValue == null || inputValue == ""){
				e.preventDefault();
				required[i].classList.add("empty");
			}
		}
	}
	var removeHighlight = document.getElementsByClassName("required");
	for (var i = 0; i < removeHighlight.length; i++) {
		removeHighlight[i].addEventListener("input", function(){
			var inputValue = this.value;
			if(inputValue == "" || inputValue == null ){
				this.classList.add("empty");
			}else{
				this.classList.remove("empty");
			}			
		});
	}
	
}