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

		case 'list': //listar grupos
		 	$response = $data->list();
			$text='';
			 foreach ($response as $item) {
				$text.='<tr>';
				$text.='<td>'.$item['nome'].'</td>';
				$text.='<td>'.$item['local'].'</td>';
				$text.='<td>'.$item['descricao'].'</td>';
				$text.='<td>';
				if(hasRoles(['grupo_editar']))
					$text.='<button id="btn-edit" data-id="'.$item['id'].'" class="btn btn-sm btn-action btn-warning"><i class="fa fa-edit"></i></button>';
				if(hasRoles(['grupo_eliminar']))
					$text.='<button id="btn-delete" data-id="'.$item['id'].'" class="btn btn-sm btn-action btn-danger"><i class="fa fa-trash"></i></button>';
				if(hasRoles(['grupo_ver_utilizador']))
					$text.='<button id="btn-addutilizador" data-id="'.$item['id'].'" class="btn btn-sm btn-action btn-primary"><i class="fa fa-users"></i></button>';
				$text.='</td>';
				$text.='</tr>';

			}
			echo $text;


/*  
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


 */











			break;

		case 'delete': //apagar grupo

			$id=filter_input(INPUT_POST, 'id');
			$estado=0;
			$delete_ut=date('d-m-y h:i:s');
			$response=$data->delete($id,$estado,$delete_ut);

			echo json_encode($response);

			break;
			
		case 'addForm': //apresentar formulario de grupo
?>
			<div class="retorno"></div>
			<form name='register'>
	            <div class="card-body">
	              <div class="form-group">
	                <label>Nome</label>
	                <input type="text" class="form-control" name="nome" placeholder="Inserir Nome" required>
	              </div>
	              <div class="form-group">
	                <label>Local</label>
	                <input type="text" class="form-control" name="local" placeholder="Inserir Local" required>
	              </div>
	              <div class="form-group">
	                <label>Descrição</label>
	                <input type="text" class="form-control" name="descricao" placeholder="Inserir Descrição" not required>
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
				$local=filter_input(INPUT_POST, 'local');
				$descricao=filter_input(INPUT_POST, 'descricao');
				$create_ut=date('d-m-y h:i:s');
				$estado=1;
				$response=$data->register($nome,$local,$descricao,$create_ut,$estado);

				echo json_encode($response);
				
				break;

		case 'editForm':

			$id=filter_input(INPUT_POST, 'id');

			$response=$data->getItem($id);
			$response=$response[0];

			$perfil=$data->listGrupo();

?>
			<div class="retorno"></div>
			<form name='edit'>
	            <div class="card-body">
	              <div class="form-group">
	                <label>Nome</label>
	                <input type="text" class="form-control" value="<?php echo $response['nome']?>" name="nome" placeholder="Inserir Nome" required>
	              </div>
	              <div class="form-group">
	                <label>Local</label>
	                <input type="text" class="form-control" value="<?php echo $response['local']?>" name="local" placeholder="Inserir Local" required>
	              </div>
	              <div class="form-group">
	                <label>Descrição</label>
	                <input type="text" class="form-control" value="<?php echo $response['descricao']?>" name="descricao" placeholder="Inserir Descrição" not required>
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

		case 'userForm':	
			$id_grupo=filter_input(INPUT_POST, 'id_grupo');
?>
			<div class="row">
            <div class="col-12">            
              <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
              <?php if(hasRoles(['grupo_ver_utilizador_adicionar'])) ?>
                <button class="btn btn-sm btn-primary" data-id="<?php echo $id_grupo; ?>" id="btnAdd" style="float: left; margin-right: 40px">Adicionar</button>
                <table id="tableUser" class="table table-bordered ">
                  <thead>
                    <tr>
                      <th>Foto</th>
                      <th>Nome</th>
                      <th>Departamento</th>
                      <th>Remover</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
			
		
<?php	
			break;

		case 'addUserForm': //apresentar formulario de grupo

		$id_grupo=filter_input(INPUT_POST, 'id_grupo');
		$response=$data->listUserDesponivel($id_grupo);
?>

			<div class="retorno"></div>
			<form name='registerUser'>
	            <div class="form-group">
	                <label>Nome utilizador</label>
	                <select class="form-control" name="id_utilizador" required>
	                	<option>Selecione</option>
	                	<?php 
	                		foreach ($response as $line) {
	                			echo '<option value="'.$line['id'].'">'.$line['nome'].'</option>';
	                		}
	                	?>
	                </select>
	            </div>

	            <input type="hidden" name="id_grupo" value="<?php echo $id_grupo; ?>">
	            
	            <button type="submit" class="btn btn-primary">Registar</button>
	            
	        </form>
		
<?php	
			break;


		case 'listUser':
			/*$id_grupo=filter_input(INPUT_POST, 'id_grupo');

			$response=$data->listUser($id_grupo);

			echo json_encode($response);*/
			$id_grupo=filter_input(INPUT_POST, 'id_grupo');

			$response=$data->listUser($id_grupo);
			$text='';
			foreach ($response as $item) {
				$text.='<tr>';
				$text.='<td><img style="max-height:30px;boder-radius:50%" src="data:image/png;base64,'.$item['foto'].'"></td>';
				$text.='<td>'.$item['nome'].'</td>';
				$text.='<td>'.$item['departamento'].'</td>';
				$text.='<td>';
				if(hasRoles(['grupo_ver_utilizador_eliminar']))
				$text.='<button id="btn-delete-user" data-id="'.$item['id'].'" class="btn btn-sm btn-action btn-danger"><i class="fa fa-trash"></i></button>';
				$text.='</td>';
				$text.='</tr>';
			}

				echo $text;

			break;

		case 'edit':
				$id=filter_input(INPUT_POST, 'id');
				$nome=filter_input(INPUT_POST, 'nome');
				$local=filter_input(INPUT_POST, 'local');
				$descricao=filter_input(INPUT_POST, 'descricao');

				$response=$data->edit($nome,$local,$descricao,$id);

				echo json_encode($response);

				break;	

		case 'registerUser':

				$id_grupo=filter_input(INPUT_POST, 'id_grupo');
				$id_utilizador=filter_input(INPUT_POST, 'id_utilizador');
				$response=$data->registerUser($id_grupo,$id_utilizador);

				echo json_encode($response);
				
				break;

		case 'deleteUser': //apagar grupo

			$id_utilizador=filter_input(INPUT_POST, 'id_utilizador');
			$id_grupo=filter_input(INPUT_POST, 'id_grupo');
			$response=$data->deleteUser($id_utilizador,$id_grupo);

			echo json_encode($response);

			break;

		default:
			# code...
			break;
	}

?>