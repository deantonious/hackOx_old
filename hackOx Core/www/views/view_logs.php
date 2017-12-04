<?php
	
	/**
	 * Page Content
	 */
	$main = new Template("views/view_logs.tpl");
	$logs = $this->database->query("SELECT * FROM " . T_PREFIX . "logs");
	
	$log_rows = "";
	if ($logs->num_rows > 0) {
		while($row = $logs->fetch_assoc()) {

			$id 		= $row['id'];
			$log_date 	= $row['log_date'];
			$log_action = $row['log_action'];
			$log_data 	= $row['log_data'];
			$log_rows  .= "<tr><td>$id</td><td>$log_date</td><td>$log_action</td><td>$log_data</td></tr>";
		}
	} else {
		$log_rows .= "<tr><td>N/A</td><td>N/A</td><td>N/A</td><td>N/A</td></tr>";
	}
	
	$main->set("logs", $log_rows);