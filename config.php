<?php  
require('header.php');
//require('backend/enviroment/function.php');

//if(!hasRoles(['grupo','grupo_adicionar'])){
//  echo "<script> window.location.href='./404.php'; </script>";
//}

?>
  <style type="text/css">
    .btn-action{
      margin:0px 5px 0px 0px;
      font-size: 10px
    }
  </style>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Configurações</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Configurações</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

<!-- ===============================================================================
==================== START CODE WHERE
====================================================================================-->

            <div class="row">
              <div class="col-md-12">
                <div class="card card-primary card-outline">
                  <div class="card-header">
                    <h3 class="card-title">
                      <i class="fas fa-edit"></i>
                      Configurações
                    </h3>
                  </div>
                  <div class="card-body">
                    <button type="button" class="btn btn-lg btn-block btn-default" id="btnmqtt" data-toggle="modal" data-target="#modal-default">Configurar MQTT</button>
                    <button type="button" class="btn btn-lg btn-block btn-default" id="btnemail" data-toggle="modal" data-target="#modal-primary">Configurar E-mail</button>
                  </div>
                </div>
                  <!-- /.card -->
              </div>               
                 <!-- /.card -->
            </div>




<!-- ===============================================================================
==================== END CODE WHERE
====================================================================================-->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>

<?php require('footer.php'); ?>

<script type="text/javascript" src="backend/config/script.js"></script>


