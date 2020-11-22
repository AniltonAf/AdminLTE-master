<?php
declare(strict_types=1);//SMS


require 'enviroment/function.php';


$action = filter_input(INPUT_POST, 'action');





switch ($action) {

    case 'test_email':

        /***Credencias */
        $host = filter_input(INPUT_POST, 'host');
        $port = filter_input(INPUT_POST, 'port');
        $username = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        test_email($host,$port,$username,$password);

        break;


    case 'send_email':
        

        $users = json_decode(filter_input(INPUT_POST, 'users'),true);
        $assunto= filter_input(INPUT_POST, 'assunto');
        $message_email=filter_input(INPUT_POST, 'mensagem_email');
        
        send_email($users,$assunto,$message_email);
    break;


    case 'terminal':

    break;


    case 'send_sms';

        /***Credencias envio*/
        $users = json_decode(filter_input(INPUT_POST, 'users'),true);
        $mensagem_sms = filter_input(INPUT_POST, 'mensagem_sms');

        send_sms($users, $mensagem_sms);

    break;


    default:
        echo json_encode(["status"=>false,"message"=>"Serviço não encontrado"]);
    break;
}







