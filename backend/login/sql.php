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

	public function login($username,$password){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT id,nome,email,foto,id_perfil_permission FROM utilizador WHERE username=:username AND password=:password AND estado=1');
			
			$res->bindValue(':username',$username);
			$res->bindValue(':password',hash('sha256', $password));
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function listPermition($id_perfil){
		$estado=1;
		try{

			$res = $this->db->prepare('SELECT * FROM permissoes as p join perfil_permissao as pp on pp.id_per=p.id where pp.id_perf_util=:id_perfil');
			
			$res->bindValue(':id_perfil',$id_perfil);
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	

}


?>