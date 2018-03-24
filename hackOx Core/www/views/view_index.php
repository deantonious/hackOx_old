<?php
	
	$aux = "";
	//Load System Information
	$controller->set("info_system_software", SW_VER);
	$controller->set("info_system_date", date('D M j H:i:s T Y'));
	$controller->set("info_system_uptime", shell_exec("uptime -p"));
	$controller->set("info_system_hostname", shell_exec("hostname"));
	
	
	//Load CPU Information
	$controller->set("info_cpu_processor", str_replace("Processor	:", "", shell_exec("cat /proc/cpuinfo | grep 'Processor' | uniq")));
	$controller->set("info_cpu_architecture", shell_exec("arch"));
	$load_avg = shell_exec("uptime | sed -n -e 's/^.*e: //p'");
	$controller->set("info_cpu_avg", $load_avg);
	$controller->set("info_cpu_avg_per", round(array_sum(explode(",", $load_avg))/3*100));
	
	$bogomips = explode("\n", shell_exec("cat /proc/cpuinfo | grep BogoMIPS"));
	
	for($i = 0; $i < count($bogomips)-1; $i++) {
		$v = str_replace("BogoMIPS	:", "", $bogomips[$i]);
		$aux .= "<div class=\"row\"><div class=\"col s4\">BogoMIPS ($i)</div><div class=\"col s6\">$v</div></div>";
	}
	$controller->set("info_cpu_bogomips", $aux);
	
	

	//Load Memory Information
	$mem = shell_exec("free -m | grep Mem");
	$mem = str_replace("Mem:", "", $mem);
	$mem = explode(" ", preg_replace("!\s+!", " ", $mem));
	$controller->set("info_ram_total", $mem[1]);
	$controller->set("info_ram_use", round($mem[2]/$mem[1]*100));
	$controller->set("info_ram_used", $mem[2]);
	
	$swap = shell_exec("free -m | grep Swap");
	$swap = str_replace("Swap:", "", $swap);
	$swap = explode(" ", preg_replace("!\s+!", " ", $swap));
	$controller->set("info_swap_total", $swap[1]);
	$controller->set("info_swap_use", round($swap[2]/$swap[1]*100));
	$controller->set("info_swap_used", $swap[2]);

	//Load Storage Information
	$aux = shell_exec("df -h | grep -v File");
	$aux = preg_replace("!\s+!", " ", $aux);
	
	$storage = explode(" ", $aux);
	$aux = "";
	for($i = 0; $i < count($storage)-1; $i += 6) {
		$filesystem = $storage[$i];
		$size = $storage[$i+1];
		$used = $storage[$i+2];
		$available = $storage[$i+3];
		$use = $storage[$i+4];
		$mounted = $storage[$i+5];
		$aux .= "<div class=\"row\"><div class=\"col s2\">$filesystem</div><div class=\"col s2\">$mounted</div><div class=\"col s5\"><div class=\"progress tooltipped\" data-position=\"top\" data-delay=\"50\" data-tooltip=\"$use\"><div class=\"determinate\" style=\"width: $use;\"></div></div></div><div class=\"col s3\">$used / $size</div></div>";
	}
	
	$controller->set("info_storage", $aux);
	
	//Load Interfaces Information
	$aux = "";

	$interfaces = getInterfaces();
	foreach($interfaces as $interface) {
		$name = $interface["name"];
		$enabled = $interface["enabled"];
		$mac = $interface["mac"];
		$ip = $interface["ip"];
		$broadcast = $interface["broadcast"];
		$netmask = $interface["netmask"];
		
		if($enabled == "true") {
			$enabled = "<a class=\"waves-effect waves-light btn red btn-action\" data-action=\"interface_disable\" data-interface=\"$name\"><i class=\"material-icons left\">portable_wifi_off</i>disable</a>";
			$icon = "wifi_tethering";
		} else {
			$enabled = "<a class=\"waves-effect waves-light btn btn-action\" data-action=\"interface_enable\" data-interface=\"$name\"><i class=\"material-icons left\">wifi_tethering</i>enable</a>";
			$icon = "portable_wifi_off";
		}
		$aux .= "<li>
					<div class=\"collapsible-header active\"><i class=\"material-icons\">$icon</i>Interface: $name</div>
					<div class=\"collapsible-body\">
						<div class=\"row\">
							<div class=\"col s5\">
								MAC Address
							</div>
							<div class=\"col s5\">
								$mac
							</div>
						</div>
						<div class=\"row\">
							<div class=\"col s5\">
								IP Address
							</div>
							<div class=\"col s5\">
								$ip
							</div>
						</div>
						<div class=\"row\">
							<div class=\"col s5\">
								Subnet Mask
							</div>
							<div class=\"col s5\">
								$netmask
							</div>
						</div>
						<div class=\"row center\">
							$enabled
						</div>
					</div>
				</li>";
	}
	$controller->set("info_interfaces", $aux);
	
	
	