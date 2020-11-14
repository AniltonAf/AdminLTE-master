<?php

$action = filter_input(INPUT_POST, 'action');
require 'sql.php';
$data = new Data();
//defenir fuso horairio para definir hora com php
date_default_timezone_set("Atlantic/Cape_Verde");

//
switch ($action) {
		//apresentar formulario de utilizadore
	case 'form':

		$response = $data->list();
		$response = $response[0];

?>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Host/Servidor</label>
						<input type="text" value="<?php echo $response['host']; ?>" name="host" class="form-control" placeholder="Introduzir Host/Servidor" required>
					</div>
					<div class="form-group">
						<label>Nome de utilizador</label>
						<input type="text" value="<?php echo $response['username']; ?>" name="username" class="form-control" placeholder="Introduzir Nome de utilizador" required>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" value="<?php echo $response['smtp_auth']; ?>" <?php echo $response['smtp_auth']? 'checked':''; ?> name="smtp_auth"> Autenticação
						</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Porta Servidor</label>
						<input type="number" value="<?php echo $response['port']; ?>" name="port" class="form-control" placeholder="Introduzir Porta" required>
					</div>
					<div class="form-group">
						<label>Palavra-passe</label>
						<input type="password" value="<?php echo $response['password']; ?>" name="password" class="form-control" placeholder="Introduzir Palavra-passe" required>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" value="<?php echo $response['ativo']; ?>" <?php echo $response['ativo']? 'checked':''; ?> name="ativo"> Ativo
						</label>
					</div>
				</div>
				<div class="col-md-4">

					<div class="form-group">
						<label>Tipo de Segurançã</label>
						<select class="form-control" value="<?php echo $response['smtp_security']; ?>" name="smtp_security">
							<option value="ssl" <?php $select = $response['smtp_security'] == 'ssl' ? 'selected' : '';
												echo $select;  ?>>SSL</option>
							<option value="tls" <?php $select = $response['smtp_security'] == 'tls' ? 'selected' : '';
												echo $select;  ?>>TLS</option>
							<option value="" <?php $select = $response['smtp_security'] == '' ? 'selected' : '';
												echo $select;  ?>>Nenhuma</option>
						</select>
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
		$host = filter_input(INPUT_POST, 'host');
		$username = filter_input(INPUT_POST, 'username');
		$smtp_auth = filter_input(INPUT_POST, 'smtp_auth')?filter_input(INPUT_POST, 'smtp_auth'):0;
		$port = filter_input(INPUT_POST, 'port');
		$password = filter_input(INPUT_POST, 'password');
		$ativo = filter_input(INPUT_POST, 'ativo')?filter_input(INPUT_POST, 'ativo'):0;
		$smtp_security = filter_input(INPUT_POST, 'smtp_security');
		$response = $data->update($host, $username, $smtp_auth, $port, $password, $ativo, $smtp_security);

		

		echo json_encode($response);

		break;

	default:
		# code...
		break;
}

?>