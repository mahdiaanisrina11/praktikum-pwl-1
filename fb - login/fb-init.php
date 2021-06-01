<?php
//session_start();

require './vendor/autoload.php';

$fb = new Facebook\Facebook([
    'app_id' => '2844057949195046',
    'app_secret' => '376b6f4184a32483bb2c8eb0a70a71d5',
    'default_graph_version' => 'v2.7'
]);

$helper = $fb->getRedirectLoginHelper();
$login_url = $helper->getLoginUrl("http://localhost/fb%20-%20login/");

try {
	$accessToken = $helper->getAccessToken();
	if (isset($accessToken)) {
		$_SESSION['access_token'] = (string)$accessToken;

		header("Location:index.php");
	}

	if (isset($_SESSION['access_token'])) {
		$fb->setDefaultAccessToken($_SESSION['access_token']);
		$respond = $fb->get('/me?locale=en_US&fields=name,email');
		$user = $respond->getGraphUser();
	}
} catch (Exception $exception) {
	echo $exception;
}

?>