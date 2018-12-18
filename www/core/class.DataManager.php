<?php

	class DataManager { 		
		
		private $key;
		private $iv_size = "";
		
		public function __construct($key) {
			$this->key = pack('H*', $key);
			$this->iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
		}
	
		function encrypt($plain_text) {
			$iv = mcrypt_create_iv($this->iv_size, MCRYPT_RAND);
			$cipher_text = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, $plain_text, MCRYPT_MODE_CBC, $iv);

			$cipher_text = $iv . $cipher_text;
			return bin2hex($cipher_text);
			
		}
		
		function decrypt($plain_text) {
			$decoded_text = hex2bin($plain_text);
			$iv_dec = substr($decoded_text, 0, $this->iv_size);
			
			$decoded_text = substr($decoded_text, $this->iv_size);
			$decoded_text = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, $decoded_text, MCRYPT_MODE_CBC, $iv_dec);
			return $decoded_text;
		}
		
		function request($id, $url, $array) {
			$json_request = json_encode($array);
			$data = $this->encrypt($json_request);

			$postdata = http_build_query(array( 'id' => $id, 'data' => $data)); 
			$output = array('http' => array( 'method' => 'POST', 'header' => "Content-type: application/x-www-form-urlencoded\r\n" ."Referer: $url\r\n", 'content' => $postdata ));

			$response = file_get_contents($url, false, stream_context_create($output));
			if ($response === false) {
				$result = array('response' => 'error');
				return $result;
			}

			$decoded_text = $this->decrypt($response);
			$result = json_decode($decoded_text, true);
			return $result;

		}

	}