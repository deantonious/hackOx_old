<div class="row">
    <div class="col s12">
      <ul class="transparent tabs-fixed-width tabs">
        <li class="tab col s3"><a href="#modules_installed" class="white-text active" >Manage Modules</a></li>
        <li class="tab col s3"><a href="#modules_install" class="white-text">Install Modules</a></li>
      </ul>
    </div>
	<div class="tab-content" id="modules_installed">
		<div class="row">
			<table class="striped">
				<thead>
					<tr>
						<th data-field="module">Module</th>
						<th data-field="version">Version</th>
						<th data-field="description">Description</th>
						<th data-field="author">Author</th>
					</tr>
				</thead>
				<tbody>
					<tpl:modules>	  
				</tbody>
			</table>
		</div>
	</div>
	<div class="tab-content" id="modules_install">
		<div class="row">
			<span class="title">Install from file</span>
			<div class="valign-wrapper">
				<div class="col s12 m4 l4">
					Only packaged modules with the required structure. <br/>Need to learn how to code your own modules? <br/>Read our documentation for detailed steps!
				</div>
				<div class="col s11 m7 l7">
					<div class="file-field input-field">
						<div class="btn green">
							<span>select file</span>
							<input type="file" id="module-file-upload">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</div>
				<div class="col s1 m1 l1">
					<a class="btn-floating tooltipped waves-effect waves-light green btn-action" data-action="module_upload" data-position="top" data-delay="50" data-tooltip="Upload and install App"><i class="material-icons">file_upload</i></a>
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
					<tpl:modules_repo> 
				</tbody>
			</table>
		</div>
	</div>
</div>


