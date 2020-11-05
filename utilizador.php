<?php  

require('header.php');
//require('backend/enviroment/function.php');

if(!hasRoles(['utilizadores','utilizadores_utilizador','utilizadores_utilizador_adicionar'])){
  echo "<script> window.location.href='./404.php'; </script>";
}

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
            <h1 class="m-0 text-dark">Utilizador
            </h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
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
                <?php if(hasRoles(['utilizadores_utilizador_adicionar'])){?>
                <button class="btn btn-sm btn-primary" id="btnAdd" style="float: left; margin-right: 40px">Adicionar</button>
                 <?php }?>
                <table id="datatable" class="table table-bordered ">
                  <thead>
                    <tr>
                      <th>Foto</th>
                      <th>Nome</th>
                      <th>Nº funcionario</th>
                      <th>Departamento</th>
                      <th>Função</th>
                      <th>E-mail</th>
                      <th>Telefone</th>
                      <th>Ações</th>
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


        <div class="modal fade" id="modalAdd">
          <div class="modal-dialog modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h4 class="modal-title">Utilizador</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                
              </div>
            </div>
          </div>
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

<script type="text/javascript" src="backend/utilizador/script.js"></script>


