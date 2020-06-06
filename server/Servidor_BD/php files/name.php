<?php 
	if (!isset($_SESSION)){
	   session_start();
	}
	$username = $_SESSION['username'];
	$response = $username;
	echo(json_encode($response));
	echo(json_encode($_SESSION));
	echo(json_encode(session_id()));

?>