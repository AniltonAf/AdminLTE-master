<?php

	$action= filter_input(INPUT_POST, 'action');

	require 'sql.php';
	$data = new Data();

	switch ($action) {

		case 'list':	
			// Carregar o historico de Eventos ocorridos  nos geradores
			$response = $data->list();
			$text = '';
			foreach ($response as $item) {
				$responseGerador = $data->getGerador($item['gerador_id']);
				$responseGerador = $responseGerador[0];
				if ($item["gerador_status"] == 0) {
					$gerador_status = '<div>OFF</div>';
				} elseif ($item["gerador_status"] == 1) {
					$gerador_status = '<div>ON</div>';
				} else {
					$gerador_status = '<div>Sem Dados</div>';
				}

				if ($item["avariado"] == 0) {
					$avariado = '<div>OPERACIONAL</div>';
				} elseif ($item["avariado"] == 1) {
					$avariado = '<div>AVARIADO</div>';
				} else {
					$avariado = '<div>Sem Dados</div>';
				}
				
				if ($item["rede_publica"] == 0) {
					$rede_publica = '<div>OPERACIONAL</div>';
				} elseif ($item["rede_publica"] == 1) {
					$rede_publica = '<div>CORTE ENERGIA</div>';
				} else {
					$rede_publica = '<div>Sem Dados</div>';
				}

				if ($item["power_edificio"] == 0) {
					$power_edificio = '<div>COM ENERGIA</div>';
				} elseif ($item["power_edificio"] == 1) {
					$power_edificio = '<div>SEM ENERGIA</div>';
				} else {
					$power_edificio = '<div>Sem Dados</div>';
				}

				if ($item["qua_aut_trans"] == 0) {
					$qua_aut_trans = '<div>OPERACIONAL</div>';
				} elseif ($item["qua_aut_trans"] == 1) {
					$qua_aut_trans = '<div>AVARIADO</div>';
				} else {
					$qua_aut_trans = '<div>Sem Dados</div>';
				}

				if ($item["low_fuel"] == 0) {
					$low_fuel = '<div>NORMAL</div>';
				} elseif ($item["low_fuel"] == 1) {
					$low_fuel = '<div>BAIXO</div>';
				} else {
					$low_fuel = '<div>Sem Dados</div>';
				}

				$text .= '<tr>';
				$text .= '<td>' . $responseGerador['descricao'] . '</td>';
				$text .= '<td>' . $gerador_status . '</td>';
				$text .= '<td>' . $avariado . '</td>';
				$text .= '<td>' . $rede_publica . '</td>';
				$text .= '<td>' . $power_edificio . '</td>';
				$text .= '<td>' . $qua_aut_trans . '</td>';
				$text .= '<td>' . $low_fuel . '</td>';
				$text .= '<td>' . $item['create_ut'] . '</td>';
				$text .= '</tr>';
			}
			echo $text;
	
			break;

		default:
			# code...
			break;
	}

?>