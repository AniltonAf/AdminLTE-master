<?php 

require '../enviroment/db_connection.php';



Class Data extends DbConnection{

	private $db;


	function __construct(){
		$this->db=parent::getConnection();
	}


	private function data($res){
		$data=array();

		while($linha =$res->fetch(PDO::FETCH_ASSOC)){
			$data[]=$linha;
		}

		return $data;
	}

	public function list(){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM perfilutilizador WHERE estado=:estado');
			
			$res->bindValue(':estado',$estado);
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getItem($id){
		try{

			$res = $this->db->prepare('SELECT * FROM perfilutilizador WHERE id=:id');

			$res->bindValue(':id',$id);

			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	// função para deletar utilizadores
	public function delete($id,$estado,$delete_ut){
		$response=array();
		try{

			$res = $this->db->prepare('UPDATE perfilutilizador SET estado=:estado, delete_ut=:delete_ut WHERE id=:id');

			$res->bindValue(':id',$id);
			$res->bindValue(':estado',$estado);
			$res->bindValue(':delete_ut',$delete_ut);

			$res->execute();

			$response['status']=true;		

		}catch(PDOException $e){
			$response['status']=false;
		}
		return $response;
	}

	// função para registar novos utilizadores
	public function register($nome,$descricao,$create_ut){
		$response=array();
		try{

			$res = $this->db->prepare('INSERT INTO perfilutilizador (nome,descricao,create_ut) VALUES (:nome,:descricao,:create_ut)');

			$res->bindValue(':nome',$nome);
			$res->bindValue(':descricao',$descricao);
			$res->bindValue(':create_ut',$create_ut);

			$res->execute();

			$response['status']=true;		

		}catch(PDOException $e){
			$response['status']=false;
		}
		return $response;
	}
	// função para editar utilizadores
	public function edit($nome,$descricao,$id){
		$response=array();
		try{

			$res = $this->db->prepare('UPDATE perfilutilizador SET nome=:nome,descricao=:descricao WHERE id=:id');

			$res->bindValue(':nome',$nome);
			$res->bindValue(':descricao',$descricao);
			$res->bindValue(':id',$id);

			$res->execute();

			$response['status']=true;		

		}catch(PDOException $e){
			$response['status']=false;
		}
		return $response;
	}

	// função para listar as permissao
	public function listPermition($id_perfil){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT p.id,p.nome,p.descrisao, IF((SELECT pp.id FROM perfil_permissao as pp where pp.id_per=p.id and pp.id_perf_util=:id_perfil),true,false) as permissao FROM `permissoes` as p order by p.nome asc');
			
			$res->bindValue(':id_perfil',$id_perfil);
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	// função para deletar permissao
	public function deletePermissao($id_perfil){
		
		try{

			$res = $this->db->prepare("DELETE FROM perfil_permissao WHERE id_perf_util=:id_perfil");

			$res->bindValue(':id_perfil',$id_perfil);

			$res->execute();

			return true;		

		}catch(PDOException $e){
			return false;
		}
	}

	// função para atribuir permissao
	public function addPermissao($id_perfil,$id_per){
		
		try{

			$res = $this->db->prepare("INSERT INTO perfil_permissao (id_perf_util,id_per) VALUES (:id_perfil,:id_per)");

			$res->bindValue(':id_perfil',$id_perfil);
			$res->bindValue(':id_per',$id_per);

			$res->execute();

			return true;		

		}catch(PDOException $e){
			return false;
		}
	}

}


?>