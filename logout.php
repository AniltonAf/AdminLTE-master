<?php
// Encerrando a sessão
session_start();
session_unset();
//$_SESSION["id_user"] = "";
session_destroy();
header('location: login.php');

?>