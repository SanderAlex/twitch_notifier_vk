<?php
	session_start();
	require "twitch_db.inc.php";

	if(!isset($_SESSION["vk_id"]))
		$_SESSION["vk_id"] = $_GET["viewer_id"];	//id пользователя vk

	if(isset($_GET['unbind']))
		$db->unbindTwitch($_SESSION["vk_id"]);

	if($user_data = $db->newUser($_SESSION["vk_id"])) {
		$user = new appUser($user_data[0]["vk_id"], $user_data[0]["tw_user"], $user_data[0]["tw_name"], $user_data[0]["tw_token"]);
		$twitch = new Twitch();
		$twitch->token = $user->twitch_token;
	}
	else {
		echo "Возникла ошибка.";
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Vk-Twitch</title>
		<meta charset="utf-8">
		<link rel="stylesheet" href="style.css">
		<script src="jquery-2.1.1.min.js"></script>
		<script src="//vk.com/js/api/xd_connection.js?2" type="text/javascript"></script>
		<script src="script.js"></script>
	</head>
	<body>
		<div id="head">
			<div id="twitch_img">
				<a href="http://twitch.tv/" target='_blank'><img src="img/twitch.png"></a>
			</div>
			<?php
				$follows = $user->account();
			?>
		</div>
		<div id="follows">
			<?php
				//print_r($follows['follows'][0]);
				$user->followsList($follows);
			?>
		</div>
	</body>	
</html>