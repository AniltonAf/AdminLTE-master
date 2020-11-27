<?php

	$action= filter_input(INPUT_POST, 'action');

	require 'sql.php';
	require '../enviroment/function.php';
	$data = new Data();
	//defenir fuso horairio para definir hora com php
	date_default_timezone_set("Atlantic/Cape_Verde");

	session_start();
	
	//
	switch ($action) {

		case 'count_estado': //listar grupos
			 $response["gerador_status"]["on"] = $data->count_estado("gerador_status",true);
			 $response["gerador_status"]["off"] = $data->count_estado("gerador_status",false);
			 $response["gerador_avariado"]["on"] = $data->count_estado("avariado",true);
			 $response["gerador_avariado"]["off"] = $data->count_estado("avariado",false);
			 $response["rede_publica"]["on"] = $data->count_estado("rede_publica",true);
			 $response["rede_publica"]["off"] = $data->count_estado("rede_publica",false);
			echo json_encode($response);
			break;

		case 'get_geradores': //apagar grupo
			$geradores=$data->getGeradores();

			$dados=array();

			foreach($geradores as $line){
				if ($line["avariado"] == null) {
					$estado= '<div class="badge badge-sm badge-warning">Não configurado</div>';
				}
				elseif ($line["avariado"] == 1) {
					$estado= '<div class="badge badge-sm badge-danger">Avariado</div>';
				}elseif ($line["gerador_status"]) {
					$estado= '<div class="badge badge-sm badge-success">Funcional</div>';
				}else {
					$estado= '<div class="badge badge-sm badge-info">Desligado</div>';
				}
				$dados[]=[
					"type"=>"Feature",
					"properties"=>[
						"description"=>'
							<strong >'.$line["descricao"].'</strong>
							<table class="table table-sm table-striped" style="min-width: 200px;">
								<tr>
									<td>Fabricante</dh>
									<td>'.$line["fabricante"].'</td>
								</tr>
								<tr>
									<td>Modelo</td>
									<td>'.$line["modelo"].'</td>
								</tr>
								<tr>
									<td>Estado Gerador</td>
									<td>'.$estado.'</td>
								</tr>
								<tr>
									<td>Hora de Trabalho</td>
									<td>'.$line["hora_trabalho"].'min</td>
								</tr>
							</table>

						',
						"icon"=>"castle"
					],
					"geometry"=>[
						"type"=>"Point",
						"coordinates" => [$line["longitude"], $line["latitude"]]
					]
				];
			}

			$response=[
				"status"=>true,
				"data"=>$dados
			];

			echo json_encode($response);

			break;


		default:
			# code...
			break;
	}

?>