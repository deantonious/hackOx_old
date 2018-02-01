<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
		<link rel="icon" type="image/png" href="favicon.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<script type="text/javascript" src="js/jquery-3.2.1.min.js"></script>
		<title><tpl:main_title> | <tpl:title></title>
	</head>
	<body class="grey darken-3">
		<tpl:navbar>
		<div class="container">
			<div class="row">
				<div class="card grey darken-4">
					<div class="card-content white-text">
						<span class="card-title"><tpl:title></span>
						<div class="row">
							<div class="col s12">
							  <ul class="transparent tabs-fixed-width tabs">
								<li class="tab col s3"><a href="#module_panel" class="white-text active" >Module Panel</a></li>
								<li class="tab col s3"><a href="#module_output" class="white-text">Output</a></li>
								<li class="tab col s3"><a href="#module_logs" class="white-text">Logs</a></li>
								<li class="tab col s3"><a href="#module_about" class="white-text">About</a></li>
							  </ul>
							</div>
							<div class="tab-content" id="module_panel">
								<tpl:module_panel>
							</div>
							<div class="tab-content" id="module_output">
								<div class="row">
									<span class="title">Output</span>
									<div class="module-output">
										<tpl:module_output>
									</div>
								</div>
							</div>
							<div class="tab-content" id="module_logs">
								<span class="title"><tpl:module_log_file></span>
								<div class="log-block">
									<tpl:module_logs>
								</div>
							</div>
							<div class="tab-content" id="module_about">
								<tpl:module_about>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
		<script type="text/javascript" src="js/module.js"></script>
		<tpl:scripts>
    </body>
</html>