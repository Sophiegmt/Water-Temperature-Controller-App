<?php /*This isnt used!!!*/
	include 'utils.php';
		session_start();

	/* 
	http://web.ist.utl.pt/~ist425319/login.php?username=hello&password=world
	*/

	/* Receives credentials to login*/
	$username = $_GET['username'];
	$password = $_GET['password'];

	/*$response = array_fill_keys(array('error', 'message'), NULL);*/
	$response = null;
	if(check_username($username)){
		if(check_pass($username,$password)){
			/*Log-in*/
			/*$response['error'] = false;
			$response['message'] = 'success';*/
			$responde = 'yes';
			$_SESSION['username'] = $username;
		}
		/* Invalid password */
		else{
			/*$response['error'] = true;
			$response['message'] = 'Invalid password';*/
			$responde = 'no';

		}
	}
	else{
		/* Invalid username*/ 
	/*	$response['error'] = true;
		$response['message'] = 'Invalid username';*/
					$responde = 'no';

	}
	echo($response);
	/*echo(json_encode($response));*/

?>