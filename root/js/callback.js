
const callback = {
	success : {
		common: function(json, textStatus, xhr) {
			if(json.result) {
				alert("처리 완료되었습니다.");
			} else {
				alert(json.error.message);
			}

		},
		board: {
			lists: function(json, textStatus, xhr) {

				if (json.result) {
					let listHtml = {"<>":"tr","html":[
						{"<>":"td","class":"num","html":"${id}"},
						{"<>":"td","class":"subject","html":[
							{"<>":"p","class":"stitle","html":[
								{"<>":"a","href":"","html":"${subject}"}
							]}
						]},
						{"<>":"td","class":"writer","html":"${writer}"},
						{"<>":"td","class":"date","html":"${reg_date}"},
						{"<>":"td","class":"cnt","html":"${view_count}"}
					]};
					
					$("#board-list-tbody").empty().json2html(json.data.board, listHtml);
				} else {
					alert(json.error.message);
				}
				
			},
			detail: function(json, textStatus, xhr) {

			},
			modify: function(json, textStatus, xhr) {

			}
		}
	},
	error : {
		common: function(json, textStatus, xhr) {
			
		},
	}
}
