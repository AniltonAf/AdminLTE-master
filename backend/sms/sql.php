<?php

if(!isset($_POST['gerador_status'])) require $_SERVER['DOCUMENT_ROOT'].'/backend/enviroment/db_connection.php';


class SMS extends DbConnection
{

	private $db;


	function __construct()
	{
		$this->db = parent::getConnection();
	}


	private function data($res)
	{
		$data = array();

		while ($linha = $res->fetch(PDO::FETCH_ASSOC)) {
			$data[] = $linha;
		}

		return $data;
	}

	public function list()
	{
		//$estado=1;
		try {

			$res = $this->db->prepare('SELECT * FROM sms_server');

			//$res->bindValue(':estado',$estado);

			$res->execute();

			return $this->data($res);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	
	// função para atualizar configurações sms
	public function update($accountsid, $authtoken, $ativo, $numberfrom, $provedor)
	{
		$response = array();
		try {
			$this->db->query("DELETE FROM sms_server");
			
			$res = $this->db->prepare('INSERT INTO sms_server (accountsid,authtoken,ativo,numberfrom,provedor) VALUES (:accountsid,:authtoken,:ativo,:numberfrom,:provedor)');

			$res->bindValue(':accountsid', $accountsid);
			$res->bindValue(':authtoken', $authtoken);
			$res->bindValue(':ativo', $ativo);
			$res->bindValue(':numberfrom', $numberfrom);
			$res->bindValue(':provedor', $provedor);

			$res->execute();

			$response['status'] = true;
		} catch (PDOException $e) {
			$response['status'] = false;
			echo $e->getMessage();
		}
		return $response;
	}

}
