<?php
declare(strict_types=1);//SMS

$action = filter_input(INPUT_POST, 'action');

/****Bibliotecas */
use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

//require '../vendor/autoload.php';
//use Twilio\Rest\Client;

require '../plugins/phpmailer/src/Exception.php';
require '../plugins/phpmailer/src/PHPMailer.php';
require '../plugins/phpmailer/src/SMTP.php';
require '../plugins/twilio/src/Twilio/autoload.php';

//sms
//require '../vendor/autoload.php';


switch ($action) {

    case 'test_email':

        /***Credencias */
        $host = filter_input(INPUT_POST, 'host');
        $port = filter_input(INPUT_POST, 'port');
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $smtp = new SMTP;
        $response=[
            "status"=>false
        ];

        //$smtp->do_debug = SMTP::DEBUG_CONNECTION;
        try {
            //Connect to an SMTP server
            if (!$smtp->connect($host, $port,6)) {
                throw new Exception("Erro ao conectar a ".$host.":".$port);
            }
            //Say hello
            if (!$smtp->hello(gethostname())) {
                throw new Exception("Servidor não responde");
            }
            //Get the list of ESMTP services the server offers
            $e = $smtp->getServerExtList();

            if (is_array($e) && array_key_exists('STARTTLS', $e)) {
                $tlsok = $smtp->startTLS();
                if (!$tlsok) {
                    throw new Exception('Erro no certicado de segurança');
                }
                //Repeat EHLO after STARTTLS
                if (!$smtp->hello(gethostname())) {
                    throw new Exception('Servidor não responde');
                }
                //Get new capabilities list, which will usually now include AUTH if it didn't before
                $e = $smtp->getServerExtList();
            }

            //If server supports authentication, do it (even if no encryption)
            if (is_array($e) && array_key_exists('AUTH', $e)) {
                if ($smtp->authenticate($username,$password)) {
                    $response["message"]="Conexão Ok";
                    $response["status"]=true;
                } else {
                    throw new Exception("Nome de utilizador ou password incorreto");
                }
            }
        } catch (Exception $e) {
            $response["message"]=$e->getMessage();
            $response["status"]=false;
        }

        echo json_encode($response);

        break;


    case 'send_email':
        

        $users = json_decode(filter_input(INPUT_POST, 'users'),true);
        $assunto= filter_input(INPUT_POST, 'assunto');
        $mensagem=filter_input(INPUT_POST, 'mensagem');
        
        send_email($users,$assunto,$mensagem);
    break;


    case 'terminal':

    break;


    case 'send_sms';

        /***Credencias envio*/
        $users = json_decode(filter_input(INPUT_POST, 'users'),true);
        $mensagem = filter_input(INPUT_POST, 'mensagem');

        send_sms($users, $mensagem);

    break;

    default:
        echo json_encode(["status"=>false,"message"=>"Serviço não encontrado"]);
    break;
}




function send_email($users,$assunto,$mensagem){
    
    require 'email/sql.php';
    $data = new Data();
    $server = $data->list();
    $server = $server[0];

    $response=[
        "status"=>false,
        "message"=>""
    ];


    if(!$server['ativo']){
        $response["message"]="O serviço de email encontra-se desativado";
        echo json_encode($response);
        return false;
    }

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = $server['host'];
    $mail->SMTPAuth = $server['smtp_auth'];
    $mail->SMTPSecure = $server['smtp_security'];
    $mail->Username = $server['username'];
    $mail->Password = $server['password'];
    $mail->Port = $server['port'];
    $mail->SMTPKeepAlive = true;
    //$mail->SMTPDebug = 2;

    $mail->setFrom($server['username'],'Sistema Monitorizacao');

    foreach($users as $user){
        $mail->addAddress($user['email'], $user['nome']);
    }

    $mail->isHTML(true);
    $mail->Subject = $assunto;
    $mail->Body    = $mensagem;
    //$mail->AltBody = 'Para visualizar essa mensagem acesse http://site.com.br/mail';

    if(!$mail->send()) {
        $reponse['message']="Erro ao enviar mensagem";
        $reponse['status']=false;
        $response['erro']=$mail->ErrorInfo;
    } else {
        $reponse['message']="Mensagem enviada";
        $reponse['status']=true;
    }

    echo json_encode($reponse);
}

function send_sms($users, $mensagem){
    require 'sms/sql.php';
    
           
    try{
        $data = new Data();
        $server = $data->list();
        $server = $server[0];

        $response=[
            "status"=>false,
            "message"=>""
        ];

        if(!$server['ativo']){
            $response["message"]="O serviço de SMS encontra-se desativado";
            echo json_encode($response);
            return false;
        }

        $twilioAccountSid = $server['accountsid'];
        $twilioAuthToken = $server['authtoken'];
        $fromNumber = $server['numberfrom'];

        

        foreach($users as $user){

            $client = new Client($twilioAccountSid, $twilioAuthToken);
        
            $message = $client->messages->create($user['numero'],['from' => $fromNumber,'body' => $mensagem]);
        }

        $response['status']=true;
        $response['message']="Mensagem enviada";
    }catch(TwilioException $e){
        $response['message']="Erro ao enviar Mensagem";
        $response['codigo']=$e->getCode();
        $response['erro_message']=$e->getMessage();
    }
    
    echo json_encode($response);
}

