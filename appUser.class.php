<?php
	class appUser {
		private $vk_id;
		private $twitch_id;
		private $twitch_name;
		private $twitch_token;

		function __construct($id, $tw_id, $tw_name, $tw_token) {
			$this->vk_id = $id;
			$this->twitch_id = $tw_id;
			$this->twitch_name = $tw_name;
			$this->twitch_token = $tw_token;		
		}

		function __get($twitch_token) {
			return $this->twitch_token;
		}

		function account() {
			global $twitch;
			if($this->twitch_id) {
				echo "<div id='links'><a href='http://www.twitch.tv/$this->twitch_name/profile' target='_blank' id='account_link'>$this->twitch_name</a></div>";
				echo "<div id='menu'>";
				echo "<a href='http://localhost/twitch?unbind=1' class='other_link'>ПОДКЛЮЧИТЬ ДРУГОЙ АККАУНТ</a>";
				echo "<a href='#' class='other_link'>НАСТРОЙКИ</a>";
				echo "</div>";
				return $twitch->getFollows($this->twitch_name);
			}
			else {
				header('Location: http://localhost/twitch/authentication.php');
				die();
			}
		}

		function followsList($follows) {
			global $twitch;
			if(!$follows['_total'])
				echo "<div id='noChannels'>Вы не следите ни за одним каналом</div>";
			else {
				$streams  = $twitch->isStream();
				foreach ($follows['follows'] as $key => $value) {
					echo "<div class='follow'>";
					if ($value['channel']['logo'])
						echo "<img src='".$value['channel']['logo']."'>";
					else
						echo "<img src='http://static-cdn.jtvnw.net/jtv_user_pictures/xarth/404_user_150x150.png'>";
					echo "<a href='".$value['channel']['url']."' target='_blank'>".$value['channel']['display_name']."</a>";
					if(isset($streams[$value['channel']['name']]))
						echo "<div class='statusOnline'><img src='img/viewer.png'><span>".number_format($streams[$value['channel']['name']])."</span>Live</div>";
					else
						echo "<div class='statusOffline'>offline</div>";				
					echo "</div>";
				}
			}
		}
	}
?>