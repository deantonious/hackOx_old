<span class="title">General</span>
<div class="row">
	<div class="input-field col s12 m6">
		<i class="material-icons prefix">memory</i>
		<input id="dev_name" name="dev_name" type="text" placeholder="Bot display name" value="{{ dev_name }}">
		<label for="dev_name">Hostname</label>
	</div>
	<div class="input-field col s12 m6">
		<i class="material-icons prefix">link</i>
		<input id="dev_remote_url" name="dev_remote_url" type="text" placeholder="Remote server" value="{{ dev_remote_url }}" disabled>
		<label for="dev_remote_url">Controller Url</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s12 m6">
		<i class="material-icons prefix">fingerprint</i>
		<input id="dev_id" name="dev_id" type="text" placeholder="Bot access id" value="{{ dev_id }}" disabled>
		<label for="dev_id">Device Id</label>
	</div>
	<div class="input-field col s12 m6">
		<i class="material-icons prefix">vpn_key</i>
		<input id="dev_key" name="dev_key" type="text" placeholder="Bot access key" value="{{ dev_key }}" disabled>
		<label for="dev_key">Device Key</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s12 m6">
		<i class="material-icons prefix">list</i>
		<textarea id="dev_app_repos" name="dev_app_repos" placeholder="One line for each repo" value="" class="materialize-textarea"></textarea>
		<label for="dev_app_repos">App Repositories</label>
	</div>
	<div class="input-field col s12 m6">
		<i class="material-icons prefix">list</i>	
		<textarea id="dev_module_repos" name="dev_module_repos" placeholder="One line for each repo" value="" class="materialize-textarea"></textarea>
		<label for="dev_module_repos">Module Repositories</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s12 m6">
		<i class="material-icons prefix">person</i>
		<input id="dev_admin_usr" name="dev_admin_usr" type="text" placeholder="Bot admin user" value="{{ dev_admin_usr }}">
		<label for="dev_admin_usr">Admin User</label>
	</div>
	<div class="input-field col s12 m6">
		<i class="material-icons prefix">lock</i>
		<input id="dev_password" name="dev_password" type="password" placeholder="Bot admin password" value="">
		<label for="dev_password">New Password</label>
	</div>
</div>
<div class="row center">
	<button class="waves-effect waves-light btn btn-action" data-action="config_update" type="submit"><i class="material-icons left">save</i>Save Changes</button>
</div>