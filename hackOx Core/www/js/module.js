
var Module = function() {

	this.saveConfig = function(module_id, module_config) {
		var module_obj = { };
		var config_obj = { };
		
		for(var i = 0; i < module_config.length; i++) {
			var html_id = module_config[i];
			var key = $("#" + html_id).data("config");
			var value = $("#" + html_id).val();
			config_obj[key] = value;
		}
		module_obj["module_id"] = module_id;
		module_obj["module_config"] = config_obj;
		
		var params = {
			"function" : "module_config_update",
			"new_config" : JSON.stringify(module_obj)
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
			}
		});
	};
	
	this.requestOutput = function(params, url) {
		$.ajax({
			data: params,
			url: url, 
			type: "post",
			success: function(response_json) {
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				$(".module-output").html("<pre>" + response["data"] + "</pre>");
			}
		});
	};
	
	this.output = function(response_json) {
		var response = JSON.parse(response_json);
		Materialize.toast(response["message"], 3000);
		$(".module-output").html("<pre>" + response["data"] + "</pre>");
	};
};