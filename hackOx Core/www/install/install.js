
$(function(){

	$(".button-collapse").sideNav();
	$(".tooltipped").tooltip({delay: 50});
	$(".dropdown-button").dropdown();
	$("select").material_select();
	$(".collapsible").collapsible();
	
	$("#btn-install").on("click", function() {
		$("#installation").html('<div class="preloader-wrapper small active"><div class="spinner-layer spinner-green-only"><div class="circle-clipper left"><div class="circle"></div></div><div class="gap-patch"><div class="circle"></div></div><div class="circle-clipper right"><div class="circle"></div></div></div></div>');
		Materialize.toast("Installing hackOx DB...", 3000);
		install($("#db_host").val(), $("#db_username").val(), $("#db_password").val(), $("#db_database").val(), $("#db_table_prefix").val(), $("#db_password_salt").val());
	});
	
	function install(db_host, db_username, db_password, db_database, db_table_prefix, db_password_salt) {
		var params = {
			"db_host" : db_host,
			"db_username" : db_username,
			"db_password" : db_password,
			"db_database" : db_database,
			"db_table_prefix" : db_table_prefix,
			"db_password_salt" : db_password_salt
		};
		$.ajax({
			data:  params,
			url:   "install_sql.ajax.php",
			type:  "post",
			success:  function (response) {
				Materialize.toast(response, 3000);
				window.location = "..";
			}
		});
	}
	
});
