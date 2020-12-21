<?php

	$action= filter_input(INPUT_POST, 'action');

	require 'sql.php';
	$data = new Data();
	//defenir fuso horairio para definir hora com php
	date_default_timezone_set("Atlantic/Cape_Verde");
	
	//
	switch ($action) {

		case 'list':
			 
			 $response = $data->list();

			 //var_dump($response);

			 echo json_encode($response);

			break;

		case 'delete'://apagar utilizadores

			$id=filter_input(INPUT_POST, 'id');
			$estado=0;
			$delete_ut=date('d-m-y h:i:s');
			$response=$data->delete($id,$estado,$delete_ut);

			echo json_encode($response);

			break;
		
		case 'desbloquear'://apagar utilizadores

			$id=filter_input(INPUT_POST, 'id');
			$estado=1;
			$delete_ut=date('d-m-y h:i:s');
			$response=$data->desbloquear($id,$estado,$delete_ut);

			echo json_encode($response);

			break;

			case 'bloquear'://apagar utilizadores

				$id=filter_input(INPUT_POST, 'id');
				$estado=0;
				$delete_ut=date('d-m-y h:i:s');
				$response=$data->desbloquear($id,$estado,$delete_ut);
	
				echo json_encode($response);
	
				break;
		
			
			//apresentar formulario de utilizadores
		case 'addForm':
			$perfil=$data->listPerfil();
			require '../config.php';
?>

			<div class="retorno"></div>
			<form name='register'>
				<div class="row">
					<div class="col-sm-6">
						<div class="form-group">
			                <center>
			                	<img id="foto_holder" style="max-height: 150px;border-radius: 50%" src="<?php echo 'data:image/png;base64,'.$defaul_photo; ?>">
			                	<input type="file" name="foto" id="foto">
			                </center>
			            </div>
						<div class="form-group">
			                <label>Usernamne</label>
			                <input type="text" class="form-control" name="username" placeholder="Inserir Username" required>
			            </div>
			            <div class="form-group">
			                <label>Password</label>
			                <input type="password" class="form-control" name="password" placeholder="Inserir password" required>
			            </div>
			            <div class="form-group">
			                <label>Confirmar Password</label>
			                <input type="password" class="form-control" name="confirmar_password" placeholder="Confirmar password" required>
			            </div>
			            <div class="form-group">
			                <label>Perfil Utilizador</label>
			                <select class="form-control" name="id_perfil_permission">
			                	<option>Selecione</option>
			                	<?php		                		
			                		
			                		foreach($perfil as $line){
			                			echo '<option value="'.$line["id"].'">'.$line["nome"].'</option>';
			                		}
			                	?>
			                </select>
						</div>

					</div>
					<div class="col-sm-6">
						<div class="form-group">
			                <label>Nome</label>
			                <input type="text" class="form-control" name="nome" placeholder="Inserir nome" required>
			            </div>
			            <div class="form-group">
			                <label>Numero Funcionario</label>
			                <input type="text" class="form-control" name="numero_funcionario" placeholder="Inserir numero funcionario" required>
			            </div>
			            <div class="form-group">
			                <label>Departamento</label>
			                <input type="text" class="form-control" name="departamento" placeholder="Inserir departamento" required>
			            </div>
			            <div class="form-group">
			                <label>Função</label>
			                <input type="text" class="form-control" name="funcao" placeholder="Inserir função" required>
			            <div class="form-group">
							<label>E-mail</label>
							<label><input type="checkbox" name="alerta_email"> Ativar envio de E-MAIL </label>
			                <input type="email" class="form-control" name="email" placeholder="Inserir e-mail" required>
			            </div>
			            <div class="form-group">
							<label>Telefone</label>
							<label><input type="checkbox" name="alerta_sms"> Ativar envio de SMS </label>
			                <input type="text" class="form-control" name="telefone" placeholder="Inserir telefone" required>
						</div>

					</div>
				</div>
	              	            
	             <button type="submit" class="btn btn-primary">Registar</button>
	            
	        </form>
		
<?php	
			break;

		case 'register':
				$estado=1;
				$nome=filter_input(INPUT_POST, 'nome');
				$numero_funcionario=filter_input(INPUT_POST, 'numero_funcionario');
				$departamento=filter_input(INPUT_POST, 'departamento');
				$funcao=filter_input(INPUT_POST, 'funcao');
				$email=filter_input(INPUT_POST, 'email');
				$telefone=filter_input(INPUT_POST, 'telefone');
				$id_perfil_permission=filter_input(INPUT_POST, 'id_perfil_permission');
				$confirmar_password=filter_input(INPUT_POST, 'confirmar_password');
				$password=filter_input(INPUT_POST, 'password');
				$password=hash('sha256', $password);
				$username=filter_input(INPUT_POST, 'username');
				$alerta_sms=filter_input(INPUT_POST, 'alerta_sms')?1:0;
				$alerta_email=filter_input(INPUT_POST, 'alerta_email')?1:0;
				//$foto_file=filter_input(INPUT_POST, 'foto_file');


				if(isset($_FILES['foto_file']) && $_FILES['foto_file']['tmp_name']!=''){
					$foto=base64_encode(file_get_contents($_FILES['foto_file']['tmp_name']));
				}else{
					require '../config.php';
					$foto=$defaul_photo;
				}

				$create_ut=date('d-m-y h:i:s');
				$response=$data->register($nome,$numero_funcionario,$departamento,$funcao,$email,$telefone,$id_perfil_permission,$password,$username,$foto,$estado,$alerta_sms,$alerta_email,$create_ut);

				echo json_encode($response);
				
				break;

		case 'editForm':

			$id=filter_input(INPUT_POST, 'id');

			$response=$data->getItem($id);
			$response=$response[0];

			$perfil=$data->listPerfil();
			require '../config.php';

?>
			<div class="retorno"></div>
			<form name='edit'>
	            
	            <input type="hidden" value="<?php echo $response['id']; ?>" name="id">
	            <!-- /.card-body -->

	            <div class="row">
					<div class="col-sm-6">
						<div class="form-group">
			                <center>
			                	<img id="foto_holder" style="max-height: 150px;border-radius: 50%" src="<?php echo 'data:image/png;base64,'.$response['foto']; ?>">
			                	<input type="file" name="foto" id="foto">
			                </center>
			            </div>
			            <div class="form-group">
			                <label>Perfil Utilizador</label>
			                <select class="form-control" name="id_perfil_permission">
			                	<option>Selecione</option>
			                	<?php		                		
			                		
			                		foreach($perfil as $line){
			                			$select= ($line['id']==$response['id_perfil_permission'])?'selected':'';

			                			echo '<option value="'.$line["id"].'" '.$select.'>'.$line["nome"].'</option>';
			                		}
			                	?>
			                </select>
			            </div>
						<div class="checkbox">
							<label>
								<input type="checkbox" <?php echo $response['alerta_email']? 'checked':''; ?> name="alerta_email"> E-MAIL
							</label>
							<label>
								<input type="checkbox" <?php echo $response['alerta_sms']? 'checked':''; ?> name="alerta_sms"> SMS
							</label>
						</div>
					</div>
					<div class="col-sm-6">
						<div class="form-group">
			                <label>Nome</label>
			                <input type="text" class="form-control" value="<?php echo $response['nome']; ?>" name="nome" placeholder="Inserir nome" required>
			            </div>
			            <div class="form-group">
			                <label>Numero Funcionario</label>
			                <input type="text" class="form-control" value="<?php echo $response['numero_funcionario']; ?>" name="numero_funcionario" placeholder="Inserir numero funcionario" required>
			            </div>
			            <div class="form-group">
			                <label>Departamento</label>
			                <input type="text" class="form-control" value="<?php echo $response['departamento']; ?>" name="departamento" placeholder="Inserir departamento" required>
			            </div>
			            <div class="form-group">
			                <label>Função</label>
			                <input type="text" class="form-control" value="<?php echo $response['funcao']; ?>" name="funcao" placeholder="Inserir função" required>
			            <div class="form-group">
			                <label>E-mail</label>
			                <input type="text" class="form-control" value="<?php echo $response['email']; ?>" name="email" placeholder="Inserir e-mail" required>
			            </div>
			            <div class="form-group">
			                <label>Telefone</label>
			                <input type="text" class="form-control" value="<?php echo $response['telefone']; ?>" name="telefone" placeholder="Inserir telefone" required>
						</div>

					</div>
				</div>
	            <button type="submit" class="btn btn-primary">Editar</button>
	            
	        </form>
		
<?php	
			break;


		case 'permitionForm':

			$id_perfil=filter_input(INPUT_POST, 'id');

			$response=$data->listPermition($id_perfil);

			echo '<form name="permition" id-perfil="'.$id_perfil.'">';
			echo '<div class="retorno"></div>';
				foreach ($response as $line) {

					$isCheck=$line['permissao']? 'checked':'';

					echo '
						<div class="form-check">
						  <input name="'.$line['id'].'" class="form-check-input" '. $isCheck .'  type="checkbox">
						  <label class="form-check-label" for="defaultCheck1">
						    '.$line['descrisao'].'
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
				$create_ut=date('d-m-y h:i:s');
				$id=filter_input(INPUT_POST, 'id');
				$nome=filter_input(INPUT_POST, 'nome');
				$numero_funcionario=filter_input(INPUT_POST, 'numero_funcionario');
				$departamento=filter_input(INPUT_POST, 'departamento');
				$funcao=filter_input(INPUT_POST, 'funcao');
				$email=filter_input(INPUT_POST, 'email');
				$telefone=filter_input(INPUT_POST, 'telefone');
				$id_perfil_permission=filter_input(INPUT_POST, 'id_perfil_permission');
				$alerta_sms=filter_input(INPUT_POST, 'alerta_sms')?1:0;
				$alerta_email=filter_input(INPUT_POST, 'alerta_email')?1:0;
				//$foto_file=filter_input(INPUT_POST, 'foto_file');
				$foto=false;

				if(isset($_FILES['foto_file']) && $_FILES['foto_file']['tmp_name']!=''){
					$foto=base64_encode(file_get_contents($_FILES['foto_file']['tmp_name']));
				}

				$response=$data->edit($nome,$numero_funcionario,$departamento,$funcao,$email,$telefone,$id_perfil_permission,$foto,$alerta_sms,$alerta_email,$create_ut);;

				echo json_encode($response);

				break;	

		case 'permissao':
				$res=json_decode(filter_input(INPUT_POST,'data'),true);
				$id_perfil=$res['perfil'];
				$permissoes=$res['permissao'];

				$response=$data->deletePermissao($id_perfil);

				$result=[
					'status'=>false
				];

				if($response){

					$result['status']=$response;

					foreach ($permissoes as $permissao) {
						$id_per=$permissao['name'];
						$response=$data->addPermissao($id_perfil,$id_per);
						$result['status']=$response;
					}
				}
				
				echo json_encode($result);
				break;	

		default:
			# code...
			break;
	}

?>