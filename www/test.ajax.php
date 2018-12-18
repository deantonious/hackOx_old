<?php
	ini_set('display_errors', 'On');
	error_reporting(E_ALL);
include("core/database.php");
		
		/* //https://highon.coffee/blog/nmap-cheat-sheet/
		//https://hackertarget.com/nmap-cheatsheet-a-quick-reference-guide/
		$network = array();
		$xml = simplexml_load_string(shell_exec("cat /tmp/result.txt")) or die("Error: Cannot create object");
		//echo '<pre>'; print_r($xml); echo '</pre>';
		echo '<pre>';
		foreach($xml->host as $host) {
			//echo print_r($host);
			
			echo $host->address[0]->attributes()->addr;
			echo $host->address[1]->attributes()->addr;
			echo $host->address[1]->attributes()->vendor;
			echo "<br>";
		}
		
		echo '</pre>';
		 */

		
		//https://highon.coffee/blog/nmap-cheat-sheet/
		//https://hackertarget.com/nmap-cheatsheet-a-quick-reference-guide/
		 $network = array();
		$xml = simplexml_load_string(shell_exec("cat /tmp/result.txt")) or die("Error: Cannot create object");
/*
		foreach($xml->host as $host) {
			
			$dev = array();
			if(isset($host->address[0]->attributes()) && isset($host->address[1]->attributes())) {
				$dev["ip"] = $host->address[0]->attributes()->addr;
				$dev["mac"] = $host->address[1]->attributes()->addr;
				$dev["vendor"] = $host->address[1]->attributes()->vendor;
				$network[] = $dev;
				echo "cada";
			}
		}
		
		echo '<pre>'; print_r($network); echo '</pre>'; */
		echo '<pre>';
		print_r(xmlObjToArr($xml));
		echo '<pre>';
	function xmlObjToArr($obj) {
        $namespace = $obj->getDocNamespaces(true);
        $namespace[NULL] = NULL;
       
        $children = array();
        $attributes = array();
        $name = strtolower((string)$obj->getName());
       
        $text = trim((string)$obj);
        if( strlen($text) <= 0 ) {
            $text = NULL;
        }
       
        // get info for all namespaces
        if(is_object($obj)) {
            foreach( $namespace as $ns=>$nsUrl ) {
                // atributes
                $objAttributes = $obj->attributes($ns, true);
                foreach( $objAttributes as $attributeName => $attributeValue ) {
                    $attribName = strtolower(trim((string)$attributeName));
                    $attribVal = trim((string)$attributeValue);
                    if (!empty($ns)) {
                        $attribName = $ns . ':' . $attribName;
                    }
                    $attributes[$attribName] = $attribVal;
                }
               
                // children
                $objChildren = $obj->children($ns, true);
                foreach( $objChildren as $childName=>$child ) {
                    $childName = strtolower((string)$childName);
                    if( !empty($ns) ) {
                        $childName = $ns.':'.$childName;
                    }
                    $children[$childName][] = xmlObjToArr($child);
                }
            }
        }
       
        return array(
            'name'=>$name,
            'text'=>$text,
            'attributes'=>$attributes,
            'children'=>$children
        );
    } 