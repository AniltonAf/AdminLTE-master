<?php

$action = filter_input(INPUT_POST, 'action');
require 'sql.php';
require '../enviroment/function.php';

//requisitos para envio de sms
//require ('vendor/autoload.php');


$data = new SMS();
//defenir fuso horairio para definir hora com php
date_default_timezone_set("Atlantic/Cape_Verde");

//
switch ($action) {
		//apresentar formulario 
	case 'form':

		$response = $data->list();

		if(!$response){
			$response=[
				"provedor"=>"",
				"accountsid"=>"",
				"numberfrom"=>"",
				"authtoken"=>"",
				"ativo"=>false,
				];
		}else{
			$response = $response[0];
		}

?>
		<div class="card-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Provedor do serviço</label>
						<input type="text" value="<?php echo $response['provedor']; ?>" name="provedor" class="form-control" placeholder="Introduzir Provedor" required>
					</div>
					<div class="form-group">
						<label>Conta SID</label>
						<input type="text" value="<?php echo $response['accountsid']; ?>" name="accountsid" class="form-control" placeholder="Introduzir Conta SID" required>
					</div>
					<div class="checkbox">
						<label>
							<input type="checkbox" <?php echo $response['ativo']? 'checked':''; ?> name="ativo"> Ativo
						</label>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label>Numero de Envio</label>
						<input type="text" value="<?php echo $response['numberfrom']; ?>" name="numberfrom" class="form-control" placeholder="Introduzir Numero" required>
					</div>
					<div class="form-group">
						<label>Autenticação Token</label>
						<input type="authtoken" value="<?php echo $response['authtoken']; ?>" name="authtoken" class="form-control" placeholder="Introduzir Autenticação Token" required>
					</div>
				</div>
			</div>
		</div>
		<!-- /.card-body -->
		<div class="card-footer">
			<button type="submit" id="btnTest" class="btn btn-primary">Testar Envio SMS</button>
			<button type="submit" id="btnGravar" class="btn btn-primary">Gravar</button>
		</div>

	

	<?php
		break;


	case 'update':
		$accountsid = filter_input(INPUT_POST, 'accountsid');
		$authtoken = filter_input(INPUT_POST, 'authtoken');
		$ativo = filter_input(INPUT_POST, 'ativo')?1:0;
		$numberfrom = filter_input(INPUT_POST, 'numberfrom');
		$provedor = filter_input(INPUT_POST, 'provedor');

		$response = $data->update($accountsid, $authtoken, $ativo, $numberfrom, $provedor);

		
		echo json_encode($response);

		break;

	case 'formTeste':
?>
	<form name="teste">
		<div class="retornoSms"></div>
		<div class="form-group">
		<label>Número telefone</label>
		<input type="text" class="form-control" name="telefone" required>
		</div>
		<div class="form-group">
		<label>Mensagem</label>
		<textarea name="mensagem" rows="5" class="form-control" required></textarea>
		</div>
		<button class="btn btn-sm btn-primary" type="submit">Testar</button>
	</form>
<?php
	break;
	



	default:
		# code...
		break;
}

?>