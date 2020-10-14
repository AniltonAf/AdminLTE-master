<?php

	$action= filter_input(INPUT_POST, 'action');

	require 'sql.php';
	$data = new Data();
	//defenir fuso horairio para definir hora com php
	date_default_timezone_set("Atlantic/Cape_Verde");
	
	//
	switch ($action) {

		case 'list': //listar grupos
			 
			 $response = $data->list();

			 echo json_encode($response);

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

			$id_perfil=filter_input(INPUT_POST, 'id');

			$response=$data->listPermition($id_perfil);

?>
			<div class="row">
            <div class="col-12">            
              <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <button class="btn btn-sm btn-primary" id="btnAdd" style="float: left; margin-right: 40px">Adicionar</button>
                <table id="datatable" class="table table-bordered ">
                  <thead>
                    <tr>
                      <th>Foto</th>
                      <th>Nome</th>
                      <th>Departamento</th>
                      <th></th>
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

		case 'edit':
				$id=filter_input(INPUT_POST, 'id');
				$nome=filter_input(INPUT_POST, 'nome');
				$local=filter_input(INPUT_POST, 'local');
				$descricao=filter_input(INPUT_POST, 'descricao');

				$response=$data->edit($nome,$local,$descricao,$id);

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