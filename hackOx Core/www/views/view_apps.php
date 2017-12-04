<?php
	
	/**
	 * Page Content
	 */
	$apps = $this->database->query("SELECT * FROM " . T_PREFIX . "apps");
	
	$apps_rows = "";
	if ($apps->num_rows > 0) {
		while($row = $apps->fetch_assoc()) {

			$app_id 				= $row["app_id"];
			$app_name 				= $row["app_name"];
			$app_version 			= $row["app_version"];
			$app_author 			= $row["app_author"];
			$app_description 		= $row["app_description"];
			$app_file 				= $row["app_file"];
			$app_installed 			= $row["app_installed"];
			$apps_rows .= "
			<tr>
				<td>$app_installed</td>
				<td>$app_name</td>
				<td>$app_version</td>
				<td>$app_author</td>
				<td>$app_description</td>
				<td>$app_file</td>
				<td class=\"center\">
					<a class=\"btn-floating tooltipped waves-effect waves-light btn-run-app\" data-app-id=\"$app_id\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Run\"><i class=\"material-icons\">play_circle_outline</i></a>
					<a class=\"btn-floating tooltipped waves-effect waves-light orange btn-sudo-run-app\" data-app-id=\"$app_id\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Run as root\"><i class=\"material-icons\">play_circle_filled</i></a>
					<a class=\"btn-floating tooltipped waves-effect waves-light red btn-remove-app\" data-app-id=\"$app_id\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Uninstall\"><i class=\"material-icons\">delete</i></a>
				</td>
			</tr>";
		}
	} else {
		$apps_rows .= "<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
	}
	
	$controller->set("apps", $apps_rows);
	$controller->set("output", "<pre>Run an application to get an output...</pre>");
	
	$repo_apps_rows = "";
	$apps_repo_url = "https://hackox.net/repo/apps/";
	try {
		$repo_apps_json = @file_get_contents($apps_repo_url . "applications.json");

		if ($repo_apps_json) {
			$repo_apps = json_decode($repo_apps_json, true);
			$repo_apps_available = 0;
			
			foreach ($repo_apps as $app) {
				$app_name 				= $app["name"];
				$app_version 			= $app["version"];
				$app_author 			= $app["author"];
				$app_description 		= $app["description"];
				$app_last_update		= $app["last_update"];
				$app_file				= $app["file"];
				$app_url				= $apps_repo_url . $app_file;
				
				$app_list = $this->database->query("SELECT * FROM " . T_PREFIX . "apps WHERE app_name='$app_name' AND app_author='$app_author'");
				
				if($app_list->num_rows == 0) {
					$repo_apps_available++;
					$repo_apps_rows .= "
						<tr>
							<td>$app_name</td>
							<td>$app_version</td>
							<td>$app_author</td>
							<td>$app_last_update</td>
							<td>$app_description</td>
							<td class=\"center\">
								<a class=\"btn-floating tooltipped waves-effect waves-light btn-download-app\" data-app-url=\"$app_url\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Install App\"><i class=\"material-icons\">get_app</i></a>
							</td>
						</tr>";
				}
				
			}
			
			if($repo_apps_available == 0)
					$repo_apps_rows .= "<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
		}
	} catch (Exception $e) { }
	
	
	
	$controller->set("apps_repo", $repo_apps_rows);
	
	
	

	