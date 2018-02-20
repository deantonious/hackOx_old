
$(function(){

	//Call module API
	var module = new Module();
	
	$(".btn-save-config").on("click", function() {
		var config_ids = ["form_smtp_host", "form_smtp_port", "form_smtp_username", "form_smtp_password"];
		module.saveConfig(config_ids); 
	});
	
	$(".btn-send-spoof-email").on("click", function() {
		Materialize.toast("Sending email...", 3000);
		var params = {
			"form_smtp_host" : $("#form_smtp_host").val(),
			"form_smtp_encryption" : $("#form_smtp_encryption").val(),
			"form_smtp_port" : $("#form_smtp_port").val(),
			"form_smtp_username" : $("#form_smtp_username").val(),
			"form_smtp_password" : $("#form_smtp_password").val(),
			"form_from_name" : $("#form_from_name").val(),
			"form_from_email" : $("#form_from_email").val(),
			"form_reply_name" : $("#form_reply_name").val(),
			"form_reply_email" : $("#form_reply_email").val(),
			"form_subject" : $("#form_subject").val(),
			"form_destination_email" : $("#form_destination_email").val(),
			"form_message" : $("#form_message").val()
		};
		module.requestAjaxWithLoader(params, "Sending email...");
		
	});

});
