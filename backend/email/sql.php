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

			$res = $this->db->prepare('SELECT * FROM email_server');

			//$res->bindValue(':estado',$estado);

			$res->execute();

			return $this->data($res);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	// função para registar novos utilizadores
	public function register($nome, $numero_funcionario, $departamento, $funcao, $email, $telefone, $id_perfil_permission, $password, $username, $foto, $estado, $create_ut)
	{
		$response = array();
		try {

			$res = $this->db->prepare('INSERT INTO utilizador (nome,numero_funcionario,departamento,funcao,email,telefone,id_perfil_permission,password,username,foto,estado,create_ut) VALUES (:nome,:numero_funcionario,:departamento,:funcao,:email,:telefone,:id_perfil_permission,:password,:username,:foto,:estado,:create_ut)');

			$res->bindValue(':nome', $nome);
			$res->bindValue(':numero_funcionario', $numero_funcionario);
			$res->bindValue(':departamento', $departamento);
			$res->bindValue(':funcao', $funcao);
			$res->bindValue(':email', $email);
			$res->bindValue(':telefone', $telefone);
			$res->bindValue(':id_perfil_permission', $id_perfil_permission);
			$res->bindValue(':password', $password);
			$res->bindValue(':username', $username);
			$res->bindValue(':foto', $foto);
			$res->bindValue(':estado', $estado);
			$res->bindValue(':create_ut', $create_ut);

			$res->execute();

			$response['status'] = true;
		} catch (PDOException $e) {
			//echo $e->getMessage();
			$message = 'Erro ao registar utilizador';
			if (strpos($e->getMessage(), 'Duplicate') >= 0) {
				$text = explode("'", $e->getMessage());
				$message = $text[3] . " '" . $text[1] . "' já existe";
			}
			$response['status'] = false;
			$response['message'] = $message;
		}
		return $response;
	}
	// função para editar utilizadores
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

	public function listPermition($id_perfil)
	{
		$estado = 1;
		try {

			$res = $this->db->prepare('SELECT p.id,p.nome,p.descrisao, IF((SELECT pp.id FROM perfil_permissao as pp where pp.id_per=p.id and pp.id_perf_util=:id_perfil),true,false) as permissao FROM `permissoes` as p order by p.nome asc');

			$res->bindValue(':id_perfil', $id_perfil);

			$res->execute();

			return $this->data($res);
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}
