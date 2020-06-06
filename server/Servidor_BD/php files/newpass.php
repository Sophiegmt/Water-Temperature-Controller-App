<?php
	include 'utils.php';
	/*
	http://web.ist.utl.pt/~ist425319/newpass.php?username=hello&password=world&newpass=work
	*/	
	/* Receives request to  create new account*/
	$username = $_GET['username'];
	$password = $_GET['password'];
	$new_pass = $_GET['newpass'];
	$response = array_fill_keys(array('error', 'message'), NULL);

	if(check_username($username)){
		if(check_pass($username, $password)){
			/*Log-in*/
			if((strcmp($password, $new_pass))!=0){
				if(change_pass($username,$password, $new_pass)){
					$response['error'] = false;
					$response['message'] = 'Successful password update';
				}
				else{
					$response['error'] = true;
					$response['message'] = 'Failed to change pass';
				}
			}
			else{
				$response['error'] = true;
				$response['message'] = 'New pass cant be old pass';
			}
		}
	}
	else{
		$response['error'] = true;
		$response['message'] = 'User not in DB';
	}
   	echo(json_encode($response));
?>
