<?php 


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'plugins/phpmailer/src/Exception.php';
require 'plugins/phpmailer/src/PHPMailer.php';
require 'plugins/phpmailer/src/SMTP.php';



function hasRoles($array){

    

    foreach ($array as $requireRole) {
      $exist=false;
      foreach ($_SESSION['caixa_monitorizacao']['permissoes'] as $myRole) {

        if(strcmp($requireRole, $myRole['nome'])==0){
          $exist=true;
          break;
        }

      }

      if(!$exist) return false;
    }

    return true;
    
}



function testemail($host,$username,$smtp_auth,$port,$password,$ativo,$smtp_security,$emailde,$emailpara){


    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->Host = $host;
    $mail->SMTPAuth =$smtp_auth;
    $mail->SMTPSecure = $smtp_security;
    $mail->Username = $username;
    $mail->Password = $password;
    $mail->Port = $port;
    $mail->SMTPKeepAlive = $ativo;

    $mail->setFrom('geradorcaixa@gmail.com','Sistema Monitorizacao');

    $mail->addAddress($emailde, $emailpara);

    $mail->isHTML(true);
    $mail->Subject = 'Assunto do email';
    $mail->Body    = 'Este é o conteúdo da mensagem em <b>HTML!</b>';
    $mail->AltBody = 'Para visualizar essa mensagem acesse http://site.com.br/mail';

    if(!$mail->send()) {
        echo 'Não foi possível enviar a mensagem.<br>';
        echo 'Erro: ' . $mail->ErrorInfo;
    } else {
        echo 'Mensagem enviada.';
    }




  
}



?>