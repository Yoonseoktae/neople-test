
const api = {
	call: function(method, url, data, callbackSuccess, callbackError) {

		if (data == null || data == undefined) data = {};

		let query_string = "";

		if (method == "GET") {
			let Param = [];
			$.each(data, function(k, v) {
				Param.push(k + "=" + v);
			});

			query_string = "?" + Param.join("&");

			$.ajax({
				type: method,
				url: url + query_string,
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				success: function(json, textStatus, xhr) {
					if (callbackSuccess != undefined) callbackSuccess(json, textStatus, xhr);
				},
				beforeSend : function(xhr){

				},
				error: function(xhr, status, error) {
					console.log(xhr);
					console.log(status);
					console.log(error);

					if (callbackError != undefined) callbackError(xhr, status, error);
				},
			});
		} else {
			$.ajax({
				type: method,
				url: url,
				dataType: "json",
				contentType: "application/json; charset=utf-8",
				data: JSON.stringify(data),
				success: function(json, textStatus, xhr) {
					if (callbackSuccess != undefined) callbackSuccess(json, textStatus, xhr);
				},
				beforeSend : function(xhr){
					
				},
				error: function(xhr, status, error) {
					console.log(xhr);
					console.log(status);
					console.log(error);

					if (callbackError != undefined) callbackError(xhr, status, error);
				},
			});
		}

	}
}
