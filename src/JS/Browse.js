window.onload = function() {
	document.getElementById("searchbar").addEventListener("submit",function(e){
		var item = document.getElementById("userSearch").value;
		if(item == "" || item.trim() == ""){
			e.preventDefault();
		}
	});
}
	