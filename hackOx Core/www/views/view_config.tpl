<span class="title">General</span>
<div class="row">
	<div class="input-field col s6">
		<i class="material-icons prefix">memory</i>
		<input id="dev_name" name="dev_name" type="text" placeholder="Bot display name" value="<tpl:dev_name>">
		<label for="dev_name">Device Name</label>
	</div>
	<div class="input-field col s6">
		<i class="material-icons prefix">link</i>
		<input id="dev_remote_url" name="dev_remote_url" type="text" placeholder="Remote server" value="<tpl:dev_remote_url>">
		<label for="dev_remote_url">Controller Url</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s6">
		<i class="material-icons prefix">fingerprint</i>
		<input id="dev_id" name="dev_id" type="text" placeholder="Bot access id" value="<tpl:dev_id>">
		<label for="dev_id">Device Id</label>
	</div>
	<div class="input-field col s6">
		<i class="material-icons prefix">vpn_key</i>
		<input id="dev_key" name="dev_key" type="text" placeholder="Bot access key" value="<tpl:dev_key>">
		<label for="dev_key">Device Key</label>
	</div>
</div>
<div class="row">
	<div class="input-field col s6">
		<i class="material-icons prefix">person</i>
		<input id="dev_admin_usr" name="dev_admin_usr" type="text" placeholder="Bot admin user" value="<tpl:dev_admin_usr>">
		<label for="dev_admin_usr">Admin User</label>
	</div>
	<div class="input-field col s6">
		<i class="material-icons prefix">lock</i>
		<input id="dev_password" name="dev_password" type="password" placeholder="Bot admin password" value="">
		<label for="dev_password">New Password</label>
	</div>
</div>
<div class="row center">
	<button class="waves-effect waves-light btn" type="submit"><i class="material-icons left">save</i>Save Changes</button>
</div>

<span class="title">Wifi Client</span>
<div class="row">
	<div class="input-field col s10 m2">
		<i class="material-icons prefix">wifi_tethering</i>
		<select id="config_wc_int">
			<option value="" disabled selected>Select Interface</option>
			<tpl:config_wc_interfaces>
		</select>
		<label>Interface</label>
	</div>
	<div class="input-field col s12 m3">
		<i class="material-icons prefix">format_list_bulleted</i>
		<select id="config_wc_ssid">
			<option value="" disabled>No available networks</option>
		</select>
		<label>Wifi SSID</label>
	</div>
	<div class="input-field col s2 m1">
		<a class="btn-floating btn waves-effect waves-light blue tooltipped btn-action" data-action="scan_wifi_networks" data-display="config_wc_ssid" data-interface="config_wc_int" data-position="top" data-delay="50" data-tooltip="Scan for networks"><i class="material-icons">search</i></a>
	</div>
	<div class="input-field col s11 m5">
		<i class="material-icons prefix">vpn_key</i>
		<input id="config_wc_password" name="config_wc_password" type="password" placeholder="Wifi network password" value="">
		<label for="config_wc_password">Wifi Password</label>
	</div>
	<div class="input-field col s1 m1">
		<a class="btn-floating btn waves-effect waves-light tooltipped btn-action" data-action="wifi_connect" data-interface="config_wc_int" data-ssid="config_wc_ssid" data-password="config_wc_password" data-position="top" data-delay="50" data-tooltip="Connect to Wifi"><i class="material-icons">network_wifi</i></a>
		<a class="btn-floating btn waves-effect waves-light tooltipped red btn-action" data-action="wifi_disconnect" data-interface="config_wc_int" data-position="top" data-delay="50" data-tooltip="Disconnect from network"><i class="material-icons">signal_wifi_off</i></a>
	</div>
</div>















