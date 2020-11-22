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
                $power_edificio=$this->existeCampo('power_edificio');
                $power_RP=$this->existeCampo('power_RP');

                $messagem_email='teste email';
                $messagem_sms='teste sms';
                $assunto='teste';

                $this->gerador=$this->getGerador();
                $this->grupo=$this->getGrupo($this->gerador['id_grupo']);
                $this->users=$this->getUsers($this->gerador['id_grupo']);  
                $gerador_id = $this->gerador['id'];     
                $key_auth = $key_auth = $_SERVER['PHP_AUTH_PW']; 
                  
                /*// Condições para envio de alertas Avaria Gerador
                if($avariado and (!$gerador_status or $gerador_status)){ //
                    $assunto='Avaria Gerador';
                    var_export($assunto);
                    $messagem_sms = ''.$this->gerador['descricao'].' em avaria, por favor verificar';
                    $messagem_email=''.$this->gerador['descricao'].' em avaria, por favor deslocar ao gerador para a devida identificação da avaria';
                    send_sms($this->users, $messagem_sms);
                    send_email($this->users,$assunto,$messagem_email);
                    
                }

                // Condições para envio de alertas Avaria QT
                if(($gerador_status or !$rede_publica) and !$power_edificio and $power_RP){
                    $assunto='Avaria Quadro Transferencia';
                    var_export($assunto);
                    $messagem_sms = 'A Agênca'.$this->grupo['nome'].' com QT em avaria, por favor verificar';
                    $messagem_email='A Agênca'.$this->grupo['nome'].' sem energia, avaria no Quadro de transferência, por favor Verificar';
                    send_sms($this->users, $messagem_sms);
                    send_email($this->users,$assunto,$messagem_email);
                    
                }

                // Condições para envio de alertas na Avaria Rede Publica
                if($rede_publica and  $power_RP){
                    $assunto='Avaria Rede Publica';
                    var_export($assunto);
                    $messagem_sms = 'Na Agênca'.$this->grupo['nome'].' avaria na rede de fornecimento de energia';
                    $messagem_email='Na Agênca'.$this->grupo['nome'].' avaria na rede de fornecimento de energia, por favor Verificar';
                    send_sms($this->users, $messagem_sms);
                    send_email($this->users,$assunto,$messagem_email);
                }*/
                                    
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

    function getGrupo($id_grupo){     

        try{

            $res = $this->db->prepare('SELECT nome FROM grupo WHERE id=:id_grupo');
            
            $res->bindValue(':id_grupo',$id_grupo);
            
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
            $res = $this->db->prepare('INSERT INTO gerador_historico (gerador_id,gerador_status,avariado,rede_publica) VALUES (:gerador_id,:gerador_status,:avariado,:rede_publica)');
            
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