<div class="row">
	<span class="title">Configuration</span>
	<div class="row">
        <div class="input-field col s6">
			<i class="material-icons prefix">storage</i>
			<input id="form_smtp_host" type="text" class="validate" data-config="smtp_host" value="<tpl:smtp_host>">
			<label for="form_smtp_host">SMTP Server</label>
        </div>
		<div class="input-field col s3">
			<i class="material-icons prefix">lock_outline</i>
			<select id="form_smtp_encryption">
				<option value="" disabled>Choose your option</option>
				<option value="false">Disabled</option>
				<option value="tls">TLS</option>
				<option value="ssl" selected>SSL</option>
			</select>
			<label>Encryption</label>
		</div>
        <div class="input-field col s3">
			<input id="form_smtp_port" type="number" class="validate" data-config="smtp_port" value="<tpl:smtp_port>">
			<label for="form_smtp_port">SMTP Port</label>
        </div>
    </div>
	<div class="row">
        <div class="input-field col s6">
			<i class="material-icons prefix">fingerprint</i>
			<input id="form_smtp_username" type="text" class="validate" data-config="smtp_username" value="<tpl:smtp_username>">
			<label for="form_smtp_username">Username</label>
        </div>
        <div class="input-field col s6">
			<i class="material-icons prefix">vpn_key</i>
			<input id="form_smtp_password" type="password" class="validate" data-config="smtp_password" value="<tpl:smtp_password>">
			<label for="form_smtp_password">Password</label>
        </div>
    </div>
	<div class="center">
		<button class="waves-effect waves-light btn btn-save-config" type="submit"><i class="material-icons left">save</i>Save Configuration</button>
	</div>
	<span class="title">From</span>
	<div class="row">
        <div class="input-field col s6">
			<i class="material-icons prefix">person</i>
			<input id="form_from_name" type="text" class="validate">
			<label for="form_from_name">From - Name</label>
        </div>
        <div class="input-field col s6">
			<i class="material-icons prefix">email</i>
			<input id="form_from_email" type="text" class="validate">
			<label for="form_from_email">From - Email</label>
        </div>
    </div>
	<span class="title">Reply to</span>
	<div class="row">
        <div class="input-field col s6">
			<i class="material-icons prefix">person</i>
			<input id="form_reply_name" type="text" class="validate">
			<label for="form_reply_name">Replay to - Name</label>
        </div>
        <div class="input-field col s6">
			<i class="material-icons prefix">email</i>
			<input id="form_reply_email" type="text" class="validate">
			<label for="form_reply_email">Reply to - Email</label>
        </div>
    </div>
	<span class="title">Message</span>
	<div class="row">
        <div class="input-field col s6">
			<i class="material-icons prefix">subject</i>
			<input id="form_subject" type="text" class="validate">
			<label for="form_subject">Subject</label>
        </div>
        <div class="input-field col s6">
			<i class="material-icons prefix">email</i>
			<input id="form_destination_email" type="text" class="validate">
			<label for="form_destination_email">To - Receiver Email</label>
        </div>
    </div>
	<div class="row">
		<div class="input-field col s12">
			<i class="material-icons prefix">message</i>
			<textarea id="form_message" class="materialize-textarea"></textarea>
			<label for="form_message">Message</label>
		</div>
	</div>
	<div class="center">
		<button class="waves-effect waves-light btn btn-send-spoof-email" type="submit"><i class="material-icons left">send</i>Send Email</button>
	</div>
</div>
