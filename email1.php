<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'plugins/phpmailer/src/Exception.php';
require 'plugins/phpmailer/src/PHPMailer.php';
require 'plugins/phpmailer/src/SMTP.php';

$mail = new PHPMailer;
$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tls';
$mail->Username = 'geradorcaixa@gmail.com';
$mail->Password = 'geradorcaixa20.';
$mail->Port = 587;
$mail->SMTPKeepAlive = true;
//$mail->SMTPDebug = 2;
$users=[
    [
        "nome" => "Ivanildo Silva",
        "email" => "ivanildoee@gmail.com",
    ],
    [
        "nome" => "Anilton Andrade",
        "email" => "aniltonafortes@gmail.com",
    ]
];
$mail->setFrom('geradorcaixa@gmail.com','Sistema Monitorizacao');

foreach($users as $user){
    $mail->addAddress($user['email'], $user['nome']);
}
/*$mail->addAddress('ivanildoee@gmail.com', 'Ivanildo Silva');
$mail->addAddress('anilton_andrade@hotmail.com', 'Anilton Andrade');
$mail->addAddress('ivanildoee@hotmail.com', 'Ivanildo Silva');*/

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

?>