document.addEventListener("DOMContentLoaded", function(){
	
	let data = {
		"mode" : "api",
		"board_name" : "neople"
	};

	api.call("GET", "/board/lists", data, callback.success.board.lists, callback.error.common)

});