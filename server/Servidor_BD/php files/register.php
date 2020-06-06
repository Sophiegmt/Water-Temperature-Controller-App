		
<?php
	include 'utils.php';
	session_start();
	/*
http://web.ist.utl.pt/~ist425319/register.php?username=ola&password=world&minTemp=5&maxTemp=21&WBdefault=1
	*/	

	/* Receives request to  create new account*/
	$username = $_GET['username'];
	$password = $_GET['password'];
	$minTemp = $_GET['minTemp'];
    $maxTemp = $_GET['maxTemp'];    
    $WBdefault = $_GET['WBdefault'];


	$response = array_fill_keys(array('error', 'message'), NULL);

    /* 
    	check if username is already in DB - check_username
			yes
				error = true
				used username
			no
				check if valid values
					yes
						insert into DB new user
					no
						error = true
						value x = invalid
    */ 
	if(check_username($username)){
		$response['error'] = true;
		$response['message'] = 'Used username';	}
	else{

		if(check_minT($minTemp)){
			if(check_maxT($maxTemp)){
				if(valid_Ts($minTemp, $maxTemp)){
					if(check_WB($WBdefault)){
					/*check_mac??*/
					/*Insert new user into DB*/
						if(insert_user($username, $password, $minTemp, $maxTemp, $WBdefault)){
							$response['error'] = false;
							$response['message'] = 'New user inserted';		
							$_SESSION['username'] = $username;
						}
					}
					else{
						$response['error'] = true;
						$response['message'] = 'Invalid WBstatus';
					}
				}
				else{
						$response['error'] = true;
						$response['message'] = 'Invalid Tmin < Tmax';
				}	
			}
			else{
				$response['error'] = true;
				$response['message'] = 'Invalid maxT';
			}
		}
		else{
			$response['error'] = true;
			$response['message'] = 'Invalid minT';
		}
	}

	echo(json_encode($response));
?>
