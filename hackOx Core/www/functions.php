<?php 

	function checkSession() {
		if(isset($_SESSION['username'])) {
			return true;
		}
		return false;
	}
	
	function testConnection($url, $port) {
		if($fs = @fsockopen($url, $port, $num, $error, 5)) {
			return true;
		}
		return false;
	}
	
	function getInterfaces() {
		$interface_names = shell_exec("ip link show | awk 'NR%2!=0' | cut -d ':' -f 2");
		$interface_names = str_replace("lo\n", "", $interface_names);
		$interface_names = str_replace(" ", "", $interface_names);
		$interface_names = str_replace("\n", ",", $interface_names);
		$interface_names = substr($interface_names, 0, -1);
		$interface_names = explode(",", $interface_names);
		
		$interfaces = array();
		foreach($interface_names as $interface_name) {
			$interface = array();
			$interface["name"] = $interface_name;
			
			if(shell_exec("ip link show $interface_name up") != "") {
				$interface["enabled"] = "true";
			} else {
				$interface["enabled"] = "false";
			}
			
			$interface_data = shell_exec("ip addr show $interface_name");
			
			preg_match("/.*link\/ether\s([a-fA-F0-9:]{17}).*/ims", $interface_data, $regex);
			if(count($regex) > 0) {
				$interface["mac"] = $regex[1];
			} else {
				$interface["mac"] = "-";
			}
			
			preg_match("/.*inet\s(([0-9]?[0-9]?[0-9]\.){3}([0-9]?[0-9]?[0-9])).*/ims", $interface_data, $regex);
			if(count($regex) > 0) {
				$interface["ip"] = $regex[1];
			} else {
				$interface["ip"] = "-";
			}
			
			preg_match("/.*brd\s(([0-9]?[0-9]?[0-9]\.){3}([0-9]?[0-9]?[0-9])).*/ims", $interface_data, $regex);
			if(count($regex) > 0) {
				$interface["broadcast"] = $regex[1];
			} else {
				$interface["broadcast"] = "-";
			}
			
			preg_match("/.*inet\s(([0-9]?[0-9]?[0-9]\.){3}([0-9]?[0-9]?[0-9])\/[1-4][0-9]?).*/ims", $interface_data, $regex);
			if(count($regex) > 0) {
				$cidr = substr($regex[1], strpos($regex[1], '/') + 1) * 1;
				$netmask = str_split(str_pad(str_pad('', $cidr, '1'), 32, '0'), 8);
				foreach ($netmask as &$element) $element = bindec($element);
				$interface["netmask"] = join('.', $netmask);
	
			} else {
				$interface["netmask"] = "-";
			}
			
			$interfaces[] = $interface;
		}
		return $interfaces;
		
	}
