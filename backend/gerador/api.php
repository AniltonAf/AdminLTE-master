<?php

include_once '../enviroment/db_connection.php';
require  '../enviroment/function.php';

Class geradorAPI extends DbConnection{

    private $db;

    private $gerador_id;

    private $gerador;

    private $users;

    private $response=[
        "status"=>false,
        "message"=>"A autenticação é necessaria",
    ];

    function __construct(){

        $this->db=parent::getConnection();

        if(!$this->authentication()) $this->authFail();

        $this->action(filter_input(INPUT_POST, 'action'));
    }


    function action($action){
        switch($action){
            case 'event':
                $gerador_status=$this->existeCampo('gerador_status');
                $avariado=$this->existeCampo('avariado');
                $rede_publica=$this->existeCampo('rede_publica');

                $message='teste';
                $assunto='teste';

                if($avariado){
                    $message="O ";
                }

                $this->gerador=$this->getGerador();
                $this->users=$this->getUsers($this->gerador['id_grupo']);  
                $gerador_id = $this->gerador['id'];     
                $key_auth = $key_auth = $_SERVER['PHP_AUTH_PW'];  
                //var_dump( $key_auth );

                //send_email($this->users,$assunto,$message);
                //send_sms($this->users, $message);
                $this->updateGeradorConfig($gerador_id,$key_auth,$gerador_status,$avariado,$rede_publica);
             
                $this->historial_gerador($gerador_id,$gerador_status,$avariado,$rede_publica);

            break;

            default:
                $this->response['status']=false;
                $this->response['message']="Nenhum serviço solicitado";
                echo json_encode($this->response);
            break;
        }
    }

    function existeCampo($campo){
        if(!isset($_POST[$campo])){
            $this->response['status']=false;
            $this->response['message']='O campo '.$campo.' é obrigatorio';
            echo json_encode($this->response);
            exit;
        }
        return $_POST[$campo];
    }


    function authentication(){
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            $response['message']="A autenticação é necessaria";
            return false;
        } 
        
        else {
        
            $this->gerador_id = $_SERVER['PHP_AUTH_USER'];
            $key_auth = $_SERVER['PHP_AUTH_PW'];

            return $this->login($this->gerador_id,$key_auth);
        }
    }

    function authFail(){
        header('WWW-Authenticate: Basic realm="Terminal"');
        header('HTTP/1.0 401 Unauthorized');
        echo json_encode($this->response);
        exit;
    }

    function login($gerador_id,$key_auth){

        try{

			$res = $this->db->prepare('SELECT * FROM gerador_config WHERE gerador_id=:gerador_id and key_auth=:key_auth');

            $res->bindValue(':gerador_id',$gerador_id);
            $res->bindValue(':key_auth',$key_auth);

            $res->execute();
            
            if($res->rowCount()==1){
                return true;
            }else{
                $this->response['message']="Username ou password errado";
                return false;
            }		

		}catch(PDOException $e){
				echo $e->getMessage();
		}
    }

    function getGerador(){

        try{

			$res = $this->db->prepare('SELECT * FROM gerador WHERE id=:gerador_id');

            $res->bindValue(':gerador_id',$this->gerador_id);

            $res->execute();

            $line =$res->fetch(PDO::FETCH_ASSOC);
            
            return $line;

		}catch(PDOException $e){
				echo $e->getMessage();
		}

    }


    function getUsers($id_grupo){
        try{

			$res = $this->db->prepare('SELECT nome,email,telefone as numero FROM grupo_acesso as g JOIN utilizador as u on u.id=g.id_utilizador where id_grupo=:id_grupo');

            $res->bindValue(':id_grupo',$id_grupo);

            $res->execute();
            
            return $this->data($res);

		}catch(PDOException $e){
				echo $e->getMessage();
		}
    }

    private function data($res){
		$data=array();

		while($linha =$res->fetch(PDO::FETCH_ASSOC)){
			$data[]=$linha;
		}

		return $data;
    }


    function updateGeradorConfig($gerador_id,$key_auth,$gerador_status,$avariado,$rede_publica){

       $response = array();
        try{     

            $res = $this->db->prepare('UPDATE gerador_config SET gerador_status=:gerador_status, avariado=:avariado, rede_publica=:rede_publica WHERE gerador_id=:gerador_id and key_auth=:key_auth');
         
            $res->bindValue(':gerador_id',$gerador_id);
            $res->bindValue(':key_auth',$key_auth);
            $res->bindValue(':gerador_status',$gerador_status);
            $res->bindValue(':avariado',$avariado);
            $res->bindValue(':rede_publica',$rede_publica);

            $res->execute();

            $response['status'] = true;
        } catch(PDOException $e){	
            $response['status'] = false;
			echo $e->getMessage();
		}
        return $response;
        
    }


    function historial_gerador($gerador_id,$gerador_status,$avariado,$rede_publica){
        $response = array();
        try{
            $res = $this->db->prepare('INSERT INTO gerador_historico (gerador_id,key_auth,gerador_status,avariado,rede_publica) VALUES (:gerador_id,:key_auth,:gerador_status,:avariado,:rede_publica)');
            
            $res->bindValue(':gerador_id',$gerador_id);
            $res->bindValue(':gerador_status',$gerador_status);
            $res->bindValue(':avariado',$avariado);
            $res->bindValue(':rede_publica',$rede_publica);

            $res->execute();

            $response['status'] = true;
        } catch(PDOException $e){	
            $response['status'] = false;
			echo $e->getMessage();
		}
        return $response;


    }


    
}

new geradorAPI();
?>