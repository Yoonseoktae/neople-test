
const callback = {
	success : {
		common: function(json) {
			if(json.result) {
				alert("처리 완료되었습니다.");
			} else {
				alert(json.error.message);
			}
			location.href="/board/lists";
		},
		board: {
			lists: function(json) {

				if (json.result) {
					let listHtml = {"<>":"tr","html":[
						{"<>":"td","width":"70","html":"${id}"},
						{"<>":"td","width":"500","html":[
							{"<>":"a","href":"/board/detail?id=${id}","html":"${subject}"}
						]},
						{"<>":"td","width":"120","html":"${writer}"},
						{"<>":"td","width":"100","html":"${reg_date}"}
					]};
					
					$("#board-list-tbody").empty().json2html(json.data.board, listHtml);
				} else {
					alert(json.error.message);
				}
				
			},
			detail: function(json) {

				if (json.result) {
					let pwChk = callback.verification.boardPw(json);
					if (pwChk || json.data.pw == "") {
						let detailHtml = [
							{"<>":"div","id":"board_body","html":[
								{"<>":"h2","html":"${subject}"},
								{"<>":"div","id":"user_info","html":[
									{"<>":"span","html":"게시판명 : ${board_name}"},
									{"<>":"br","html":""},
									{"<>":"span","html":"등록일 : ${reg_date}"},
									{"<>":"br","html":""},
									{"<>":"div","id":"bo_line","html":""}
								]},
								{"<>":"div","id":"bo_content","html":"${content}"}
							]},
							{"<>":"div","id":"bo_ser","html":[
								{"<>":"ul","html":[
									{"<>":"li","html":[
										{"<>":"a","href":"/board/lists","html":"[목록으로]"}
									]},
									{"<>":"li","html":[
										{"<>":"a","href":"/board/modify?id=${id}","html":"[수정]"}
									]},
									{"<>":"li","html":[
										{"<>":"span","id":"btn-board-delete","style":"cursor:pointer;","html":"[삭제]"}
									]}
								]}
							]}
						];
						
						$("#board_detail").empty().json2html(json.data, detailHtml);

						$("#btn-board-delete").on("click", function() {
							if ( confirm("정말 삭제하시겠습니까?") ) {
								let urlParams = getUrlParams();
								let data = {
									"board_name" : "neople",
									"board_id" : urlParams.id
								};
								api.call("DELETE", "/board/delete?mode=api", data, callback.success.common, callback.error.common);
							}
							
						});
					}

				} else {
					alert(json.error.message);
				}
			},
			modify: function(json) {
				if(json.result) {
					let pwChk = callback.verification.boardPw(json);
					
					if (pwChk || json.data.pw == "") {
						$("#msubject").val(json.data.subject);
						$("#mname").val(json.data.writer);
						$("#mcontent").val(json.data.content);
					}
					
				}
			}
		}
	},
	error : {
		common: function(json) {
			
		},
	},
	verification: {
		boardPw: function(json) {
			if (json.data.pw != "") {
				let userInput = prompt("잠긴글입니다. 비밀번호를 입력하세요."+"");
				if (userInput != json.data.pw) {
					alert ("비밀번호가 틀렸습니다. \n 다시시도해주세요.");
					location.href="/board/lists";
					return false;
				}
				return true;
			}
			return false;
		}
	}
}
