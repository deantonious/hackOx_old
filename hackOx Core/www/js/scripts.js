
$(function(){

	$(".button-collapse").sideNav();
	$(".tooltipped").tooltip({delay: 50});
	$(".dropdown-button").dropdown();
	$("select").material_select();
	$(".collapsible").collapsible();
	
	$("#btn-update-config").on("click", function() {
		configUpdate($("#dev_name").val(), $("#dev_remote_url").val(), $("#dev_id").val(), $("#dev_key").val(), $("#dev_admin_usr").val(), $("#dev_password").val());
	});
	
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
	
	$(".btn-run-app").on("click", function() {
		Materialize.toast("Running app...", 3000);
		runApp($(this).data("app-id"), "normal");
	});
	
	$(".btn-sudo-run-app").on("click", function() {
		Materialize.toast("Running app as root...", 3000);
		runApp($(this).data("app-id"), "sudo");
	});
	
	function runApp(app_id, app_run_mode) {
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
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				$(".app-output").html("<pre>" + response["data"] + "</pre>");
			}
		});
	}
	
	$(".btn-upload-app").on("click", function() {
		
		if($("#app-file-upload")[0].files[0] != null) {
			Materialize.toast("Uploading app...", 3000);
			uploadApp();
		} else { 
			Materialize.toast("No file selected", 3000);
		}
	});
	
	function uploadApp() {
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
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				location.reload();
			}
		});
	}
	
	$(".btn-download-app").on("click", function() {
		Materialize.toast("Downloading app...", 3000);
		downloadApp($(this).data("app-url"));

	});
	
	function downloadApp(app_url) {
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
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				location.reload();
			}
		});
	}
	
	$(".btn-remove-app").on("click", function() {
		Materialize.toast("Uninstalling app...", 3000);
		removeApp($(this).data("app-id"));
	});
	
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
	
	/*
	 *	Button AJAX actions
	 *	Add data-action="{ACTION}" + function data values
	 */
	$(".btn-action").on("click", function() {
		var action = $(this).data("action");
		//Scan for wifi networks
		if(action == "scan_wifi_networks") {
			var id_display = $(this).data("display");
			var id_interface = $(this).data("interface");
			scanNetworks(id_interface, id_display);
		}
		//Connect to Wifi network
		if(action == "wifi_connect") {
			connectWifi($("#"+$(this).data("interface")).val(), $("#"+$(this).data("ssid")).val(), $("#"+$(this).data("password")).val());
		}
		//Disconnect Wifi
		if(action == "wifi_disconnect") {
			disconnectWifi($("#"+$(this).data("interface")).val());
		}
		//Enable network interface
		if(action == "interface_enable") {
			configInterface($(this).data("interface"), "enable");
		}
		//Disable network interface
		if(action == "interface_disable") {
			configInterface($(this).data("interface"), "disable");
		}
	});
	
	function disconnectWifi(interface_name) {
		Materialize.toast("Disconecting...", 6000);
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
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				//location.reload();
			}
		});
	}
	
	function connectWifi(interface_name, wifi_ssid, wifi_password) {
		Materialize.toast("Connecting... Please wait.", 6000);
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
				var response = JSON.parse(response_json);
				Materialize.toast(response["message"], 3000);
				//location.reload();
			}
		});
	}
	
	function configInterface(interface_name, interface_action) {
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
				location.reload();
			}
		});
	}
	
	function scanNetworks(id_interface, id_display) {
		var params = {
			"function" : "config_scan_networks",
			"interface_name" : $("#"+id_interface).val()
		};
		$.ajax({
			data: params,
			url: "core/action.ajax.php", 
			type: "post",
			success: function(response_json) {
				//console.log(response_json);
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









