<?php
	include 'utils.php';
	/*
	http://web.ist.utl.pt/~ist425319/updateTsW.php?username=hello&newTmin=2&newTmax=23&newWd=0
	*/	
	/* Receives request to  create new account*/
	$username = $_GET['username'];
	$newTmin = $_GET['newTmin'];
	$newTmax = $_GET['newTmax'];
	$newWd = $_GET['newWd'];

	$T_min = get_U('minTemp',$username);
	$T_max = get_U('maxTemp',$username);
	$WBdefault = get_U('WBdefault',$username);

	$response = array_fill_keys(array('error', 'message'), NULL);

	if(check_username($username)){
		if(strcmp($newTmin, $T_min)!= 0 || strcmp($newTmax, $T_max)!= 0 || strcmp($WBdefault, $newWd)!= 0){
			if (check_minT($newTmin)){
				if(check_maxT($newTmax)){
					if(valid_Ts($newTmin,$newTmax)){
						if(check_WB($newWd)){
							if(change_Tsw($username, $newTmin, $newTmax, $newWd)){
								$response['error'] = false;
								$response['message'] = 'Successful update';
							}
							else{
								$response['error'] = true;
								$response['message'] = 'Failed to update';
							}	
						}
						else{
							$response['error'] = true;
							$response['message'] = 'Invalid WB status';
						}
					}
					else{
						$response['error'] = true;
						$response['message'] = 'Tmin must be < Tmax';
					}
				}
				else{
					$response['error'] = true;
					$response['message'] = 'Tmax must be < 50';
				}
			}
			else{
				$response['error'] = true;
				$response['message'] = 'Tmin must be > 1';
			}
		}
		else{
			$response['error'] = true;
			$response['message'] = 'At least one of the vals must be new';
		}
	}
	else{
		$response['error'] = true;
		$response['message'] = 'User not in DB';
	}
   	echo(json_encode($response));

?>




