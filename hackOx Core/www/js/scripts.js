var loading = false;

$(function(){
	
	$(".button-collapse").sideNav();
	$(".tooltipped").tooltip({delay: 50});
	$(".dropdown-button").dropdown();
	$("select").material_select();
	$(".collapsible").collapsible();
	$('.modal').modal();
	
	$(window).bind('beforeunload', function() {
		if(loading)
			return false;
	});
				
	/*
	 *	Button AJAX actions
	 *	Add data-action="{ACTION}" + function data values
	 */
	$(".btn-action").on("click", function() {
		var action = $(this).data("action");
		//--------------------[ CONFIGURATION ]--------------------
		//Shutdown
		if(action == "shutdown") {
			powerSystem("shutdown");
		}
		//Reboot
		if(action == "reboot") {
			powerSystem("reboot");
		}
		//Update configuration
		if(action == "config_update") {
			configUpdate($("#dev_name").val(), $("#dev_remote_url").val(), $("#dev_id").val(), $("#dev_key").val(), $("#dev_admin_usr").val(), $("#dev_password").val());
		}
		//Enable network interface
		if(action == "interface_enable") {
			configInterface($(this).data("interface"), "enable");
		}
		//Disable network interface
		if(action == "interface_disable") {
			configInterface($(this).data("interface"), "disable");
		}
		//--------------------[ APPLICATION ]--------------------
		//Run app
		if(action == "app_run_normal") {
			Materialize.toast("Running app...", 3000);
			runApp($(this).data("app-id"), "normal");
		}
		//Run app as sudo
		if(action == "app_run_sudo") {
			Materialize.toast("Running app as root...", 3000);
			runApp($(this).data("app-id"), "sudo");
		}
		//Remove app
		if(action == "app_remove") {
			Materialize.toast("Uninstalling app...", 3000);
			removeApp($(this).data("app-id"));
		}
		//Download app
		if(action == "app_download") {
			Materialize.toast("Downloading app...", 3000);
			downloadApp($(this).data("app-url"));
		}
		//Upload app
		if(action == "app_upload") {
			if($("#app-file-upload")[0].files[0] != null) {
				Materialize.toast("Uploading app...", 3000);
				uploadApp();
			} else { 
				Materialize.toast("No file selected", 3000);
			}
		}
		//--------------------[ MODULE ]--------------------
		//Download module
		if(action == "module_download") {
			Materialize.toast("Downloading module...", 3000);
			downloadModule($(this).data("module-url"));
		}
		//Upload module
		if(action == "module_upload") {
			if($("#module-file-upload")[0].files[0] != null) {
				Materialize.toast("Installing module (can take a while)...", 3000);
				uploadModule();
			} else { 
				Materialize.toast("No file selected", 3000);
			}
		}
		//Remove module
		if(action == "module_remove") {
			Materialize.toast("Uninstalling module...", 3000);
			removeModule($(this).data("module-id"));
		}
	});
	
	function removeModule(module_id) {
		displayLoader("Removing module and packages installed...");
		var params = {
			"function" : "module_remove",
			"module_id" : module_id
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				console.log(response_json);
				hideLoader();
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				$("#module-"+module_id).remove();
			}
		});
	}
	
	function powerSystem(action) {

		var params = {
			"function" : "power_system",
			"action" : action
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
			}
		});
	}
	
	function uploadModule() {
		displayLoader("Uploading and installing module... Please wait.");
		var form_data = new FormData();
		form_data.append("function", "module_upload");
		form_data.append("module_file", $("#module-file-upload")[0].files[0]);

		$.ajax({
			data: form_data,
			url: "core/action.ajax.php", 
			type: "post",
			cache: false,
			contentType: false,
			processData: false,
			success: function(response_json) {
				//console.log(response_json);
				hideLoader();
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				location.reload();
			}
		});
	}
	
	function downloadModule(module_url) {
		displayLoader("Downloading and installing module... Please wait.");
		var params = {
			"function" : "module_download",
			"module_url" : module_url
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				hideLoader();
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				location.reload();
			}
		});
	}
	
	function configUpdate(dev_name, dev_remote_url, dev_id, dev_key, dev_admin_usr, dev_password) {			
		var params = {
			"function" : "config_update",
			"dev_name" : dev_name,
			"dev_remote_url" : dev_remote_url,
			"dev_id" : dev_id,
			"dev_key" : dev_key,
			"dev_admin_usr" : dev_admin_usr,
			"dev_password" : dev_password
		};
		$.ajax({
			data:  params,
			url:   "core/action.ajax.php",
			type:  "post",
			success:  function (response_json) {
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
			}
		});
	}
	
	function uploadApp() {
		displayLoader("Uploading and installing module... Please wait until this message disappears.");
		var form_data = new FormData();
		form_data.append("function", "app_upload");
		form_data.append("app_file", $("#app-file-upload")[0].files[0]);

		$.ajax({
			data: form_data,
			url: "core/action.ajax.php", 
			type: "post",
			cache: false,
			contentType: false,
			processData: false,
			success: function(response_json) {
				//console.log(response_json);
				hideLoader();
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				location.reload();
			}
		});
	}
	
	function downloadApp(app_url) {
		displayLoader("Downloading and installing module... Please wait until this message disappears.");
		var params = {
			"function" : "app_download",
			"app_url" : app_url
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				hideLoader();
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				location.reload();
			}
		});
	}
	
	function removeApp(app_id) {
		var params = {
			"function" : "app_remove",
			"app_id" : app_id
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				location.reload();
			}
		});
	}
	
	function runApp(app_id, app_run_mode) {
		loading = true;
		var params = {
			"function" : "app_run",
			"app_id" : app_id,
			"app_args" : $("#app_args").val(),
			"app_run_mode" : app_run_mode
		};
		$.ajax({
			data:  params,
			url:   "core/action.ajax.php",
			type:  "post",
			success:  function (response_json) {
				//console.log(response_json);
				loading = false;
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				$(".app-output").html("<pre>" + response["data"] + "</pre>");
				
			}
		});
	}
	
	function connectWifi(interface_name, wifi_ssid, wifi_password) {
		displayLoader("Wifi connecting... Please wait.");
		var params = {
			"function" : "wifi_connect",
			"interface_name" : interface_name,
			"wifi_ssid" : wifi_ssid,
			"wifi_password" : wifi_password
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				hideLoader();
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
			}
		});
	}
	
	function disconnectWifi(interface_name) {
		displayLoader("Wifi disconnecting... Please wait.");
		var params = {
			"function" : "wifi_disconnect",
			"interface_name" : interface_name
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				hideLoader();
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
			}
		});
	}
	
	function configInterface(interface_name, interface_action) {
		Materialize.toast("Configuring interface '"+interface_name+"'", 3000);
		var params = {
			"function" : "config_interface",
			"interface_name" : interface_name,
			"interface_action" : interface_action
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				if($('*[data-interface="'+interface_name+'"]').hasClass("red")) {
					$('*[data-interface="'+interface_name+'"]').html("<i class=\"material-icons left\">wifi_tethering</i>enable");
					$('*[data-interface="'+interface_name+'"]').removeClass("red");
					$('*[data-interface="'+interface_name+'"]').addClass("green");
				} else {
					$('*[data-interface="'+interface_name+'"]').html("<i class=\"material-icons left\">portable_wifi_off</i>disable");
					$('*[data-interface="'+interface_name+'"]').removeClass("green");
					$('*[data-interface="'+interface_name+'"]').addClass("red");
				}
			}
		});
	}
	
	function scanNetworks(id_interface, id_display) {
		displayLoader("Scanning for Wifi networks...");
		var params = {
			"function" : "wifi_scan",
			"interface_name" : $("#"+id_interface).val()
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
				hideLoader();
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				
				var data = JSON.parse(response["data"]);
				$("#"+id_display).find("option").remove();
				//Add ids
				for(var i = 0; i < data.length; i++) {
					var network = data[i];
					//console.log(network);
					$("#"+id_display).append($("<option></option>").attr("value", network).text(network));
				}
				$("select").material_select();
			}
		});
	}
});

function displayLoader(text) {
	loading = true;
	$("body").append("<div id=\"loading-overlay\"><div class=\"preloader-wrapper big active\"><div class=\"spinner-layer spinner-green-only\"><div class=\"circle-clipper left\"><div class=\"circle\"></div></div><div class=\"gap-patch\"><div class=\"circle\"></div></div><div class=\"circle-clipper right\"><div class=\"circle\"></div></div></div></div><br/><span class=\"loading-text\">"+text+"</span></div>");
}

function hideLoader() {
	loading = false;
	$("#loading-overlay").remove();
}





