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
