<?php

$action = filter_input(INPUT_POST, 'action');

require 'sql.php';
require '../enviroment/function.php';
$data = new Data();
//defenir fuso horairio para definir hora com php
date_default_timezone_set("Atlantic/Cape_Verde");
session_start();

switch ($action) {

	case 'list': //listar geradores


		$response = $data->list();
		$text = '';
		foreach ($response as $item) {
			$responseconfig = $data->getConfig($item['id']);
			$responseconfig = $responseconfig[0];
			if ($responseconfig["avariado"] == null) {
				$estado = '<div class="badge badge-sm badge-warning">Não configurado</div>';
			} elseif ($responseconfig["avariado"] == 1) {
				$estado = '<div class="badge badge-sm badge-danger">Avariado</div>';
			} elseif ($responseconfig["gerador_status"]) {
				$estado = '<div class="badge badge-sm badge-success">Funcional</div>';
			} else {
				$estado = '<div class="badge badge-sm badge-info">Desligado</div>';
			}

			$text .= '<tr>';
			//$text.='<td><img style="max-height:30px;boder-radius:50%" src="data:image/png;base64,'.$item['foto'].'"></td>';
			$text .= '<td>' . $item['modelo'] . '</td>';
			$text .= '<td>' . $item['fabricante'] . '</td>';
			$text .= '<td>' . $item['descricao'] . '</td>';
			$text .= '<td>' . $item['nome'] . '</td>';
			$text .= '<td>' . $estado . '</td>';
			$text .= '<td>';
			if (hasRoles(['equipamentos_gerador_detalhes'])) //Verificação de permissão de acesso ao botão
				$text .= '<button id="btn-detail" data-id="' . $item['id'] . '" class="btn btn-sm btn-action btn-info"><i class="fa fa-eye"></i></button>';
			if (hasRoles(['equipamentos_gerador_editar']))
				$text .= '<button id="btn-edit" data-id="' . $item['id'] . '" class="btn btn-sm btn-action btn-warning"><i class="fa fa-edit"></i></button>';
			if (hasRoles(['equipamentos_gerador_eliminar']))
				$text .= '<button id="btn-delete" data-id="' . $item['id'] . '" class="btn btn-sm btn-action btn-danger"><i class="fa fa-trash"></i></button>';
			if (hasRoles(['equipamentos_gerador_config']))
				$text .= '<button id="btn-config" data-id="' . $item['id'] . '" class="btn btn-sm btn-action btn-info"><i class="fa fa-wrench"></i></button>';
			$text .= '</td>';
			$text .= '</tr>';
		}
		echo $text;

		break;

	case 'delete': //apagar perfil utilizadores

		$id = filter_input(INPUT_POST, 'id');
		$estado = 0;
		$delete_ut = date('d-m-y h:i:s');
		$response = $data->delete($id, $estado, $delete_ut);

		echo json_encode($response);

		break;

	case 'addForm': //apresentar formulario registo de gerador
		$grupo = $data->listGrup();
		//require '../config.php';
?>

		<div class="retorno"></div>
		<form name='register'>
			<div class="row">
				<div class="col-sm-3">
					<div class="form-group">
						<label>Modelo <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="modelo" placeholder="Inserir Modelo" required>
					</div>
					<div class="form-group">
						<label>Fabricante <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="fabricante" placeholder="Inserir Fabricante" required>
					</div>
					<div class="form-group">
						<label>Descrição <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="descricao" placeholder="Inserir Descrição" required>
					</div>
					<div class="form-group">
						<label>Unidade Organica <span class="text-danger">*</span></label>
						<select class="form-control" name="id_grupo">
							<option>Selecione</option>
							<?php

							foreach ($grupo as $line) {
								echo '<option value="' . $line["id"] . '">' . $line["nome"] . '</option>';
							}
							?>
						</select>
					</div>

				</div>
				<div class="col-sm-3">
					<div class="form-group">
						<label>Potência(KW) <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="potencia" placeholder="Inserir Potencia(KW)" required>
					</div>
					<div class="form-group">
						<label>Horas de trabalho <span class="text-danger">*</span></label>
						<input type="text" class="form-control" name="hora_trabalho" placeholder="Inserir Horas de trabalho" required>
					</div>
					<div class="form-group">
						<label>Data ultima manutenção <span class="text-danger">*</span></label>
						<input type="date" class="form-control" name="data_manutencao" placeholder="Inserir Data Ultima Manutenção" required>
					</div>
					<div class="form-group">
						<label>Latitude <span class="text-danger">*</span></label>
						<input type="number" step="any" class="form-control" name="latitude" placeholder="Inserir Latitude" required>
					</div>
					<div class="form-group">
						<label>Longitude <span class="text-danger">*</span></label>
						<input type="number" step="any" class="form-control" name="longitude" placeholder="Longitude" required>
					</div>
				</div>
				<div class="col-sm-6">
				  <div id="map" style="width: 100%; min-height:300px"></div>
				</div>
			</div>
			<button type="submit" class="btn btn-primary">Registar</button>
		</form>

	<?php
		break;

	case 'register':

		$modelo = filter_input(INPUT_POST, 'modelo');
		$fabricante = filter_input(INPUT_POST, 'fabricante');
		$descricao = filter_input(INPUT_POST, 'descricao');
		$potencia = filter_input(INPUT_POST, 'potencia');
		$hora_trabalho = filter_input(INPUT_POST, 'hora_trabalho');
		$data_manutencao = filter_input(INPUT_POST, 'data_manutencao');
		$id_grupo = filter_input(INPUT_POST, 'id_grupo');
		$latitude = filter_input(INPUT_POST, 'latitude');
		$longitude = filter_input(INPUT_POST, 'longitude');
		$create_ut = date('d-m-y h:i:s');
		$estado = 1;
		$response = $data->register($modelo, $fabricante, $descricao, $potencia, $hora_trabalho, $data_manutencao, $id_grupo, $latitude,$longitude,  $estado, $create_ut);

		echo json_encode($response);
		
		break;


	case 'detailForm':

		$id = filter_input(INPUT_POST, 'id');

		$response = $data->getItem($id);
		$response = $response[0];

		$grupo = $data->listGrup();
		//require '../config.php';
	?>

		<div class="retorno"></div>
		<form name='edit'>
			<div class="row">
				<div class="col-sm-6">

					<div class="form-group">
						<label>Modelo</label>
						<input disabled type="text" class="form-control" value="<?php echo $response['modelo']; ?>" name="modelo" placeholder="Inserir Modelo" required>
					</div>
					<div class="form-group">
						<label>Fabricante</label>
						<input disabled type="text" class="form-control" value="<?php echo $response['fabricante']; ?>" name="fabricante" placeholder="Inserir Fabricante" required>
					</div>
					<div class="form-group">
						<label>Descrição</label>
						<input disabled type="text" class="form-control" value="<?php echo $response['descricao']; ?>" name="descricao" placeholder="Inserir Descrição" required>
					</div>
					<div class="form-group">
						<label>Unidade Organica</label>
						<select disabled class="form-control" value="<?php echo $response['id_grupo']; ?>" name="id_grupo">
							<option>Selecione</option>
							<?php

							foreach ($grupo as $line) {
								$select = ($line['id'] == $response['id_grupo']) ? 'selected' : '';

								echo '<option value="' . $line["id"] . '" ' . $select . '>' . $line["nome"] . '</option>';
							}
							?>
						</select>
					</div>

				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Potência(KW)</label>
						<input disabled type="text" class="form-control" value="<?php echo $response['potencia']; ?>" name="potencia" placeholder="Inserir Potencia(KW)" not required>
						<div class="form-group">
							<label>Horas de trabalho</label>
							<input disabled type="text" class="form-control" value="<?php echo $response['hora_trabalho']; ?>" name="hora_trabalho" placeholder="Inserir Horas de trabalho" required>
						</div>
						<div class="form-group">
							<label>Endereço IP</label>
							<input disabled type="text" class="form-control" value="<?php echo $response['ip']; ?>" name="ip" placeholder="Inserir Endereço IP" required>
							<div class="form-group">
								<label>Data ultima manutenção</label>
								<input disabled type="date" class="form-control" value="<?php echo $response['data_manutencao']; ?>" name="data_manutencao" placeholder="Inserir Data Ultima Manutenção" required>
							</div>
						</div>
					</div>

					<input type="hidden" name="id" value="<?php echo $response['id']; ?>">

		</form>

	<?php
		break;


	case 'editForm':

		$id = filter_input(INPUT_POST, 'id');

		$response = $data->getItem($id);
		$response = $response[0];

		$grupo = $data->listGrup();
		//require '../config.php';
	?>

		<div class="retorno"></div>
		<form name='edit'>
			<div class="row">
				<div class="col-sm-6">

					<div class="form-group">
						<label>Modelo</label>
						<input type="text" class="form-control" value="<?php echo $response['modelo']; ?>" name="modelo" placeholder="Inserir Modelo" required>
					</div>
					<div class="form-group">
						<label>Fabricante</label>
						<input type="text" class="form-control" value="<?php echo $response['fabricante']; ?>" name="fabricante" placeholder="Inserir Fabricante" required>
					</div>
					<div class="form-group">
						<label>Descrição</label>
						<input type="text" class="form-control" value="<?php echo $response['descricao']; ?>" name="descricao" placeholder="Inserir Descrição" required>
					</div>
					<div class="form-group">
						<label>Unidade Organica</label>
						<select class="form-control" value="<?php echo $response['id_grupo']; ?>" name="id_grupo">
							<option>Selecione</option>
							<?php

							foreach ($grupo as $line) {
								$select = ($line['id'] == $response['id_grupo']) ? 'selected' : '';

								echo '<option value="' . $line["id"] . '" ' . $select . '>' . $line["nome"] . '</option>';
							}
							?>
						</select>
					</div>

				</div>
				<div class="col-sm-6">
					<div class="form-group">
						<label>Potência(KW)</label>
						<input type="text" class="form-control" value="<?php echo $response['potencia']; ?>" name="potencia" placeholder="Inserir Potencia(KW)">
					</div>
					<div class="form-group">
						<label>Horas de trabalho <span class="text-danger">*</span></label>
						<input type="text" class="form-control" value="<?php echo $response['hora_trabalho']; ?>" name="hora_trabalho" placeholder="Inserir Horas de trabalho" required>
					</div>
					<div class="form-group">
						<label>Endereço IP</label>
						<input type="text" class="form-control" value="<?php echo $response['ip']; ?>" name="ip" placeholder="Inserir Endereço IP" required>
						<div class="form-group">
							<label>Data ultima manutenção</label>
							<input type="date" class="form-control" value="<?php echo $response['data_manutencao']; ?>" name="data_manutencao" placeholder="Inserir Data Ultima Manutenção" required>
						</div>
					</div>

					<input type="hidden" name="id" value="<?php echo $response['id']; ?>">

					<button type="submit" class="btn btn-primary">Registar</button>

		</form>

	<?php
		break;

	case 'configPage':

		$id = filter_input(INPUT_POST, 'id');

		$response = $data->getConfig($id);
		$response = $response[0];
		//require '../config.php';
	?>

		<div class="retorno"></div>
		<table class="table table-striped table-responsive">
			<tr>
				<th>
					Estado Gerador
				</th>
				<td>
					<?php

					if ($response["avariado"] == null) {
						echo '<div class="badge badge-sm badge-warning">Não configurado</div>';
					} elseif ($response["avariado"] == 1) {
						echo '<div class="badge badge-sm badge-danger">Avariado</div>';
					} elseif ($response["gerador_status"]) {
						echo '<div class="badge badge-sm badge-success">Funcional</div>';
					} else {
						echo '<div class="badge badge-sm badge-info">Desligado</div>';
					}
					?>
				</td>
			</tr>
			<tr>
				<th>
					Nivel Combustivel
				</th>
				<td>
					<?php

					if ($response["low_fuel"] == null) {
						echo '<div class="badge badge-sm badge-warning">Não configurado</div>';
					} elseif ($response["low_fuel"]) {
						echo '<div class="badge badge-sm badge-danger">Baixo nivel Combustivel</div>';
					} else {
						echo '<div class="badge badge-sm badge-success">Nivel Combustivel OK</div>';
					}
					?>
				</td>
			</tr>
			<tr>
				<th>
					Rede Publica
				</th>
				<td>
					<?php

					if ($response["rede_publica"] == null) {
						echo '<div class="badge badge-sm badge-warning">Não configurado</div>';
					} elseif ($response["rede_publica"]) {
						echo '<div class="badge badge-sm badge-success">Funcional</div>';
					} else {
						echo '<div class="badge badge-sm badge-danger">Avariado</div>';
					}
					?>

				</td>
			</tr>
			<tr>
				<th>
					Endereço IP
				</th>
				<td>
					<?php echo $response['ip']; ?>
				</td>
			</tr>
			<tr>
				<th>
					Auth
				</th>
				<td style="max-width:fit-content">
					<?php echo base64_encode($response['gerador_id'] . ':' . $response['key_auth']); ?>
				</td>
			</tr>
		</table>

	<?php
		break;


	case 'permitionForm':

		$id_perfil = filter_input(INPUT_POST, 'id');

		$response = $data->listPermition($id_perfil);

		echo '<form name="permition" id-perfil="' . $id_perfil . '">';
		echo '<div class="retorno"></div>';
		foreach ($response as $line) {

			$isCheck = $line['permissao'] ? 'checked' : '';

			echo '
						<div class="form-check">
						  <input name="' . $line['id'] . '" class="form-check-input" ' . $isCheck . '  type="checkbox">
						  <label class="form-check-label" for="defaultCheck1">
						    ' . $line['descrisao'] . '
						  </label>
						</div>
					';
		}
		echo '<br><button type="submit" class="btn btn-sm btn-primary"><i class="fa fa-upload"></i> Atualizar</button></div>';

		echo '</form>';

	?>



<?php
		break;

	case 'edit':

		$modelo = filter_input(INPUT_POST, 'modelo');
		$fabricante = filter_input(INPUT_POST, 'fabricante');
		$descricao = filter_input(INPUT_POST, 'descricao');
		$potencia = filter_input(INPUT_POST, 'potencia');
		$hora_trabalho = filter_input(INPUT_POST, 'hora_trabalho');
		$ip = filter_input(INPUT_POST, 'ip');
		$data_manutencao = filter_input(INPUT_POST, 'data_manutencao');
		$id_grupo = filter_input(INPUT_POST, 'id_grupo');
		$id = filter_input(INPUT_POST, 'id');

		$response = $data->edit($modelo, $fabricante, $descricao, $potencia, $hora_trabalho, $ip, $data_manutencao, $id_grupo, $id);

		echo json_encode($response);

		break;

	case 'permissao':
		$res = json_decode(filter_input(INPUT_POST, 'data'), true);
		$id_perfil = $res['perfil'];
		$permissoes = $res['permissao'];

		$response = $data->deletePermissao($id_perfil);

		$result = [
			'status' => false
		];

		if ($response) {

			$result['status'] = $response;

			foreach ($permissoes as $permissao) {
				$id_per = $permissao['name'];
				$response = $data->addPermissao($id_perfil, $id_per);
				$result['status'] = $response;
			}
		}

		echo json_encode($result);
		break;

	default:
		# code...
		break;
}

?>