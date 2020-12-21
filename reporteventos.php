<?php  

require('header.php');
//require('backend/enviroment/function.php');
/*
if(!hasRoles(['utilizadores','utilizadores_utilizador','utilizadores_utilizador_adicionar'])){
  echo "<script> window.location.href='./404.php'; </script>";
}
*/
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
            <h1 class="m-0 text-dark">Reporte Eventos
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
             <!-- <li class="breadcrumb-item active">Utilizador</li> -->
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
            <div class="col-12">            
              <div class="card">
              <!-- /.card-header -->
              <div class="card-body">
                <table id="datatable" class="table table-bordered ">
                  <thead>
                    <tr>
                      <th>Gerador</th>
                      <th>Estado</th>
                      <th>Avaria Gerador</th>
                      <th>Rede Publica</th>
                      <th>Agência Energia</th>
                      <th>QTA</th>
                      <th>Nivel Combustivel</th>
                      <th>Ocorreu em:</th>
                    </tr>
                  </thead>
                  <tbody>
                  </tbody>
                </table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
            </div>
            <!-- /.col -->
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

<script type="text/javascript" src="backend/reporte_eventos/script.js"></script>


