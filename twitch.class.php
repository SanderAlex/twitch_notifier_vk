<?php
	class Twitch {
		private $token;

		function __set($token, $value) {
			$this->token = $value;
		}

		function __get($token) {
			return $this->token;
		}

		function getToken($code) {
			$data = array();
 
			$data['client_id'] = '6xqgow00r4oayhfk8c65ktzv1ns548m';
			$data['client_secret'] = '7cmcs3mha8mlj60yiy29b4dbgaapncq';
			$data['grant_type'] = 'authorization_code';
			$data['redirect_uri'] = 'http://localhost/twitch/authentication.php';
			$data['code'] = $code;

			$ch = curl_init('https://api.twitch.tv/kraken/oauth2/token');
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	 
			$res = curl_exec($ch);

			curl_close($ch);

			$res = json_decode($res, true);
			$this->token = $res['access_token'];
		}

		function getUserInfo() {
			$ch = curl_init("https://api.twitch.tv/kraken/user?oauth_token=$this->token");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$res = curl_exec($ch);

			curl_close($ch);

			return json_decode($res, true);
		}

		function getFollows($user_name) {
			$ch = curl_init("https://api.twitch.tv/kraken/users/$user_name/follows/channels");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

			$res = curl_exec($ch);

			curl_close($ch);

			return json_decode($res, true);
		}

		function isStream() {
			$streams = array();
			$limit = 100;
			$offset = 0;
			do {
				$some_streams = array();
				$ch = curl_init("https://api.twitch.tv/kraken/streams/followed?oauth_token=$this->token&limit=$limit&offset=$offset");
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

				$res = curl_exec($ch);

				curl_close($ch);
				$some_streams = json_decode($res, true);

				foreach ($some_streams['streams'] as $key => $value) {
					$streams[$value['channel']['name']] = $value['viewers'];
				}
				$offset += $limit;

			}
			while(count($some_streams['streams']) == $limit);
			
			return $streams;
		}
	}
?>