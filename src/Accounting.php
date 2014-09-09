<?php
class Accounting {
	private $username;
	private $password;
	
	public function __construct($username, $password) {
		$this->username = $username;
		$this->password = $password;
	}
	
	public function addInvoice($request) {
		return $this->_call("/invoices.json", "POST", $request);
	}
	
	private function _call($url, $method, $data) {
		$curl = curl_init("http://149.210.146.17/api".$url);
		
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
			CURLOPT_USERPWD => $this->username.":".$this->password,
			CURLOPT_RETURNTRANSFER => true
		]);
		$response = curl_exec($curl);
		
		if ($response !== false) {
			return json_decode($response);
		} else {
			return [
				"result" => "error",
				"errors" => [
					"general" => "Unknown."
				]
			];
		}
	}
}
?>