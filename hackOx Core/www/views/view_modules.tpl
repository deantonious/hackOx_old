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
			<div class="col s12 m4 l4">
				Only packaged apps with the required structure. <br/>Need to learn how to code your own apps? <br/>Read our documentation for detailed steps!
			</div>
			<div class="col s12 m8 l8">
				<form action="#">
					<div class="file-field input-field">
						<div class="btn green">
							<span>Module file</span>
							<input type="file">
						</div>
						<div class="file-path-wrapper">
							<input class="file-path validate" type="text">
						</div>
					</div>
				</form>
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


