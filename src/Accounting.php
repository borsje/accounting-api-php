<?php
class Accounting {
	private $username;
	private $password;
	
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
	
	public function addInvoice($request) {
	}
	
	private function _call($url, $method, $data) {
		$curl = curl_init($url);
		
		if ($method == "POST") {
			curl_setopt($curl, CURLOPT_POST, true);
		}
		
		$json = json_encode($data);
		
		curl_setopt_array($curl, [
			CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
			CURLOPT_HTTPHEADER => [
				"Content-type: application/json",
				"Content-length: ".strlen($json)
			],
			CURLOPT_POSTFIELDS => $json,
			CURLOPT_USRPWD => $this->username.":".$this->password,
			CURLOPT_RETURNTRANSER = true
		]);
		
		return json_decode(curl_exec($curl));
	}
}
?>