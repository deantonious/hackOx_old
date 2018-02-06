$(function(){

	$('.button-collapse').sideNav();

	function login(user, pass) {
		var params = {
			"username" : user,
			"password" : pass
		};
		$.ajax({
			data:  params,
			url:   'core/login.ajax.php',
			type:  'post',
			success:  function (response) {
				if(response == "false"){
					Materialize.toast('Wrong login details!', 3000, 'red darken-4');
					document.getElementById('username').className = "validate invalid";
					document.getElementById('password').className = "validate invalid";
				} else {
					location.reload();
				}
				
			}
		});
	}

	$('#btn-login').on('click', function() {
		login(document.getElementById('username').value, document.getElementById('password').value);
	});

	$("#login-form").keyup(function(event){
		if(event.keyCode == 13){
			login(document.getElementById('username').value, document.getElementById('password').value);
		}
	});

});