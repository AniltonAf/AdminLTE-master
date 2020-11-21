<?php

if(!isset($_POST['gerador_status'])) require  $_SERVER['DOCUMENT_ROOT'].'/backend/enviroment/db_connection.php';



class EMAIL extends DbConnection
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

			$res = $this->db->prepare('SELECT * FROM email_server');

			//$res->bindValue(':estado',$estado);

			$res->execute();

			return $this->data($res);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	
	// função para atualizar configurações Email
	public function update($host, $username, $smtp_auth, $port, $password, $ativo, $smtp_security)
	{
		$response = array();
		try {
			$this->db->query("DELETE FROM email_server");
			
			$res = $this->db->prepare('INSERT INTO email_server (host,username,smtp_auth,port,password,ativo,smtp_security) VALUES (:host,:username,:smtp_auth,:port,:password,:ativo,:smtp_security)');

			$res->bindValue(':host', $host);
			$res->bindValue(':username', $username);
			$res->bindValue(':smtp_auth', $smtp_auth);
			$res->bindValue(':port', $port);
			$res->bindValue(':password', $password);
			$res->bindValue(':ativo', $ativo);
			$res->bindValue(':smtp_security', $smtp_security);

			$res->execute();

			$response['status'] = true;
		} catch (PDOException $e) {
			$response['status'] = false;
			echo $e->getMessage();
		}
		return $response;
	}






}
