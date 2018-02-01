<?php
	
	/**
	 * Page Content
	 */
	$modules = $this->database->query("SELECT * FROM " . T_PREFIX . "modules");
	
	$modules_rows = "";
	if ($modules->num_rows > 0) {
		while($row = $modules->fetch_assoc()) {

			$module_id 				= $row["module_id"];
			$view_id 				= $row["view_id"];
			$module_installed 		= $row["module_installed"];
			$module_directory 		= $row["module_directory"];
			$module_enabled 		= $row["module_enabled"];

			$module_json = json_decode(file_get_contents(ROOT_PATH . "/modules/$module_directory/module.json"), true);

			$module_name = $module_json["info"]["name"];
			$module_version = $module_json["info"]["version"];
			$module_author = $module_json["info"]["author"];
			$module_description = $module_json["info"]["description"];
			
			$enabled = "";
			if($module_enabled == 1)
				$enabled = "checked";
			$modules_rows .= "
			<tr id=\"module-$module_id\">
				<td>$module_name</td>
				<td>$module_version</td>
				<td>$module_description</td>
				<td>$module_author</td>
				<td class=\"center\">
					<a class=\"switch\"><label><input type=\"checkbox\" data-module-id=\"$module_id\" $enabled><span class=\"lever\"></span>Enabled\t</label></a>
					<a class=\"btn-floating tooltipped waves-effect waves-light\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Open Panel\" href=\"/index.php?p=$view_id \"><i class=\"material-icons\">open_in_new</i></a>
					<a class=\"btn-floating tooltipped waves-effect waves-light red btn-action\" data-action=\"module_remove\" data-module-id=\"$module_id\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Uninstall\"><i class=\"material-icons\">delete</i></a>
				</td>
			</tr>";
		}
	} else {
		$modules_rows .= "<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
	}
	
	$controller->set("modules", $modules_rows);
	
	$repo_modules_rows = "";
	$modules_repo_url = "https://repo.hackox.net/modules/";
	if(ENABLE_REPOS) {
		try {
			$repo_modules_json = @file_get_contents($modules_repo_url . "modules.json");

			if ($repo_modules_json) {
				$repo_modules = json_decode($repo_modules_json, true);
				$repo_modules_available = 0;
				
				foreach ($repo_modules as $module) {
					$module_name 			= $module["name"];
					$module_version 		= $module["version"];
					$module_author 			= $module["author"];
					$module_description 	= $module["description"];
					$module_last_update		= $module["last_update"];
					$module_file			= $module["file"];
					$module_url				= $modules_repo_url . $module_file;
					
					$repo_modules_rows .= "
							<tr>
								<td>$module_name</td>
								<td>$module_version</td>
								<td>$module_author</td>
								<td>$module_last_update</td>
								<td>$module_description</td>
								<td class=\"center\">
									<a class=\"btn-floating tooltipped waves-effect waves-light btn-action\" data-action=\"module_download\" data-module-url=\"$module_url\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Install module\"><i class=\"material-icons\">get_app</i></a>
								</td>
							</tr>";
					
				}
				
			}
		} catch (Exception $e) { }
	} else {
		$repo_modules_rows .= "<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
	}
	
	$controller->set("modules_repo", $repo_modules_rows);
	
	
	
	