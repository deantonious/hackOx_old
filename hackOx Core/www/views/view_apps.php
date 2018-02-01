<?php
	
	/**
	 * Page Content
	 */
	$apps = $this->database->query("SELECT * FROM " . T_PREFIX . "apps");
	
	$apps_rows = "";
	if ($apps->num_rows > 0) {
		while($row = $apps->fetch_assoc()) {
			$app_id 		= $row["app_id"];
			$app_installed 	= $row["app_installed"];
			$app_json 	= ROOT_PATH . "/apps/" . $row["app_directory"] . "/app.json";
			
			$file = file_get_contents($app_json);
			$json = json_decode($file, true);
			
			$name 			= $json["name"];
			$version 		= $json["version"];
			$author			= $json["author"];
			$description	= $json["description"];
			$run_command	= $json["author"];
			$script			= $json["script"];

			$apps_rows .= "
			<tr>
				<td>$app_installed</td>
				<td>$name</td>
				<td>$version</td>
				<td>$author</td>
				<td>$description</td>
				<td>$script</td>
				<td class=\"center\">
					<a class=\"btn-floating tooltipped waves-effect waves-light btn-action\" data-action=\"app_run_normal\" data-app-id=\"$app_id\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Run\"><i class=\"material-icons\">play_circle_outline</i></a>
					<a class=\"btn-floating tooltipped waves-effect waves-light orange btn-action\" data-action=\"app_run_sudo\" data-app-id=\"$app_id\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Run as root\"><i class=\"material-icons\">play_circle_filled</i></a>
					<a class=\"btn-floating tooltipped waves-effect waves-light red btn-action\" data-action=\"app_remove\" data-app-id=\"$app_id\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Uninstall\"><i class=\"material-icons\">delete</i></a>
				</td>
			</tr>";
		}
	} else {
		$apps_rows .= "<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
	}
	
	$controller->set("apps", $apps_rows);
	$controller->set("output", "<pre>Run an application to get an output...</pre>");
	
	$repo_apps_rows = "";
	$apps_repo_url = "https://repo.hackox.net/apps/";
	if(ENABLE_REPOS) {
		try {
			$repo_apps_json = @file_get_contents($apps_repo_url . "applications.json");

			if ($repo_apps_json) {
				$repo_apps = json_decode($repo_apps_json, true);
				
				foreach ($repo_apps as $app) {	
					$name 			= $app["name"];		
					$version 		= $app["version"];
					$author 		= $app["author"];
					$last_update 	= $app["last_update"];
					$description 	= $app["description"];
					$file 			= $app["file"];
					$app_url		= $apps_repo_url . $file;

					$repo_apps_rows .= "
							<tr>
								<td>$name</td>
								<td>$version</td>
								<td>$author</td>
								<td>$last_update</td>
								<td>$description</td>
								<td class=\"center\">
									<a class=\"btn-floating tooltipped waves-effect waves-light btn-action\" data-action=\"app_download\" data-app-url=\"$app_url\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Install App\"><i class=\"material-icons\">get_app</i></a>
								</td>
							</tr>";
					
				}
				
			}
		} catch (Exception $e) {
			//TODO: make this thing cooler 
			echo "Repo not available :(";
		}
	} else {
		$repo_apps_rows .= "<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
	}
	
	$controller->set("apps_repo", $repo_apps_rows);
	
	//Load app logs
	$logs = "";
	$log_dir = "/var/hackox/logs/apps";
	$log_files = glob("$log_dir/*.{log}", GLOB_BRACE);
	foreach($log_files as $file) {
		$content = file_get_contents($file);
		$file_name = basename($file).PHP_EOL;
		$logs .= "<span class=\"title\">$file_name</span><div class=\"log-block\">$content</div>";
	}
	$controller->set("apps_logs", $logs);
	

	
	

	