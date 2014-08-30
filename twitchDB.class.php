<?php
	class twitchDB extends mysqli {
		const DB_NAME = "vktwitch";

		function __construct($host, $port, $user, $pass) {
			parent::init();
			if(!parent::real_connect($host, $user, $pass, self::DB_NAME, $port)) {
            	die('Ошибка подключения (' . mysqli_connect_errno() . ') ' . mysqli_connect_error());
        	}
		}

		function newUser($user_id) {
			try {
				if($result = parent::query("CALL new_user($user_id)")) {
					return $result->fetch_all(MYSQLI_ASSOC);
				}
				else {
					throw new Exception($this->error);
				}
			}
			catch(Exception $e) {
				echo $e;
			}	
		}

		function attachTwitch($vk_id, $twitch_id, $twitch_name, $twitch_token) {
			try {
				if(!$result = parent::query("CALL attach_twitch($vk_id, $twitch_id, '$twitch_name', '$twitch_token')")) {
					throw new Exception($this->error);
				}
			}
			catch(Exception $e) {
				echo $e;
			}				
		}

		function unbindTwitch($vk_id) {
			try {
				if(!$result = parent::query("CALL unbind_twitch($vk_id)")) {
					throw new Exception($this->error);
				}
			}
			catch(Exception $e) {
				echo $e;
			}
			header('Location: http://twitch.tv/logout');
			die();
		}
	}
?>