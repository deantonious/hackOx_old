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
	
	/**
	 * Source: https://gist.github.com/cschaba/4740380
	 *
	 */
	function getInterfaces() {
		$active_interfaces = shell_exec("ifconfig");
		$data = shell_exec("ifconfig -a");
		$interfaces = array();
		foreach(preg_split("/\n\n/", $data) as $int) {

			preg_match("/^([A-z]*\d)\s+Link\s+encap:([A-z]*)\s+HWaddr\s+([A-z0-9:]*).*" .
					"inet addr:([0-9.]+).*Bcast:([0-9.]+).*Mask:([0-9.]+).*" .
					"MTU:([0-9.]+).*Metric:([0-9.]+).*" .
					"RX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*frame:([0-9.]+).*" .
					"TX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*carrier:([0-9.]+).*" .
					"RX bytes:([0-9.]+).*\((.*)\).*TX bytes:([0-9.]+).*\((.*)\)" .
					"/ims", $int, $regex);

			if(!empty($regex)) {

				$interface = array();
				$interface["name"] = $regex[1];
				if (strpos($active_interfaces, $interface["name"]) === false) {
					$interface["enabled"] = "false";
				} else {
					$interface["enabled"] = "true";
				}
				$interface["type"] = $regex[2];
				$interface["mac"] = $regex[3];
				$interface["ip"] = $regex[4];
				$interface["broadcast"] = $regex[5];
				$interface["netmask"] = $regex[6];
				$interface["mtu"] = $regex[7];
				$interface["metric"] = $regex[8];

				$interface["rx"]["packets"] = (int) $regex[9];
				$interface["rx"]["errors"] = (int) $regex[10];
				$interface["rx"]["dropped"] = (int) $regex[11];
				$interface["rx"]["overruns"] = (int) $regex[12];
				$interface["rx"]["frame"] = (int) $regex[13];
				$interface["rx"]["bytes"] = (int) $regex[19];
				$interface["rx"]["hbytes"] = (int) $regex[20];

				$interface["tx"]["packets"] = (int) $regex[14];
				$interface["tx"]["errors"] = (int) $regex[15];
				$interface["tx"]["dropped"] = (int) $regex[16];
				$interface["tx"]["overruns"] = (int) $regex[17];
				$interface["tx"]["carrier"] = (int) $regex[18];
				$interface["tx"]["bytes"] = (int) $regex[21];
				$interface["tx"]["hbytes"] = (int) $regex[22];

				$interfaces[] = $interface;
			} else {
				preg_match("/^([A-z]*\d)\s+Link\s+encap:([A-z]*)\s+HWaddr\s+([A-z0-9:]*).*" .
					"MTU:([0-9.]+).*Metric:([0-9.]+).*" .
					"RX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*frame:([0-9.]+).*" .
					"TX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*carrier:([0-9.]+).*" .
					"RX bytes:([0-9.]+).*\((.*)\).*TX bytes:([0-9.]+).*\((.*)\)" .
					"/ims", $int, $regex);
				if(!empty($regex)) {
					$interface = array();
					$interface["name"] = $regex[1];
					
					if (strpos($active_interfaces, $interface["name"]) === false) {
						$interface["enabled"] = "false";
					} else {
						$interface["enabled"] = "true";
					}
					$interface["type"] = $regex[2];
					$interface["mac"] = $regex[3];
					$interface["ip"] = "-";
					$interface["broadcast"] = "-";
					$interface["netmask"] = "-";

					$interfaces[] = $interface;
				} else {
					preg_match("/^([A-z]*)\s+Link\s+encap:([A-z]*\s[A-z]*).*" .
						"inet addr:([0-9.]+).*Mask:([0-9.]+).*" .
						"MTU:([0-9.]+).*Metric:([0-9.]+).*" .
						"RX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*frame:([0-9.]+).*" .
						"TX packets:([0-9.]+).*errors:([0-9.]+).*dropped:([0-9.]+).*overruns:([0-9.]+).*carrier:([0-9.]+).*" .
						"RX bytes:([0-9.]+).*\((.*)\).*TX bytes:([0-9.]+).*\((.*)\)" .
						"/ims", $int, $regex);
					if(!empty($regex)) {
						$interface = array();
						$interface["name"] = $regex[1];
						if (strpos($active_interfaces, $interface["name"]) === false) {
							$interface["enabled"] = "false";
						} else {
							$interface["enabled"] = "true";
						}
						$interface["type"] = $regex[2];
						$interface["mac"] = "-";
						$interface["ip"] = $regex[3];
						$interface["broadcast"] = "-";
						$interface["netmask"] = $regex[4];

						$interfaces[] = $interface;
					}
				}
			}
		}
		return $interfaces;
	}
