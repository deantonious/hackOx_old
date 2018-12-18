<div class="row">
    <div class="col s12">
      <ul class="transparent tabs-fixed-width tabs">
        <li class="tab col s12 m3"><a href="#apps_installed" class="white-text active" >Manage Apps</a></li>
        <li class="tab col s12 m3"><a href="#apps_install" class="white-text">Install App</a></li>
        <li class="tab col s12 m3"><a href="#apps_logs" class="white-text">App Logs</a></li>
      </ul>
    </div>
	<div class="tab-content" id="apps_installed">
		<div class="row">
			<span class="title">Installed Apps</span>
			<table class="striped">
				<thead>
					<tr>
						<th data-field="name">Name</th>
						<th data-field="version">Version</th>
						<th data-field="author">Author</th>
						<th data-field="description">Description</th>
						<th data-field="file">Launch File</th>
					</tr>
				</thead>
				<tbody>
					{{ apps }}
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="input-field col s12">
				<input id="app_args" type="text" placeholder="Leave empty for normal execution" class="validate">
				<label for="app_args">Additional Arguments</label>
			</div>
		</div>
		<div class="row">
			<span class="title">Output</span>
			<div class="app-output">
				{{ output }}
			</div>
		</div>
	</div>
	<div class="tab-content" id="apps_install">
		<div class="row">
			<span class="title">Install from file</span>
			<div class="valign-wrapper">
				<div class="col s12 m4 l4">
					Only packaged apps with the required structure. <br/>Need to learn how to code your own apps? <br/>Read our documentation for detailed steps!
				</div>
				<div class="col s11 m7 l7">
					<div class="file-field input-field">
						<div class="btn green">
							<span>select file</span>
							<input type="file" id="app-file-upload">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>
				<div class="col s1 m1 l1">
					<a class="btn-floating tooltipped waves-effect waves-light green btn-action" data-action="app_upload" data-position="top" data-delay="50" data-tooltip="Upload and install App"><i class="material-icons">file_upload</i></a>
				</div>
			</div>
		</div>
		<div class="row">
			<span class="title">Install from repository</span>
			<table class="striped">
				<thead>
					<tr>
						<th data-field="name">Name</th>
						<th data-field="version">Version</th>
						<th data-field="author">Author</th>
						<th data-field="updated">Last Update</th>
						<th data-field="description">Description</th>
					</tr>
				</thead>
				<tbody>
					{{ apps_repo }}
				</tbody>
			</table>
		</div>
	</div>
	<div class="tab-content" id="apps_logs">
		<div class="row">
			{{ apps_logs }}
		</div>
	</div>
</div>


