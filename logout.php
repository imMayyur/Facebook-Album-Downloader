<?php

	session_start();
	
	spl_autoload_register();

	session_destroy();

	header("location:index.php");

?>