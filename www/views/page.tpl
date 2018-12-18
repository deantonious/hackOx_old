<!DOCTYPE html>
<html>
	<head>
		<link type="text/css" rel="stylesheet" href="css/materialize.min.css"  media="screen,projection"/>
		<link type="text/css" rel="stylesheet" href="css/style.css?v=15"  media="screen,projection"/>
		<link rel="icon" type="image/png" href="favicon.png" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
		<title>{{ main_title }} | {{ title }}</title>
	</head>
	<body class="grey darken-3">
		{{ navbar }}
		<div class="container">
			<div class="row">
				<div class="card grey darken-4">
					<div class="card-content white-text">
						<span class="card-title">{{ title }}</span>
						{{ content }}
					</div>
				</div>
			</div>
		</div>
		<script type="text/javascript" src="js/materialize.min.js"></script>
		<script type="text/javascript" src="js/scripts.js"></script>
    </body>
</html>