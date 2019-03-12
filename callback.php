<?php
  
	session_start();
	require_once('login.php');

	// Facebook API for getAccessToken
	try {
  		$accessToken = $helper->getAccessToken();
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
  		// When Graph returns an error
  		echo 'Graph returned an error: ' . $e->getMessage();
  		exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
  		// When validation fails or other local issues
  		echo 'Facebook SDK returned an error: ' . $e->getMessage();
  		exit;
	}


	// Logged in
	echo '<h3>Access Token</h3>';
	var_dump($accessToken->getValue());

	// Save the value of accessToken in Session
	$_SESSION['fb_access_token'] = (string) $accessToken;
	echo $_SESSION['fb_access_token'];
	header("Location: album.php");

?>