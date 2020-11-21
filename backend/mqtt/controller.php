<?php

$action = filter_input(INPUT_POST, 'action');
require 'sql.php';
//require '../enviroment/function.php';


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
						<label>Servidor</label>
						<input type="text" value="<?php echo $response['server_mqtt']; ?>" name="server_mqtt" class="form-control" placeholder="Introduzir endereço Servidor" required>
					</div>
					<div class="form-group">
						<label>Nome de utilizador</label>
						<input type="text" value="<?php echo $response['username']; ?>" name="username" class="form-control" placeholder="Introduzir Nome de utilizador" required>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" value="<?php echo $response['ativo_ws']; ?>" <?php echo $response['ativo_ws']? 'checked':''; ?> name="ativo_ws"> WS Ativo
						</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Porta WS</label>
						<input type="number" value="<?php echo $response['port_ws']; ?>" name="port_ws" class="form-control" placeholder="Introduzir Porta WS" required>
					</div>
					<div class="form-group">
						<label>Palavra-passe</label>
						<input type="password" value="<?php echo $response['password']; ?>" name="password" class="form-control" placeholder="Introduzir Palavra-passe" required>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" value="<?php echo $response['ativo_mqtt']; ?>" <?php echo $response['ativo_mqtt']? 'checked':''; ?> name="ativo_mqtt"> MQTT Ativo
						</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
							<label>Porta MQTT</label>
							<input type="number" value="<?php echo $response['port_mqtt']; ?>" name="port_mqtt" class="form-control" placeholder="Introduzir Porta MQTT" required>
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
		$server_mqtt = filter_input(INPUT_POST, 'server_mqtt');
		$username = filter_input(INPUT_POST, 'username');
		$port_mqtt = filter_input(INPUT_POST, 'port_mqtt')?filter_input(INPUT_POST, 'port_mqtt'):0;
		$port_ws = filter_input(INPUT_POST, 'port_ws');
		$password = filter_input(INPUT_POST, 'password');
		$ativo_ws = filter_input(INPUT_POST, 'ativo_ws')?filter_input(INPUT_POST, 'ativo_ws'):0;
		$port_mqtt = filter_input(INPUT_POST, 'port_mqtt');
		$response = $data->update($server_mqtt, $username, $port_mqtt, $port_ws, $password, $ativo_ws, $port_mqtt);

		
		echo json_encode($response);

		break;

		case 'formtest';
?>
			<div class="card-body">
				<div class="row">
					<div class="col-md-4">
						<div class="form-group">
						<label>Email Para:</label>
						<input type="email" class="form-control" name="emailpara" placeholder="Inserir e-mail teste" required>
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

			$emailde = filter_input(INPUT_POST, 'emailde');
			$emailpara = filter_input(INPUT_POST, 'emailpara');

			$host = $response['host'];;
			$username = $response['username'];
			$smtp_auth = $response['smtp_auth'];;
			$port = $response['port'];;
			$password = $response['password'];;
			$ativo = $response['ativo'];;
			$smtp_security = $response['smtp_security'];;
			
			//$response = testemail($host,$username,$smtp_auth,$port,$password,$ativo,$smtp_security,$emailde,$emailpara);

			echo json_encode($response);
	
		break;
	



	default:
		# code...
		break;
}

?>