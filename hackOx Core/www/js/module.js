function Module(module_dir, module_id) {
	
	this.dir = $('meta[name=module_dir]').attr("content");
	this.id = $('meta[name=module_id]').attr("content");
	
	this.saveConfig = function(module_config) {
		var module_obj = { };
		var config_obj = { };
		
		for(var i = 0; i < module_config.length; i++) {
			var html_id = module_config[i];
			var key = $("#" + html_id).data("config");
			var value = $("#" + html_id).val();
			config_obj[key] = value;
		}
		module_obj["module_id"] = this.id;
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
	
	this.requestAjax = function(params) {
		params.module_id = this.id;
		$.ajax({
			data: params,
			url: this.dir + "module.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				if(loader)
					hideLoader()
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				$(".module-output").html("<pre>" + response["data"] + "</pre>");
				
			}
		});
	};
	
	this.requestAjaxWithLoader = function(params, loader_message) {
		displayLoader(loader_message);
		params.module_id = this.id;
		$.ajax({
			data: params,
			url: this.dir + "module.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				hideLoader()
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