<?php

$action = filter_input(INPUT_POST, 'action');
require 'sql.php';
require '../enviroment/function.php';

//requisitos para envio de sms
//require ('vendor/autoload.php');


$data = new Data();
//defenir fuso horairio para definir hora com php
date_default_timezone_set("Atlantic/Cape_Verde");

//
switch ($action) {
		//apresentar formulario 
	case 'form':

		$response = $data->list();
		$response = $response[0];

?>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Provedor do serviço</label>
						<input type="text" value="<?php echo $response['provedor']; ?>" name="host" class="form-control" placeholder="Introduzir Provedor" required>
					</div>
					<div class="form-group">
						<label>Conta SID</label>
						<input type="text" value="<?php echo $response['accountsid']; ?>" name="username" class="form-control" placeholder="Introduzir Conta SID" required>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" value="<?php echo $response['ativo']; ?>" <?php echo $response['ativo']? 'checked':''; ?> name="ativo"> Ativo
						</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Numero de Envio</label>
						<input type="text" value="<?php echo $response['numberfrom']; ?>" name="port" class="form-control" placeholder="Introduzir Numero" required>
					</div>
					<div class="form-group">
						<label>Autenticação Token</label>
						<input type="authtoken" value="<?php echo $response['authtoken']; ?>" name="password" class="form-control" placeholder="Introduzir Autenticação Token" required>
					</div>
				</div>
			</div>
		</div>
		<!-- /.card-body -->
		<div class="card-footer">
			<button type="submit" class="btn btn-primary">Gravar</button>
		</div>

	

	<?php
		break;


	case 'update':
		$accountsid = filter_input(INPUT_POST, 'accountsid');
		$authtoken = filter_input(INPUT_POST, 'authtoken');
		$ativo = filter_input(INPUT_POST, 'ativo')?filter_input(INPUT_POST, 'ativo'):0;
		$numberfrom = filter_input(INPUT_POST, 'numberfrom');
		$provedor = filter_input(INPUT_POST, 'provedor');

		$response = $data->update($accountsid, $authtoken, $ativo, $numberfrom, $provedor);

		
		echo json_encode($response);

		break;

		case 'formtest';
?>
			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
						<label>Numero Destino:</label>
						<input type="text" class="form-control" name="numberto" placeholder="Inserir numero de teste" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label>Mensagem</label>
						<input type="text" class="form-control" name="menssagem" placeholder="Inserir numero de teste" required>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
						<label></label><br>
						<button type="submit" class="btn btn-primary">Testar Conexão</button>
						</div>
					</div>
				</div>
			</div>
	  	  
<?php
		break;

		case 'envioemail':

			$response = $data->list();
			$response = $response[0];

			$numberto = filter_input(INPUT_POST, 'numberto');
			$menssagem = filter_input(INPUT_POST, 'menssagem');

			$accountsid = filter_input(INPUT_POST, 'accountsid');
			$authtoken = filter_input(INPUT_POST, 'authtoken');
			$ativo = filter_input(INPUT_POST, 'ativo')?filter_input(INPUT_POST, 'ativo'):0;
			$numberfrom = filter_input(INPUT_POST, 'numberfrom');
			$provedor = filter_input(INPUT_POST, 'provedor');
	
			$response = smssend($accountsid, $authtoken, $ativo, $numberfrom, $numberto, $menssagem);

			echo json_encode($response);
	
		break;
	



	default:
		# code...
		break;
}

?>