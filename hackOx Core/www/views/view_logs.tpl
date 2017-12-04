
<div class="row">
    <div class="col s12">
      <ul class="transparent tabs-fixed-width tabs">
        <li class="tab col s3"><a href="#log_framework" class="white-text active" >Framework Log</a></li>
        <li class="tab col s3"><a href="#log_urlsnarf" class="white-text">URLSnarf Log</a></li>
        <li class="tab col s3"><a href="#log_urlspoof" class="white-text">URLSpoof Log</a></li>
      </ul>
    </div>
	<div class="tab-content" id="log_framework">
		<div class="row">
			<table class="striped">
				<thead>
				  <tr>
					  <th data-field="id">Id</th>
					  <th data-field="id">Date</th>
					  <th data-field="name">Action</th>
					  <th data-field="price">Status</th>
				  </tr>
				</thead>
				<tbody>
					<tpl:logs>
				</tbody>
			</table>
		</div>
		<div class="row center">
			<a class="waves-effect waves-light btn red" id="btn-clear-log"><i class="material-icons left">delete_sweep</i>Clear Log</a>
		</div>
	</div>
	<div class="tab-content" id="log_urlsnarf">
		LOGS
	</div>
	<div class="tab-content" id="log_urlspoof">
		LOGS
	</div>
</div>
