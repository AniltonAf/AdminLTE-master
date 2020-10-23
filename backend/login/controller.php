<?php

	$action= filter_input(INPUT_POST, 'action');

	require 'sql.php';
	$data = new Data();
	//defenir fuso horairio para definir hora com php
	date_default_timezone_set("Atlantic/Cape_Verde");
	
	//
	switch ($action) {

		case 'login':
				$username=filter_input(INPUT_POST, 'username');
				$password=filter_input(INPUT_POST, 'password');
				$remember=filter_input(INPUT_POST, 'remember');


				$response=$data->login($username,$password);

				echo json_encode($response);
				
				break;

		default:
			# code...
			break;
	}

?>