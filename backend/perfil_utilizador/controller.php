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

		case 'list': //listar os perfil utilizadores
			 
			 $response = $data->list();
			 $text='';
			 foreach ($response as $item) {
			 	$text.='<tr>';
				$text.='<td>'.$item['nome'].'</td>';
				$text.='<td>'.$item['descricao'].'</td>';
				$text.='<td>';

				if(hasRoles(['utilizadores_perfil_editar']))
					$text.='<button id="btn-edit" data-id="'.$item['id'].'" class="btn btn-sm btn-action btn-warning"><i class="fa fa-edit"></i></button>';

				if(hasRoles(['utilizadores_perfil_eliminar']))
					$text.='<button id="btn-delete" data-id="'.$item['id'].'" class="btn btn-sm btn-action btn-danger"><i class="fa fa-trash"></i></button>';

				if(hasRoles(['utilizadores_perfil_permissoes']))
					$text.='<button id="btn-permissao" data-id="'.$item['id'].'" class="btn btn-sm btn-action btn-primary"><i class="fa fa-unlock"></i></button>';
				$text.='</td>';
				$text.='</tr>';
			 }

			 echo $text;

			break;

		case 'delete': //apagar perfil utilizadores

			$id=filter_input(INPUT_POST, 'id');
			$estado=0;
			$delete_ut=date('d-m-y h:i:s');
			$response=$data->delete($id,$estado,$delete_ut);

			echo json_encode($response);

			break;
			
		case 'addForm': //apresentar formulario de utilizadores
?>

			<div class="retorno"></div>
			<form name='register'>
	            <div class="card-body">
	              <div class="form-group">
	                <label>Nome</label>
	                <input type="text" class="form-control" name="nome" placeholder="Inserir Nome" required>
	              </div>
	              <div class="form-group">
	                <label>Descrição</label>
	                <input type="text" class="form-control" name="descricao" placeholder="Inserir Descrição" required>
	              </div>
	            </div>
	            <div class="card-footer">
	              <button type="submit" class="btn btn-primary">Registar</button>
	            </div>
	        </form>
		
<?php	
			break;

		case 'register':

				$nome=filter_input(INPUT_POST, 'nome');
				$descricao=filter_input(INPUT_POST, 'descricao');
				$create_ut=date('d-m-y h:i:s');
				$response=$data->register($nome,$descricao,$create_ut);

				echo json_encode($response);
				
				break;

		case 'editForm':

			$id=filter_input(INPUT_POST, 'id');

			$response=$data->getItem($id);
			$response=$response[0];

?>
			<div class="retorno"></div>
			<form name='edit'>
	            <div class="card-body">
	              <div class="form-group">
	                <label>Nome</label>
	                <input type="text" class="form-control" value="<?php echo $response['nome']; ?>" name="nome" placeholder="Inserir Nome" required>
	              </div>
	              <div class="form-group">
	                <label>Descrição</label>
	                <input type="text" class="form-control" value="<?php echo $response['descricao']; ?>" name="descricao" placeholder="Inserir Descrição" required>
	              </div>
	            </div>
	            <input type="hidden" value="<?php echo $response['id']; ?>" name="id">
	            <!-- /.card-body -->

	            <div class="card-footer">
	              <button type="submit" class="btn btn-primary">Editar</button>
	            </div>
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
				$id=filter_input(INPUT_POST, 'id');
				$nome=filter_input(INPUT_POST, 'nome');
				$descricao=filter_input(INPUT_POST, 'descricao');

				$response=$data->edit($nome,$descricao,$id);

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