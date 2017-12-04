<div class="row">
	<!-- LEFT COLUMN ------------------------------------------------------------------------------------------>
	<div class="col s12 m12 l6">
		<!-- BEGIN SYSTEM -->
		<ul class="collapsible" data-collapsible="accordion">
			<li>
				<div class="collapsible-header active"><i class="material-icons">devices_other</i>System</div>
				<div class="collapsible-body">
					<div class="row">
						<div class="col s4">
							Software
						</div>
						<div class="col s6">
							<tpl:info_system_software>
						</div>
					</div>
					<div class="row">
						<div class="col s4">
							Mode
						</div>
						<div class="col s6">
							Portable
						</div>
					</div>
					<div class="row">
						<div class="col s4">
							Current Time
						</div>
						<div class="col s6">
							<tpl:info_system_date>
						</div>
					</div>
					<div class="row">
						<div class="col s4">
							Uptime
						</div>
						<div class="col s6">
							<tpl:info_system_uptime>
						</div>
					</div>
					<div class="row">
						<div class="col s4">
							Hostname
						</div>
						<div class="col s6">
							<tpl:info_system_hostname>
						</div>
					</div>
				
				</div>
            </li>
        </ul>
		<!-- END SYSTEM -->
	
		<!-- BEGIN MEMORY -->
		<ul class="collapsible" data-collapsible="accordion">
			<li>
				<div class="collapsible-header active"><i class="material-icons">dns</i>Memory</div>
				<div class="collapsible-body">
					<div class="row">
						<div class="col s4">
							Total RAM
						</div>
						<div class="col s6">
							<tpl:info_ram_total> MB
						</div>
					</div>
					<div class="row">
						<div class="col s4">
							RAM Usage
						</div>
						<div class="col s5">
							<div class="progress tooltipped" data-position="top" data-delay="50" data-tooltip="<tpl:info_ram_use>%">
								<div class="determinate" style="width: <tpl:info_ram_use>%;"></div>
							</div>
						</div>
						<div class="col s3">
							<tpl:info_ram_used> MB / <tpl:info_ram_total> MB
						</div>
					</div>
					
					<div class="row">
						<div class="col s4">
							Total SWAP
						</div>
						<div class="col s6">
							<tpl:info_swap_total> MB
						</div>
					</div>
					<div class="row">
						<div class="col s4">
							SWAP Usage
						</div>
						<div class="col s5">
							<div class="progress tooltipped" data-position="top" data-delay="50" data-tooltip="<tpl:info_swap_use>%">
								<div class="determinate" style="width: <tpl:info_swap_use>%;"></div>
							</div>
						</div>
						<div class="col s3">
							<tpl:info_swap_used> MB / <tpl:info_swap_total> MB
						</div>
					</div>
					
				</div>
            </li>
        </ul>
		<!-- END MEMORY -->
		
		<!-- BEGIN STORAGE -->
		<ul class="collapsible" data-collapsible="accordion">
			<li>
				<div class="collapsible-header active"><i class="material-icons">sd_storage</i>Storage</div>
				<div class="collapsible-body">
					<div class="row">
						<div class="col s2">Filesystem</div>
						<div class="col s2">Mounted</div>
						<div class="col s5">Use</div>
						<div class="col s3">Used / Total</div>
					</div>
					<tpl:info_storage>
				</div>
            </li>
        </ul>
		<!-- END STORAGE -->
	</div>
	
	<!-- RIGHT COLUMN ------------------------------------------------------------------------------------------>
	<div class="col s12 m12 l6">
		<!-- BEGIN CPU -->
		<ul class="collapsible" data-collapsible="accordion">
			<li>
				<div class="collapsible-header active"><i class="material-icons">memory</i>CPU</div>
				<div class="collapsible-body">
					<div class="row">
						<div class="col s4">
							Processor
						</div>
						<div class="col s6">
							<tpl:info_cpu_processor>
						</div>
					</div>
					<div class="row">
						<div class="col s4">
							Architecture
						</div>
						<div class="col s6">
							<tpl:info_cpu_architecture>
						</div>
					</div>
					<div class="row">					
						<div class="col s4">
							Load Average
						</div>
						<div class="col s5">
							<div class="progress tooltipped" data-position="top" data-delay="50" data-tooltip="<tpl:info_cpu_avg_per>%">
								<div class="determinate" style="width: <tpl:info_cpu_avg_per>%"></div>
							</div>
						</div>
						<div class="col s3">
							<tpl:info_cpu_avg>
						</div>
					</div>
					<tpl:info_cpu_bogomips>
				</div>
			</li>
		</ul>
		<!-- END CPU -->
		<!-- BEGIN INTERFACES -->
		<ul class="collapsible" data-collapsible="accordion">
			<li>
				<div class="collapsible-header active"><i class="material-icons">settings_input_antenna</i>Interfaces</div>
				<div class="collapsible-body">
					<ul class="collapsible" data-collapsible="expandable">
						<tpl:info_interfaces>
						
					</ul>
				</div>
			</li>
		</ul>
		<!-- END INTERFACES -->
	</div>
</div>