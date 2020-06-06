<?php
	include 'utils.php';
	/*
	http://web.ist.utl.pt/~ist425319/getTs.php?username=hello
	*/	
	/* Receives request to  create new account*/
	$username = $_GET['username'];
	$response = array();
	
	if(check_username($username)){	
		$response = get_Ts($username);
	}
	/*else{
	}*/
   	echo(json_encode($response));

?>
