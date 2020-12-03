<?php require('header.php') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!--<div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Monitorização</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Gerador</li>
          </ol>
        </div>
      </div>
    </div>
  </div>-->
  <!-- /.content-header -->

  <!-- Main content -->
  
  <section class="content"><br>
    <div class="container-fluid">

      <!-- ===============================================================================
==================== START CODE WHERE
====================================================================================-->

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-12 col-sm-6 col-md-2">
              <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-power-off"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Geradores ON</span>
                  <span class="info-box-number gerador_on">
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-12 col-sm-6 col-md-2">
              <div class="info-box">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-power-off"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Geradores OFF</span>
                  <span class="info-box-number gerador_off">
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-2">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-danger  elevation-1"><i class="fas fa-wrench"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Gerador Avariado</span>
                  <span class="info-box-number gerador_avariado"></span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix hidden-md-up"></div>

            <div class="col-12 col-sm-6 col-md-2">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info"><i class="fas fa-plug"></i></span><br>
                <div class="info-box-content">
                  <span class="info-box-text">Rede Publica</span>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="badge badge-success"><i class="fas fa-power-off"></i> <span class="rede_publica_on"></span></span>
                    </div>
                    <div class="col-sm-6">
                      <span class="badge badge-danger"><i class="fas fa-power-off"></i>  <span class="rede_publica_off"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-2">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info"><i class="fas fa-bolt"></i></span><br>
                <div class="info-box-content">
                  <span class="info-box-text">QAT</span>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="badge badge-success"><i class="fas fa-power-off"></i> <span class="qua_aut_trans_on"></span></span>
                    </div>
                    <div class="col-sm-6">
                      <span class="badge badge-danger"><i class="fas fa-power-off"></i> <span class="qua_aut_trans_off"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-6 col-md-2">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-info"><i class="fas fa-gas-pump"></i></span><br>
                <div class="info-box-content">
                  <span class="info-box-text">Nivel Baixo Combustivel</span>
                  <div class="row">
                    <div class="col-sm-6">
                      <span class="badge badge-success"><i class="fas fa-power-off"></i> <span class="low_fuel_off"></span></span>
                    </div>
                    <div class="col-sm-6">
                      <span class="badge badge-danger"><i class="fas fa-power-off"></i> <span class="low_fuel_on"></span></span>
                    </div>
                  </div>
                </div>
              </div>
            </div>





            <div class="col-12 col-sm-6 col-md-9">
              <div class="info-box mb-3" id="map" style="height: 500px;">
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
    <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
    <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />
    <script src="backend/dashboard/script.js"></script>