<?php require('header.php') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Email</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Configuração</li>
            <li class="breadcrumb-item active">Email</li>
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

      <div class="card card-primary">
        <!-- form start -->
        <div class="retorno"></div>
        <form name="emailForm">

        </form>
      </div>

      <div class="card card-primary">
        <div class="card-body">
          <form name="testeForm">
            <div class="row">
              <div class="col-md-4">
                <div class="form-group">
                  <label>Email De:</label>
                  <input type="email" name="emailde" class="form-control" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label>Email Para:</label>
                  <input type="email" name="emailpara" class="form-control" required>
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label></label><br>
                  <button type="submit" class="btn btn-primary">Testar Conexão</button>
                </div>
              </div>
            </div>
          </form>
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
<script type="text/javascript" src="backend/email/script.js"></script>