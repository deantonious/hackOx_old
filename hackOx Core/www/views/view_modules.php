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

			$module_json = json_decode(file_get_contents(ROOTPATH . "/modules/$module_directory/module.json"), true);

			$module_name = $module_json["info"]["name"];
			$module_version = $module_json["info"]["version"];
			$module_author = $module_json["info"]["author"];
			$module_description = $module_json["info"]["description"];
			
			$enabled = "";
			if($module_enabled == 1)
				$enabled = "checked";
			$modules_rows .= "
			<tr>
				<td>$module_name</td>
				<td>$module_version</td>
				<td>$module_description</td>
				<td>$module_author</td>
				<td class=\"center\">
					<a class=\"switch\"><label><input type=\"checkbox\" data-module-id=\"$module_id\" $enabled><span class=\"lever\"></span>Enabled\t</label></a>
					<a class=\"btn-floating tooltipped waves-effect waves-light\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Open Panel\" href=\"/index.php?p=$view_id \"><i class=\"material-icons\">open_in_new</i></a>
					<a class=\"btn-floating tooltipped waves-effect waves-light red btn-remove-app\" data-app-id=\"$view_id\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"Uninstall\"><i class=\"material-icons\">delete</i></a>
				</td>
			</tr>";
		}
	} else {
		$modules_rows .= "<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
	}
	
	$controller->set("modules", $modules_rows);