
<nav class="grey darken-4" role="navigation">
    <div class="nav-wrapper container">
        <a href="" class="title-logo">
            {{ logo }}
        </a>
        <a href="#" data-target="mobile-menu" class="sidenav-trigger"><i class="material-icons">menu</i></a>
        <ul class="right hide-on-med-and-down">
            {{ tabs }}
        </ul>
    </div>
</nav>

<ul class="sidenav" id="mobile-menu">
    {{ tabs_mobile }}
</ul>

<div id="power-modal" class="modal modal-fixed-footer white-text">
    <div class="modal-content valign-wrapper center">
		<div class="row col s12">
			<div class="col s12 m4">
				<i class="large material-icons">power_settings_new</i>
				<a class="waves-effect waves-light btn red btn-action" data-action="shutdown">shutdown</a>
			</div>
			<div class="col s12 m4">
				<i class="large material-icons">refresh</i><br/>
				<a class="waves-effect waves-light btn red btn-action" data-action="reboot">reboot</a>
			</div>
			<div class="col s12 m4">
				<i class="large material-icons">exit_to_app</i><br/>
				<a class="waves-effect waves-light btn red" href="logout.php">logout</a>
			</div>
		</div>
    </div>
</div>