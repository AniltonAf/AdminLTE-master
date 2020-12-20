<?php



use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require $_SERVER['DOCUMENT_ROOT'] . '/plugins/phpmailer/src/Exception.php';
require $_SERVER['DOCUMENT_ROOT'] . '/plugins/phpmailer/src/PHPMailer.php';
require $_SERVER['DOCUMENT_ROOT'] . '/plugins/phpmailer/src/SMTP.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/backend/email/sql.php';
require $_SERVER['DOCUMENT_ROOT'] . '/backend/sms/sql.php';

function send_email($users, $assunto, $mensagem_email)
{
  $data = new EMAIL();
  $server = $data->list();
  $server = $server[0];


  $response = [
    "status" => false,
    "message" => "",
    "tipo" => "email",
    "codigo" => ""
  ];


  if (!$server['ativo']) {
    $response["message"] = "O serviço de email encontra-se desativado";
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

  $mail->setFrom($server['username'], 'Sistema Monitorizacao');


  $response['user_send'] = [
    "success" => [],
    "fail" => []
  ];

  foreach ($users as $user) {
    if ($user['alerta_email']) {
      $mail->addAddress($user['email'], $user['nome']);      
    }
  }
  $mail->isHTML(true);
  $mail->Subject = $assunto;
  $mail->Body    = $mensagem_email;
  //$mail->AltBody = 'Para visualizar essa mensagem acesse http://site.com.br/mail';

  if (!$mail->send()) {
    $response['message'] = "Erro ao enviar email";
    $response['erro'] = $mail->ErrorInfo;
    $response['user_send']['fail'][] = $user['id'];
  } else {
    $response['message'] = "Email enviada";
    $response['menssagem'] = $mensagem_email;
    $response['status'] = true;
    $response['user_send']['success'][] = $user['id'];
  }
  echo json_encode($response);
  return $response;
}


function test_email($host, $port, $username, $password)
{
  require $_SERVER['DOCUMENT_ROOT'] . '/plugins/phpmailer/src/Exception.php';
  require $_SERVER['DOCUMENT_ROOT'] . '/plugins/phpmailer/src/SMTP.php';
  $smtp = new SMTP;
  $response = [
    "status" => false
  ];

  //$smtp->do_debug = SMTP::DEBUG_CONNECTION;
  try {
    //Connect to an SMTP server
    if (!$smtp->connect($host, $port, 6)) {
      throw new Exception("Erro ao conectar a " . $host . ":" . $port);
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
      if ($smtp->authenticate($username, $password)) {
        $response["message"] = "Conexão Ok";
        $response["status"] = true;
      } else {
        throw new Exception("Nome de utilizador ou password incorreto");
      }
    }
  } catch (Exception $e) {
    $response["message"] = $e->getMessage();
    $response["status"] = false;
  }

  echo json_encode($response);
}

/****Bibliotecas */

use Twilio\Rest\Client;
use Twilio\Exceptions\TwilioException;

require $_SERVER['DOCUMENT_ROOT'] . '/plugins/twilio/src/Twilio/autoload.php';


function send_sms($users, $mensagem_sms)
{

  $response = [
    "status" => false,
    "message" => "",
    "codigo" => ""
  ];


  $response['user_send'] = [
    "success" => [],
    "fail" => []
  ];

  $data = new SMS();
  $server = $data->list();
  $server = $server[0];


  if (!$server['ativo']) {
    $response["message"] = "O serviço de SMS encontra-se desativado";
    echo json_encode($response);
    return $response;
  }
  $twilioAccountSid = $server['accountsid'];
  $twilioAuthToken = $server['authtoken'];
  $fromNumber = $server['numberfrom'];

  $client = new Client($twilioAccountSid, $twilioAuthToken);


  foreach ($users as $user) {
    if ($user['alerta_sms']) {
      try {


        $message = $client->messages->create($user['telefone'], ['from' => $fromNumber, 'body' => $mensagem_sms]);


        $response['status'] = true;
        $response['message'] = "SMS enviada";
        $response['messagem'] = $mensagem_sms;
        $response['codigo'] = "";
        $response['user_send']['success'][] = $user['id'];

        break;
      } catch (TwilioException $e) {
        $response['message'] = "Erro ao enviar SMS";
        $response['codigo'] = $e->getCode();
        $response['erro'] = $e->getMessage();
        $response['user_send']['fail'][] = $user['id'];
      }
    }
  }

  echo json_encode($response);
  return $response;
}






/*function testemail($host,$username,$smtp_auth,$port,$password,$ativo,$smtp_security,$emailde,$emailpara){

//function testemail($host,$username,$port,$password,$smtp_security,$emailde,$emailpara){

  var_dump($host);
  var_dump($username);
  var_dump($port);
  var_dump($password);
  var_dump($smtp_security);
  var_dump($smtp_auth);
  var_dump($ativo);
  var_dump($emailde);
  var_dump($emailpara);

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->SMTPAuth =true;
    $mail->SMTPSecure = $smtp_security;
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->Port = $port;
    $mail->SMTPKeepAlive = true;

/*
    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->SMTPSecure = 'tls';
    $mail->Username = 'geradorcaixa@gmail.com';
    $mail->Password = 'geradorcaixa20.';
    $mail->Port = 587;
    $mail->SMTPKeepAlive = true;

    $mail->setFrom('geradorcaixa@gmail.com','Sistema Monitorizacao');

    //$mail->addAddress($emailde, $emailpara);
    $mail->addAddress($username, 'aniltonafortes@gmail.com');

    $mail->isHTML(true);
    $mail->Subject = 'Teste Comunicação E-mail';
    $mail->Body    = 'Este é o conteúdo da mensagem em <b>HTML!</b>';
    $mail->AltBody = 'Para visualizar essa mensagem acesse http://site.com.br/mail';

    if(!$mail->send()) {
      $response['status'] = false;
    } else {
      $response['status'] = true;
    }

    return $response;
  
}



  function smssend($accountsid, $authtoken, $ativo, $numberfrom, $numberto, $menssagem){

    $twilioAccountSid = $accountsid;
    $twilioAuthToken = $authtoken;

    $fromNumber = $numberfrom;
    $receptores = $numberto;

    $message = $menssagem;

    if($ativo){
      foreach($receptores as $toNumber){

        $client = new Twilio\Rest\Client($twilioAccountSid, $twilioAuthToken);
    
        $message = $client->messages->create($toNumber,['from' => $fromNumber,'body' => $message]);
    
        unset($toNumber);
      }
      $response['status'] = false;
    } else {
        $response['status'] = true;
    }

  }

*/
