<?php 
declare(strict_types=1);




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

?>