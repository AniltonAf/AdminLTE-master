<?php require('header.php') ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Monitorização</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Gerador</li>
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

      <!-- Main content -->
      <section class="content">
        <div class="container-fluid">
          <!-- Info boxes -->
          <div class="row">
            <div class="col-12 col-sm-6 col-md-2">
              <div class="info-box">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-play"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Geradores ON</span>
                  <span class="info-box-number">
                    10
                    <small>%</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <div class="col-12 col-sm-6 col-md-2">
              <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-stop"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Geradores OFF</span>
                  <span class="info-box-number">
                    10
                    <small>%</small>
                  </span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>

            <!-- /.col -->
            <div class="col-12 col-sm-6 col-md-2">
              <div class="info-box mb-3">
                <span class="info-box-icon bg-warning  elevation-1"><i class="fas fa-warning"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Avarias Gerador</span>
                  <span class="info-box-number">41,410</span>
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
                <span class="info-box-icon bg-warning  elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                  <span class="info-box-text">Avarias Rede Publica</span>
                  <span class="info-box-number">760</span>
                </div>
                <!-- /.info-box-content -->
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <script src="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.js"></script>
            <link href="https://api.mapbox.com/mapbox-gl-js/v1.12.0/mapbox-gl.css" rel="stylesheet" />



            <div class="col-12 col-sm-6 col-md-9">
              <div class="info-box mb-3" id="map" style="height: 600px;">
                <script>
                  // TO MAKE THE MAP APPEAR YOU MUST
                  // ADD YOUR ACCESS TOKEN FROM
                  // https://account.mapbox.com
                  mapboxgl.accessToken = 'pk.eyJ1IjoiaXZhbmlsZG9lZSIsImEiOiJja2hmYWwxcWkwYWptMnhwYzk2c3lmNWJxIn0.MG7-GSqPrk3JCepjLMSB9Q';
                  var map = new mapboxgl.Map({
                    container: 'map', // container id
                    style: 'mapbox://styles/mapbox/streets-v11', // style URL
                    center: [-23.664849, 15.882756], // starting position [lng, lat]
                    zoom: 7 // starting zoom
                  });
                  var marker = new mapboxgl.Marker()
                    .setLngLat([-23.664849, 15.882756])
                    .addTo(map)
                </script>
              </div>
              <!-- /.info-box -->
            </div>
            <!-- /.footer -->
            <!-- /.card -->












            <!-- ===============================================================================
==================== END CODE WHERE
====================================================================================-->

            <!-- /.row (main row) -->
          </div><!-- /.container-fluid -->
      </section>
      <!-- /.content -->
    </div>

    <?php require('footer.php'); ?>