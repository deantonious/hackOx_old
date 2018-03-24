<?php

	session_start();
	include("../load.php");

	$response = new Response();
	$log = new LogManager();
	$log->loadDB($database);
	
	if(checkSession()) {
		if(isset($_POST["function"])) {
			$function = $_POST["function"];
			/**
			 *	MAIN CONFIGURATION
			 *
			 */
			
			if($function == "power_system") {
				$action = $_POST["action"];
				if($action == "shutdown") {
					$out = shell_exec("sudo shutdown -h now");
					$response->set(0, "See you next time!");
				}
				if($action == "reboot") {
					$out = shell_exec("sudo shutdown -r now");
					$response->set(0, "See you in a few minutes!");
				}
			}
			
			if($function == "config_interface") {
				$interface_name = $_POST["interface_name"];
				$interface_action = $_POST["interface_action"];
				
				if($interface_action == "enable") {
					$out = shell_exec("sudo ip link set $interface_name up");
					$response->set(0, "Interface $interface_name successfully enabled!");
				}
				if($interface_action == "disable") {
					$out = shell_exec("sudo ip link set $interface_name down");
					$response->set(0, "Interface $interface_name successfully disabled!");
				}
			}
			
			if($function == "config_update") {
				$query = "";
				if(isset($_POST['dev_name'])) {
					$dev_name = $database->real_escape_string($_POST['dev_name']);
					shell_exec("echo '".$_POST['dev_name']."' > /etc/hostname; sudo /etc/init.d/hostname.sh");
					$query .= "dev_name='$dev_name'";
				}
				if(isset($_POST['dev_remote_url'])) {
					$dev_remote_url = $database->real_escape_string($_POST['dev_remote_url']);
					$query .= ", dev_remote_url='$dev_remote_url'";
				}
				if(isset($_POST['dev_id'])) {
					$dev_id = $database->real_escape_string($_POST['dev_id']);
					$query .= ", dev_id='$dev_id'";
				}
				if(isset($_POST['dev_key'])) {
					$dev_key = $database->real_escape_string($_POST['dev_key']);
					$query .= ", dev_key='$dev_key'";
				}
				if(isset($_POST['dev_admin_usr'])) {
					$dev_admin_usr = $database->real_escape_string($_POST['dev_admin_usr']);
					$query .= ", dev_admin_usr='$dev_admin_usr'";
				}
				if(isset($_POST['dev_password']) && strlen($_POST['dev_password']) > 1) {
					$dev_password = hash('sha512', PASSWORD_SALT . $database->real_escape_string($_POST['dev_password']));
					$query .= ", dev_password='$dev_password'";
				}
				
				if($database->query("UPDATE " . T_PREFIX . "config SET $query WHERE id='1'")) {
					$response->set(0, "Configuration updated!");
				}
			}

			/**
			 *	APPLICATION ACTIONS	
			 *
			 */
			 
			// Upload and install app
			if($function == "app_upload") {	
				if(isset($_FILES["app_file"])) {
					$app_dir = ROOT_PATH . "/apps/" . basename($_FILES["app_file"]["name"], ".zip");
					$target_file = $app_dir . "/" .  basename($_FILES["app_file"]["name"]);
					
					$file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
		
					$upload = true;
					if (!file_exists($app_dir)) {
						mkdir($app_dir, 0750, true);
					} else {
						$upload = false;
						$response->set(1, "The file already exists");
					}
					
					if($file_extension != "zip") {
						$upload = false;
						$response->set(1, "Upload a valid .zip file");
					}
					
					if($upload) {
						if (move_uploaded_file($_FILES["app_file"]["tmp_name"], $target_file)) {
							//INSTALL APP
							$application = new Application($database);
							if($application->install($app_dir, $_FILES["app_file"]["name"])) {
								$response->set(0, "App successfully installed!");
							} else {
								$response->set(1, "Error while installing the app");
							}
						} else {
							$response->set(1, "Error while uploading the file ");
						}
					}
				}
			}
			
			// Download and install app
			if($function == "app_download") {
				$url = $_POST["app_url"];
				$zip_name = basename($url, ".zip");
				$app_directory = ROOT_PATH . "/apps/" . $zip_name;
				$zip_file = $app_directory . "/" . $zip_name . ".zip";
				
				$download = true;
				if (!file_exists($app_directory)) {
					mkdir($app_directory, 0750, true);
				} else {
					$download = false;
					$response->set(1, "The new app directory is already in use...");
				}
				
				if($download) {
					file_put_contents($zip_file, fopen($url, "r"));

					$application = new Application($database);
					if($application->install($app_directory, $zip_name . ".zip")) {
						$response->set(0, "App successfully installed!");
					} else {
						$response->set(1, "Error while installing the app");
					}
				}
			}
			
			// Run application
			if($function == "app_run") {
				if(isset($_POST["app_id"]) && isset($_POST["app_args"]) && isset($_POST["app_run_mode"])) {
					$app_id = $database->real_escape_string($_POST["app_id"]);
					$app_args = $_POST["app_args"];
					
					$app = new Application($database);
					if($app->load($app_id)) {
						
						$app_out = $app->run($app_args, $_POST["app_run_mode"]);
						$log->addAppLog($app_id, $app_out);
						$response->setWData(0, "App successfully executed", $app_out);
					} else {
						$response->set(1, "App id not found");
					}
				} else {
					$response->set(1, "No app id or mode set");
				}
			}
			
			// Uninstall app
			if($function == "app_remove") {
				$app_id = $_POST["app_id"];
				$application = new Application($database);
				$application->load($app_id);
				
				if($application->remove()) {
					$response->set(0, "App successfully uninstalled!");
				} else {
					$response->set(1, "Error while uninstalling the app");
				}
			}
			
			/**
			 *	MODULE ACTIONS	
			 *
			 */
			
			// Upload and install module
			if($function == "module_upload") {	
				if(isset($_FILES["module_file"])) {
					$module_dir = ROOT_PATH . "/modules/" . basename($_FILES["module_file"]["name"], ".zip");
					$target_file = $module_dir . "/" .  basename($_FILES["module_file"]["name"]);
					
					$file_extension = pathinfo($target_file, PATHINFO_EXTENSION);
		
					$upload = true;
					if (!file_exists($module_dir)) {
						mkdir($module_dir, 0750, true);
					} else {
						$upload = false;
						$response->set(1, "The new module directory is already in use...");
					}
					
					if($file_extension != "zip") {
						$upload = false;
						$response->set(1, "Upload a valid .zip file");
					}
					
					if($upload) {
						if (move_uploaded_file($_FILES["module_file"]["tmp_name"], $target_file)) {
							//INSTALL MODULE
							$module = new Module($database);
							if($module->install($module_dir, $_FILES["module_file"]["name"])) {
								$response->set(0, "Module successfully installed!");
							} else {
								$response->set(1, "Error while installing the module");
							}
						} else {
							$response->set(1, "Error while uploading the file ");
						}
					}
				}
			}
			
			// Download and install module
			if($function == "module_download") {
				$url = $_POST["module_url"];
				$zip_name = basename($url, ".zip");
				$module_dir = ROOT_PATH . "/modules/" . $zip_name;
				$zip_file = $module_dir . "/" . $zip_name . ".zip";
				
				$download = true;
				if (!file_exists($module_dir)) {
					mkdir($module_dir, 0750, true);
				} else {
					$download = false;
					$response->set(1, "The new module directory is already in use...");
				}
				
				if($download) {
					file_put_contents($zip_file, fopen($url, "r"));
					//INSTALL MODULE
					$module = new Module($database);
					if($module->install($module_dir, $zip_name . ".zip")) {
						$response->set(0, "Module successfully installed!");
					} else {
						$response->set(1, "Error while installing the module");
					}
				}
			}
			
			// Update module configuration
			if($function == "module_config_update") {
				if(isset($_POST["new_config"])) {
					$module_json = json_decode($_POST["new_config"], true);
					$module = new Module($database);
					$module->load($module_json["module_id"]);
					
					foreach($module_json["module_config"] as $key => $value) {
						$module->set($key, $value);
					}
					$response->set(0, "Configuration values updated!");
				} else {
					$response->set(1, "There's no new configuration values...");
				}
			}
			
			// Uninstall module
			if($function == "module_remove") {
				$module_id = $_POST["module_id"];
				
				$module = new Module($database);
				$module->load($module_id);
				
				if($module->remove()) {
					$response->set(0, "Module successfully uninstalled!");
				} else {
					$response->set(1, "Error while uninstalling the module");
				}
			}
			
		}
	}
	
	echo json_encode($response);
	
	
	