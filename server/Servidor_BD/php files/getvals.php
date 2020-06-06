<?php
	include 'utils.php';
	/*
	http://web.ist.utl.pt/~ist425319/getvals.php?username=hello
	*/	
	/* Receives request to  create new account*/
	$username = $_GET['username'];
	$response = array_fill_keys(array('Tmin', 'Tmax','WBdefault'), NULL);

	if(check_username($username)){	

		$T_min = get_U('minTemp',$username);
		$T_max = get_U('maxTemp',$username);

		$WBdefault = get_U('WBdefault',$username);

		$response['Tmin'] = $T_min;
		$response['Tmax'] = $T_max;
		$response['WBdefault'] = $WBdefault;
	}
	else{
		$response['Tmin'] = null;
		$response['Tmax'] = null;
		$response['WBdefault'] = null;

	}


   	echo(json_encode($response));

?>
