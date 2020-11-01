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
				$response=[
					"status"=> false,
					"message"=> "Nome utilizador ou palavra-passe errado",
				];
				
				$login=$data->login($username,$password);


				if($login){
					$response['status']=true;
					$response['message']="Logado com sucesso";
					session_start();
					$_SESSION['caixa_monitorizacao']['user'] = $login[0];
					$_SESSION['caixa_monitorizacao']['permissoes'] = $data->listPermition($_SESSION['caixa_monitorizacao']['user']['id_perfil_permission']);
					ob_end_flush();
				}

				echo json_encode($response);
						
				break;

		default:
			# code...
			break;
	}




?>