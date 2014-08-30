<?php
	session_start();

	require "twitch_db.inc.php";

	if($_GET['code']) {
		$twitch = new Twitch();

		$twitch->getToken($_GET['code']);

		$result = $twitch->getUserInfo();

		$db->attachTwitch($_SESSION["vk_id"], $result["_id"], $result["name"], $twitch->token);

		header("Location: http://localhost/twitch/index.php");
		die();
	}
	else {
		header('Location: https://api.twitch.tv/kraken/oauth2/authorize?response_type=code&client_id=6xqgow00r4oayhfk8c65ktzv1ns548m&redirect_uri=http://localhost/twitch/authentication.php&scope=user_read+user_follows_edit+user_subscriptions');
		die();
	}
?>