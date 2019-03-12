<?php

	session_start();
	spl_autoload_register();
	
	$fb = new Facebook\Facebook([
  				'app_id' => '253545741848173',
	  			'app_secret' => '80a13f195788fd31f969e619cd2c3655',
	  			'default_graph_version' => 'v2.11',
  			]);

    $helper = $fb->getRedirectLoginHelper();

	$permissions = ['email']; // Optional permissions
	$loginUrl = $helper->getLoginUrl('https://mayyur.azurewebsites.net/Facebook_Album_Downloader/callback.php', $permissions);

	// Redirect From Facebook
	header("location:" . $loginUrl);

?>