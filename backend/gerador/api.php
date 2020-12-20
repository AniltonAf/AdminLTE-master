<?php
include_once '../enviroment/db_connection.php';




class geradorAPI extends DbConnection
{

    private $db;

    private $gerador_id;


    private $gerador;

    private $users;

    private $response = [
        "status" => false,
        "message" => "A autenticação é necessaria",
    ];

    function __construct()
    {

        $this->db = parent::getConnection();

        if (!$this->authentication()) $this->authFail();

        $this->action(filter_input(INPUT_POST, 'action'));
    }


    function action($action)
    {
        switch ($action) {
            case 'event':
                require  '../enviroment/functionApi.php';
                $gerador_status = $this->existeCampo('gerador_status');
                $avariado = $this->existeCampo('avariado');
                $rede_publica = $this->existeCampo('rede_publica');
                $low_fuel = $this->existeCampo('low_fuel');
                $qua_aut_trans = $this->existeCampo('qua_aut_trans');

                $messagem_email = 'teste email';
                $messagem_sms = 'teste sms';
                $assunto = 'teste';

                $this->gerador = $this->getGerador();
                $this->grupo = $this->getGrupo($this->gerador['id_grupo']);
                $this->users = $this->getUsers($this->gerador['id_grupo']);
                $gerador_id = $this->gerador['id'];
                $key_auth = $key_auth = $_SERVER['PHP_AUTH_PW'];

                // Condições para envio de alertas Avaria Gerador
                if ($avariado) { //
                    $assunto = 'Avaria Gerador';
                    $messagem_sms = '' . $this->gerador['descricao'] . ' em avaria, por favor verificar';
                    $messagem_email = '' . $this->gerador['descricao'] . ' em avaria, por favor deslocar ao gerador para a devida identificacao da avaria';

                    $response = send_sms($this->users, $messagem_sms);
                    //dados para tabela Historico_alertas sms

                    if ($response['status']) {
                        $status = $response['status'];
                        $menssage = $response['message'];
                        $codigo = $response['codigo'];
                        $menssagem = $response['messagem'];
                        $tipo = 'sms';
                        $user_send = json_encode($response['user_send']);
                        $this->historial_alertas($user_send, $tipo, $menssagem, $status, $menssage, $codigo);
                    }



                    $response = send_email($this->users, $assunto, $messagem_email);
                    //dados para tabela Historico_alertas email
                    if ($response['status']) {
                        $status = $response['status'];
                        $menssage = $response['message'];
                        $codigo = $response['codigo'];
                        $menssagem = $messagem_email;
                        $tipo = 'email';
                        $user_send = json_encode($response['user_send']);
                        $this->historial_alertas($user_send, $tipo, $menssagem, $status, $menssage, $codigo);
                    }
                }

                /*
                // Condições para envio de alertas na Avaria Rede Publica
                elseif($rede_publica){
                    $assunto='Avaria Rede Publica';
                    var_export($assunto);
                    $messagem_sms = 'Na Agênca'.$this->grupo['nome'].' avaria na rede de fornecimento de energia';
                    $messagem_email='Na Agênca'.$this->grupo['nome'].' avaria na rede de fornecimento de energia, por favor Verificar';
                    send_sms($this->users, $messagem_sms);
                    send_email($this->users,$assunto,$messagem_email);
                }
*/
                // Condições para envio de alertas Avaria QT
                //elseif(($gerador_status or $rede_publica) and !$power_edificio){

                if ($qua_aut_trans) {
                    $assunto = 'Avaria Quadro Transferencia';
                    $messagem_sms = 'A Agenca' . $this->grupo['nome'] . ' com QT em avaria, por favor verificar';
                    $messagem_email = 'A Agenca' . $this->grupo['nome'] . ' sem energia, avaria no Quadro de transferencia, por favor verificar';
                    $response = send_sms($this->users, $messagem_sms);
                    if ($response['status']) {
                        $status = $response['status'];
                        $menssage = $response['message'];
                        $codigo = $response['codigo'];
                        $menssagem = $response['messagem'];
                        $tipo = 'sms';
                        $user_send = json_encode($response['user_send']);
                        $this->historial_alertas($user_send, $tipo, $menssagem, $status, $menssage, $codigo);
                    }
                    //dados para tabela Historico_alertas sms                     



                    $response = send_email($this->users, $assunto, $messagem_email);
                    //dados para tabela Historico_alertas email 
                    if ($response['status']) {
                        $status = $response['status'];
                        $menssage = $response['message'];
                        $codigo = $response['codigo'];
                        $menssagem = $messagem_email;
                        $tipo = 'email';
                        $user_send = json_encode($response['user_send']);
                        $this->historial_alertas($user_send, $tipo, $menssagem, $status, $menssage, $codigo);
                    }
                }


                // Alerta de Gerador ON ou OFF
                if ($gerador_status || !$gerador_status) {
                    $estado = ($gerador_status) ? 'LIGADO' : 'DESLIGADO';
                    $assunto = 'Gerador ' . $estado;
                    $messagem_sms = 'Na Agenca' . $this->grupo['nome'] . ' gerador ' . $estado;
                    $messagem_email = 'Na Agenca' . $this->grupo['nome'] . ' gerador ' . $estado . ', por favor verificar';
                    $response = send_sms($this->users, $messagem_sms);
                    //dados para tabela Historico_alertas sms  
                    if ($response['status']) {
                        $status = $response['status'];
                        $menssage = $response['message'];
                        $codigo = $response['codigo'];
                        $menssagem = $response['messagem'];
                        $tipo = 'sms';
                        $user_send = json_encode($response['user_send']);
                        $this->historial_alertas($user_send, $tipo, $menssagem, $status, $menssage, $codigo);
                    }



                    $response = send_email($this->users, $assunto, $messagem_email);
                    //dados para tabela Historico_alertas email 
                    if ($response['status']) {
                        $status = $response['status'];
                        $menssage = $response['message'];
                        $codigo = $response['codigo'];
                        $menssagem = $messagem_email;
                        $tipo = 'email';
                        $user_send = json_encode($response['user_send']);
                        $this->historial_alertas($user_send, $tipo, $menssagem, $status, $menssage, $codigo);
                    }
                }

                // Alerta de nivel baixo de combustivel
                if ($low_fuel) {
                    $assunto = 'Gerador Nivel Baixo Combustivel';
                    $messagem_sms = 'Na Agenca' . $this->grupo['nome'] . ' gerador com nivel baixo de combustivel';
                    $messagem_email = 'Na Agenca' . $this->grupo['nome'] . ' gerador com nivel baixo de combustivel, por favor verificar';
                    $response = send_sms($this->users, $messagem_sms);
                    //dados para tabela Historico_alertas sms
                    if ($response['status']) {
                        $status = $response['status'];
                        $menssage = $response['message'];
                        $codigo = $response['codigo'];
                        $menssagem = $response['messagem'];
                        $tipo = 'sms';
                        $user_send = json_encode($response['user_send']);
                        $this->historial_alertas($user_send, $tipo, $menssagem, $status, $menssage, $codigo);
                    }


                    $response = send_email($this->users, $assunto, $messagem_email);
                    //dados para tabela Historico_alertas email
                    if ($response['status']) {
                        $status = $response['status'];
                        $menssage = $response['message'];
                        $codigo = $response['codigo'];
                        $menssagem = $messagem_email;
                        $tipo = 'email';
                        $user_send = json_encode($response['user_send']);
                        $this->historial_alertas($user_send, $tipo, $menssagem, $status, $menssage, $codigo);
                    }
                }

                $this->updateGeradorConfig($gerador_id, $key_auth, $gerador_status, $avariado, $rede_publica, $qua_aut_trans, $low_fuel);

                $this->historial_gerador($gerador_id, $gerador_status, $avariado, $rede_publica, $qua_aut_trans, $low_fuel);

                break;


            case 'update_ip':
                $ip_address = $this->existeCampo('ip_address');
                $this->gerador = $this->getGerador();
                echo "teste";
                if ($this->updateIpAddr($this->gerador_id, $ip_address)) {
                    $this->response['status'] = true;
                    $this->response['message'] = "IP Address atualizado";
                    echo json_encode($this->response);
                } else {
                    $this->response['status'] = false;
                    $this->response['message'] = "Erro ao atualizar IP Address";
                    echo json_encode($this->response);
                }

                break;

            default:
                $this->response['status'] = false;
                $this->response['message'] = "Nenhum serviço solicitado";
                echo json_encode($this->response);
                break;
        }
    }

    function existeCampo($campo)
    {
        if (!isset($_POST[$campo])) {
            $this->response['status'] = false;
            $this->response['message'] = 'O campo ' . $campo . ' é obrigatorio';
            echo json_encode($this->response);
            exit;
        }
        return $_POST[$campo];
    }


    function authentication()
    {
        echo "teste";
        if (!isset($_SERVER['PHP_AUTH_USER'])) {
            $response['message'] = "A autenticação é necessaria";
            return false;
        } else {

            $this->gerador_id = $_SERVER['PHP_AUTH_USER'];
            $key_auth = $_SERVER['PHP_AUTH_PW'];

            return $this->login($this->gerador_id, $key_auth);
        }
    }

    function authFail()
    {
        header('WWW-Authenticate: Basic realm="Terminal"');
        header('HTTP/1.0 401 Unauthorized');
        echo json_encode($this->response);
        exit;
    }

    function login($gerador_id, $key_auth)
    {

        try {

            $res = $this->db->prepare('SELECT * FROM gerador_config WHERE gerador_id=:gerador_id and key_auth=:key_auth');

            $res->bindValue(':gerador_id', $gerador_id);
            $res->bindValue(':key_auth', $key_auth);

            $res->execute();

            if ($res->rowCount() == 1) {
                return true;
            } else {
                echo $key_auth;
                $this->response['message'] = "Username ou password errado";
                return false;
            }
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getGerador()
    {

        try {

            $res = $this->db->prepare('SELECT * FROM gerador WHERE id=:gerador_id');

            $res->bindValue(':gerador_id', $this->gerador_id);

            $res->execute();

            $line = $res->fetch(PDO::FETCH_ASSOC);

            return $line;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    function getGrupo($id_grupo)
    {

        try {

            $res = $this->db->prepare('SELECT nome FROM grupo WHERE id=:id_grupo');

            $res->bindValue(':id_grupo', $id_grupo);

            $res->execute();

            $line = $res->fetch(PDO::FETCH_ASSOC);

            return $line;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }




    function getUsers($id_grupo)
    {
        try {

            $res = $this->db->prepare('SELECT u.id,nome,email,telefone,alerta_email,alerta_sms FROM grupo_acesso as g JOIN utilizador as u on u.id=g.id_utilizador where id_grupo=:id_grupo');

            $res->bindValue(':id_grupo', $id_grupo);

            $res->execute();

            return $this->data($res);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    private function data($res)
    {
        $data = array();

        while ($linha = $res->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $linha;
        }

        return $data;
    }


    function updateGeradorConfig($gerador_id, $key_auth, $gerador_status, $avariado, $rede_publica, $qua_aut_trans, $low_fuel)
    {

        $response = array();
        try {

            $res = $this->db->prepare('UPDATE gerador_config SET gerador_status=:gerador_status, avariado=:avariado, rede_publica=:rede_publica ,low_fuel=:low_fuel,qua_aut_trans=:qua_aut_trans WHERE gerador_id=:gerador_id and key_auth=:key_auth');

            $res->bindValue(':gerador_id', $gerador_id);
            $res->bindValue(':key_auth', $key_auth);
            $res->bindValue(':gerador_status', $gerador_status);
            $res->bindValue(':avariado', $avariado);
            $res->bindValue(':rede_publica', $rede_publica);
            $res->bindValue(':qua_aut_trans', $qua_aut_trans);
            $res->bindValue(':low_fuel', $low_fuel);

            $res->execute();

            $response['status'] = true;
        } catch (PDOException $e) {
            $response['status'] = false;
            echo 'erro';
            echo $e->getMessage();
        }
        return $response;
    }


    function historial_gerador($gerador_id, $gerador_status, $avariado, $rede_publica, $qua_aut_trans, $low_fuel)
    {

        $response = array();
        try {
            $res = $this->db->prepare('INSERT INTO gerador_historico (gerador_id,gerador_status,avariado,rede_publica,qua_aut_trans,low_fuel) VALUES (:gerador_id,:gerador_status,:avariado,:rede_publica,:qua_aut_trans,:low_fuel)');

            $res->bindValue(':gerador_id', $gerador_id);
            $res->bindValue(':gerador_status', $gerador_status);
            $res->bindValue(':avariado', $avariado);
            $res->bindValue(':rede_publica', $rede_publica);
            $res->bindValue(':qua_aut_trans', $qua_aut_trans);
            $res->bindValue(':low_fuel', $low_fuel);

            $res->execute();

            $response['status'] = true;
        } catch (PDOException $e) {
            $response['status'] = false;
            echo $e->getMessage();
        }
        return $response;
    }

    function updateIpAddr($gerador_id, $ip)
    {

        $response = array();
        try {

            $res = $this->db->prepare('UPDATE gerador_config SET ip=:ip WHERE gerador_id=:gerador_id');

            $res->bindValue(':gerador_id', $gerador_id);
            $res->bindValue(':ip', $ip);

            $res->execute();

            $response['status'] = true;
        } catch (PDOException $e) {
            $response['status'] = false;
            echo $e->getMessage();
        }
        return $response;
    }

    function historial_alertas($user_send, $tipo, $menssagem, $status, $menssage, $codigo)
    {

        $response = array();
        try {
            $res = $this->db->prepare('INSERT INTO reporte_alertas (user_send,tipo,menssagem,status,menssage,codigo) VALUES (:user_send,:tipo,:menssagem,:status,:menssage,:codigo)');

            $res->bindValue(':user_send', $user_send);
            $res->bindValue(':tipo', $tipo);
            $res->bindValue(':menssagem', $menssagem);
            $res->bindValue(':status', $status);
            $res->bindValue(':menssage', $menssage);
            $res->bindValue(':codigo', $codigo);

            $res->execute();

            $response['status'] = true;
        } catch (PDOException $e) {
            $response['status'] = false;
            echo $e->getMessage();
        }
        return $response;
    }
}

new geradorAPI();
