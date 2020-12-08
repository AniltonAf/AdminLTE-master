<?php

  session_start();

   if(isset($_GET['logout']) && $_GET['logout']==true){
      session_unset();
      session_destroy();
   }
   else{
    //require 'backend/enviroment/db_connection.php';
    require 'backend/enviroment/function.php';
   }
  
  if(!isset($_SESSION['caixa_monitorizacao']))  header('Location: login.php');



?>

<!DOCTYPE html>
<html lang="pt-pt">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Monitorização Gerador V1.0</title>
  <link rel="shortcut icon" href="dist/img/CaixaLogo.png" >

  <!-- MapBox  -->
<link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">


</head>
<!--<body class="hold-transition sidebar-mini layout-fixed"> -->
<body class="sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed sidebar-collapse" style="height: auto;min-height: 100%;">
<div class="wrapper">  


  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Alarme</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 novos eventos
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 novos avarias
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 4 avarias por justificar
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">Ver todas as notificações</a>
        </div>
      </li>
      <!-- Notifications Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <img src="data:image/png;base64,<?php echo $_SESSION['caixa_monitorizacao']['user']['foto']?>" style="max-height: 25px; border-radius: 50%"> 
          <?php echo $_SESSION['caixa_monitorizacao']['user']['nome']?>
        </a>
        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <i class="fas fa-user mr-2"></i> Ver Perfil
          </a>
          <div class="dropdown-divider"></div>
          <a href="?logout=true" class="dropdown-item">
            <i class="fas fa-sign-in mr-2"></i> Logout
          </a>
        </div>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index.php" class="brand-link">
      <img src="dist/img/CaixaLogo.png" alt="Caixa Logo" class="brand-image img-rounded elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Dashboard</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      
     

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="./index.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gerador v1</p>
                </a>
              </li>
              </ul>
          </li>
          <?php if(hasRoles(['utilizadores'])){?>     
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Utilizadores
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if(hasRoles(['utilizadores_utilizador'])){?>
              <li class="nav-item">
                <a href="utilizador.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Utilizadores</p>
                </a>
              </li>
              <?php }?>
              <?php if(hasRoles(['utilizadores_perfil'])){?>
              <li class="nav-item">
                <a href="perfil_utilizador.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Perfil Utilizador</p>
                </a>
              </li>
              <?php }?>
            </ul>
          </li>
         <?php }?>
          <?php if(hasRoles(['grupo'])){?> 
          <li class="nav-item">
            <a href="grupo.php" class="nav-link">
              <i class="nav-icon far fa-image"></i>
              <p>
                Grupo
              </p>
            </a>
          </li>
          <?php }?> 
          <?php if(hasRoles(['equipamentos'])){?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Equipamentos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <?php if(hasRoles(['equipamentos_gerador'])){?>
              <li class="nav-item">
                <a href="gerador.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Gerador</p>
                </a>
              </li>
              <?php }?> 
            </ul>
          </li>
          <?php }?> 
          <?php //if(hasRoles(['reporte'])){?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-users"></i>
              <p>
                Reporte
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Eventos Estados</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Alertas</p>
                </a>
              </li>
            </ul>
          </li>
          <?php //}?>
          <?php //if(hasRoles(['reporte'])){?>
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-wrench"></i>
              <p>
                Configurações
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="email.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Email</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="mqtt.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>MQTT</p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="sms.php" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>SMS</p>
                </a>
              </li>
            </ul>
          </li>
          <?php //}?>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>