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

	public function count_estado($campo,$status){
		try{

			$res = $this->db->prepare('SELECT Count(*) as qtd FROM gerador_config WHERE '.$campo.'=:status');
			$res->bindValue(':status',$status);

			$res->execute();

			$line=$res->fetch(PDO::FETCH_ASSOC);

			return $line['qtd'];			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getGeradores(){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM gerador as g join gerador_config as gc on gc.gerador_id=g.id WHERE estado=:estado');
			
			$res->bindValue(':estado',$estado);
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getGerador($id){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM gerador as g join gerador_config as gc on gc.gerador_id=g.id WHERE g.id=:id and estado=:estado');
			
			$res->bindValue(':estado',$estado);
			$res->bindValue(':id',$id);
			
			$res->execute();

			return $res->fetch(PDO::FETCH_ASSOC);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getServer(){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM mqtt_server WHERE ativo_ws=:estado');
			
			$res->bindValue(':estado',$estado);
			
			$res->execute();

			return $res->fetch(PDO::FETCH_ASSOC);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getItem($id){
		try{

			$res = $this->db->prepare('SELECT * FROM grupo WHERE id=:id');

			$res->bindValue(':id',$id);

			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function last5event(){
	
		try{

			$res = $this->db->prepare('SELECT * FROM gerador_historico LIMIT 5');
			
			//$res->bindValue(':estado',$estado);
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}
/*
	// função para deletar utilizadores
	public function delete($id,$estado,$delete_ut){
		$response=array();
		try{

			$res = $this->db->prepare('UPDATE grupo SET estado=:estado, delete_ut=:delete_ut WHERE id=:id');

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
	public function register($nome,$local,$descricao,$create_ut,$estado){
		$response=array();
		try{

			$res = $this->db->prepare('INSERT INTO grupo (nome,local,descricao,create_ut,estado) VALUES (:nome,:local,:descricao,:create_ut,:estado)');

			$res->bindValue(':nome',$nome);
			$res->bindValue(':local',$local);
			$res->bindValue(':descricao',$descricao);
			$res->bindValue(':create_ut',$create_ut);
			$res->bindValue(':estado',$estado);

			$res->execute();

			$response['status']=true;		

		}catch(PDOException $e){
			$response['status']=false;
		}
		return $response;
	}
	// função para editar grupo
	public function edit($nome,$local,$descricao,$id){
		$response=array();
		try{

			$res = $this->db->prepare('UPDATE grupo SET nome=:nome,local=:local,descricao=:descricao WHERE id=:id');

			$res->bindValue(':nome',$nome);
			$res->bindValue(':local',$local);
			$res->bindValue(':descricao',$descricao);
			$res->bindValue(':id',$id);

			$res->execute();

			$response['status']=true;		

		}catch(PDOException $e){
			$response['status']=false;
		}
		return $response;
	}

	// função para listar as utilizador
	public function listUser($id_grupo){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM grupo_acesso as g join utilizador as u on u.id=g.id_utilizador WHERE id_grupo=:id_grupo');
			
			$res->bindValue(':id_grupo',$id_grupo);
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function listUserDesponivel($id_grupo){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM utilizador WHERE id NOT IN (SELECT id_utilizador FROM grupo_acesso where id_grupo=:id_grupo) and estado=1');
			
			$res->bindValue(':id_grupo',$id_grupo);
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	// função para deletar permissao
	public function deletePermissao($id_perfil){
		
		try{

			$res = $this->db->prepare("DELETE FROM grupo WHERE id_perf_util=:id_perfil");

			$res->bindValue(':id_perfil',$id_perfil);

			$res->execute();

			return true;		

		}catch(PDOException $e){
			return false;
		}
	}

	// função para registar novos utilizadores
	public function registerUser($id_grupo,$id_utilizador)
	{
		$response=array();
		try{

			$res = $this->db->prepare('INSERT INTO grupo_acesso (id_grupo,id_utilizador) VALUES (:id_grupo,:id_utilizador)');

			$res->bindValue(':id_grupo',$id_grupo);
			$res->bindValue(':id_utilizador',$id_utilizador);

			$res->execute();

			$response['status']=true;		

		}catch(PDOException $e){
			$response['status']=false;
		}
		return $response;
	}

	// função para deletar utilizadores
	public function deleteUser($id_utilizador,$id_grupo){
		$response=array();
		try{

			$res = $this->db->prepare('DELETE FROM grupo_acesso WHERE id_grupo=:id_grupo and id_utilizador=:id_utilizador');

			$res->bindValue(':id_utilizador',$id_utilizador);
			$res->bindValue(':id_grupo',$id_grupo);

			$res->execute();

			$response['status']=true;		

		}catch(PDOException $e){
			$response['status']=false;
		}
		return $response;
	}

	*/
}


?>