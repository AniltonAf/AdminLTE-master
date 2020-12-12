<?php

require '../enviroment/db_connection.php';



class Data extends DbConnection
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

			$res = $this->db->prepare('SELECT * FROM mqtt_server');

			//$res->bindValue(':estado',$estado);

			$res->execute();

			return $this->data($res);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	
	// função para atualizar configurações Email
	public function update($server_mqtt, $username, $port_mqtt, $port_ws,$id_cliente, $password, $ativo_ws, $ativo_mqtt)
	{
		$response = array();
		try {
			$this->db->query("DELETE FROM mqtt_server");
			
			$res = $this->db->prepare('INSERT INTO mqtt_server (server_mqtt,username,port_mqtt,port_ws,id_cliente,password,ativo_ws,ativo_mqtt) VALUES (:server_mqtt,:username,:port_mqtt,:port_ws,:id_cliente,:password,:ativo_ws,:ativo_mqtt)');

			$res->bindValue(':server_mqtt', $server_mqtt);
			$res->bindValue(':username', $username);
			$res->bindValue(':port_mqtt', $port_mqtt);
			$res->bindValue(':port_ws', $port_ws);
			$res->bindValue(':id_cliente', $id_cliente);
			$res->bindValue(':password', $password);
			$res->bindValue(':ativo_ws', $ativo_ws);
			$res->bindValue(':ativo_mqtt', $ativo_mqtt);

			$res->execute();

			$response['status'] = true;
		} catch (PDOException $e) {
			$response['status'] = false;
			echo $e->getMessage();
		}
		return $response;
	}



	



}
