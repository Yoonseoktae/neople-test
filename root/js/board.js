document.addEventListener("DOMContentLoaded", function(){
	
	let urlParams = getUrlParams();

	// 게시글 리스트 GET API
	if(window.location.pathname.includes("lists")) {
		let data = {
			"mode" : "api",
			"board_name" : "neople"
		};
		api.call("GET", "/board/lists", data, callback.success.board.lists, callback.error.common);
	}

	// 게시글 세부정보 GET API
	if(window.location.pathname.includes("detail")) {
		let data = {
			"mode" : "api",
			"board_name" : "neople",
			"board_id" : urlParams.id
		};
		api.call("GET", "/board/detail", data, callback.success.board.detail, callback.error.common);
	}

	// 게시글 작성하기 POST API
	if(window.location.pathname.includes("write")) {
		$("#wsubmit").on("click", function() {
			if ( confirm("글을 작성하시겠습니까?") ) {
				let data = {
					"board_name" : "neople",
					"subject" : $("#wsubject").val(),
					"content" : $("#wcontent").val(),
					"writer" : $("#wname").val(),
					"pw" : $("#wpw").val()
				};
				api.call("POST", "/board/write?mode=api", data, callback.success.common, callback.error.common);
			}
		});
	}

	// 게시글 수정하기 GET API
	if(window.location.pathname.includes("modify")) {
		let data = {
			"mode" : "api",
			"board_name" : "neople",
			"board_id" : urlParams.id
		};
		api.call("GET", "/board/modify", data, callback.success.board.modify, callback.error.common);

		// 게시글 수정하기 PUT API
		$("#msubmit").on("click", function() {
			if ( confirm("정말 수정하시겠습니까?") ) {
				let data = {
					"board_name" : "neople",
					"board_id" : urlParams.id,
					"subject" : $("#msubject").val(),
					"content" : $("#mcontent").val()
				};
				api.call("PUT", "/board/modify?mode=api", data, callback.success.common, callback.error.common)
			}
			
		});
	}


	

});