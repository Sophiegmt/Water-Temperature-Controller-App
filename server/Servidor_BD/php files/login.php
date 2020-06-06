<?php
	include 'utils.php';
	session_start();
	/* 
	http://web.ist.utl.pt/~ist425319/login.php?username=hello&password=world
	*/

	/* Receives credentials to login*/
	$username = $_GET['username'];
	$password = $_GET['password'];
 	
	$response = array_fill_keys(array('error', 'message'), NULL);
	$myfile = fopen( "username.txt", "w");

	if(check_username($username)){
		if(check_pass($username,$password)){
			/*Log-in*/
			$_SESSION['username'] = $username;
			$response['error'] = false;
			$response['message'] = 'success';
			if($myfile){
				fwrite($myfile, json_encode($username));
				fclose($myfile);
			}
		}
		/* Invalid password */
		else{
			$response['error'] = true;
			$response['message'] = 'Invalid password';
		}
	}
	else{
		/* Invalid username*/ 
		$response['error'] = true;
		$response['message'] = 'Invalid username';
	}
	echo(json_encode($response));
	echo(json_encode($_SESSION));
	echo(json_encode(session_id()));
?>