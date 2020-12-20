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
	
		try{

			$res = $this->db->prepare('SELECT * FROM gerador_historico');
			
			//$res->bindValue(':estado',$estado);
			
			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}

	public function getGerador($gerador_id ){
		try{

			$res = $this->db->prepare('SELECT * FROM gerador WHERE id=:gerador_id');

			$res->bindValue(':gerador_id',$gerador_id );

			$res->execute();

			return $this->data($res);			

		}catch(PDOException $e){
				echo $e->getMessage();
		}
	}
	
}


?>