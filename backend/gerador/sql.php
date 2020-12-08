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

			$res = $this->db->prepare('SELECT g.id,g.modelo,g.fabricante,g.descricao,g.potencia,g.hora_trabalho,g.ip,g.data_manutencao,g.estado,gr.nome FROM gerador as g join grupo as gr on gr.id=g.id_grupo WHERE g.estado=:estado');
			
			$res->bindValue(':estado',$estado);
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function listGrup(){
			$estado=1;
			try{

				$res = $this->db->prepare('SELECT * FROM grupo WHERE estado=:estado');
				
				$res->bindValue(':estado',$estado);
				
				$res->execute();

				return $this->data($res);			

			}catch(PDOException $e){
					echo $e->getMessage();
			}
		}

	public function getItem($id){
		try{

			$res = $this->db->prepare('SELECT * FROM gerador WHERE id=:id');

			$res->bindValue(':id',$id);

			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getConfig($id){
		try{

			$res = $this->db->prepare('SELECT * FROM gerador_config WHERE gerador_id=:id');

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

			$res = $this->db->prepare('UPDATE gerador SET estado=:estado, delete_ut=:delete_ut WHERE id=:id');

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

	// função para registar novos gerador
	public function register($modelo, $fabricante, $descricao, $potencia, $hora_trabalho, $data_manutencao, $id_grupo, $latitude,$longitude,  $estado, $create_ut){
		
		$response=array();
		try{

			$id=md5(microtime());
			$key_auth=hash("sha256",microtime());

			$res = $this->db->prepare('INSERT INTO gerador (id,modelo,fabricante,descricao,potencia,hora_trabalho,data_manutencao,latitude,longitude,estado,id_grupo,create_ut) VALUES (:id,:modelo,:fabricante,:descricao,:potencia,:hora_trabalho,:data_manutencao,:latitude,:longitude,:estado,:id_grupo,:create_ut)');

			$res->bindValue(':id',$id);
			$res->bindValue(':modelo',$modelo);
			$res->bindValue(':fabricante',$fabricante);
			$res->bindValue(':descricao',$descricao);
			$res->bindValue(':potencia',$potencia);
			$res->bindValue(':hora_trabalho',$hora_trabalho);
			$res->bindValue(':data_manutencao',$data_manutencao);
			$res->bindValue(':latitude',$latitude);
			$res->bindValue(':longitude',$longitude);
			$res->bindValue(':estado',$estado);
			$res->bindValue(':id_grupo',$id_grupo);
			$res->bindValue(':create_ut',$create_ut);

			$res->execute();

			$response['status']=true;
			
			$resConfig = $this->db->prepare('INSERT INTO gerador_config (gerador_id,key_auth) VALUES (:gerador_id,:key_auth)');
			$resConfig->bindValue(':gerador_id',$id);
			$resConfig->bindValue(':key_auth',$key_auth);

			$resConfig->execute();

			$response['status']=true;


		}catch(PDOException $e){
			echo $e->getMessage();
			$response['status']=false;
		}
		return $response;
	}
	// função para editar gerador
	public function edit($modelo,$fabricante,$descricao,$potencia,$hora_trabalho,$ip,$data_manutencao,$id_grupo,$id){
		$response=array();
		try{

			$res = $this->db->prepare('UPDATE gerador SET modelo=:modelo,fabricante=:fabricante,descricao=:descricao,potencia=:potencia,hora_trabalho=:hora_trabalho,ip=:ip,data_manutencao=:data_manutencao,id_grupo=:id_grupo WHERE id=:id');

			$res->bindValue(':modelo',$modelo);
			$res->bindValue(':fabricante',$fabricante);
			$res->bindValue(':descricao',$descricao);
			$res->bindValue(':potencia',$potencia);
			$res->bindValue(':hora_trabalho',$hora_trabalho);
			$res->bindValue(':ip',$ip);
			$res->bindValue(':data_manutencao',$data_manutencao);
			$res->bindValue(':id_grupo',$id_grupo);
			$res->bindValue(':id',$id);

			$res->execute();

			$response['status']=true;		

		}catch(PDOException $e){
			//echo $e->getMessage();
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