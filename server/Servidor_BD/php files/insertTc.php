<?php
	include 'utils.php';
	/*
	http://web.ist.utl.pt/~ist425319/insertTc.php?username=hello&temp=12&time_s=0
	*/	
	/* Save current temperature!*/
	$username = $_GET['username'];
	$temperature = $_GET['temp'];
	$time_s = $_GET['time_s'];
	$response = array_fill_keys(array('error', 'message'), NULL);


	/*Create/open file of that user*/
	/*$myfile = fopen($username .".txt", "a");*/

	/* If successful*/
	/*if($myfile){*/

		if(insert_temp($temperature, $username, $time_s)){
			$response['error'] = false;
			$response['message'] = 'Successful temperature update';
			/*fwrite($myfile, json_encode($temperature));
			fclose($myfile);*/
		}
		else{
			$response['error'] = true;
			$response['message'] = 'Failed to insert temperature';
			/*fclose($myfile);*/
		}
	/*}*/
   	echo(json_encode($response));
?>
