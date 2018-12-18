<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
		<link rel="icon" type="image/png" href="favicon.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>{{ main_title}} | {{ title }}</title>
		
		<meta name="module_name" content="{{ title }}">
		<meta name="module_dir" content="{{ dir }}">
		<meta name="module_id" content="{{ id }}">
	</head>
	<body class="grey darken-3">
		{{ navbar }}
		<div class="container">
			<div class="row">
				<div class="card grey darken-4">
					<div class="card-content white-text">
						<span class="card-title">{{ title }}</span>
						<div class="row">
							<div class="col s12">
							  <ul class="transparent tabs-fixed-width tabs">
								<li class="tab col s12 m3"><a href="#module_panel" class="white-text active" >Module Panel</a></li>
								<li class="tab col s12 m3"><a href="#module_output" class="white-text">Output</a></li>
								<li class="tab col s12 m3"><a href="#module_logs" class="white-text">Logs</a></li>
								<li class="tab col s12 m3"><a href="#module_about" class="white-text">About</a></li>
							  </ul>
							</div>
							<div class="tab-content" id="module_panel">
								{{ module_panel }}
							</div>
							<div class="tab-content" id="module_output">
								<div class="row">
									<span class="title">Output</span>
									<div class="module-output">
										{{ module_output }}
									</div>
								</div>
							</div>
							<div class="tab-content" id="module_logs">
								{{ module_logs }}
							</div>
							<div class="tab-content" id="module_about">
								{{ module_about }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
		<script type="text/javascript" src="js/module.js"></script>
		{{ scripts }}
    </body>
</html>