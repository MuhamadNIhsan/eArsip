  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=$heading?></h1>
			<?=$msg?>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
				<?=$breadcrumb?>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Info boxes -->
        <div class="row">
          <div class="col-12 col-md-4">
   		    <a href="<?=site_url('category')?>">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fa fa-archive"></i></span>
              <div class="info-box-content">
					<span class="info-box-text">Docs Category</span>
					<span class="info-box-number">
					  <?=count($categories)?>
					</span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
		    </a>
          </div>
          <!-- /.col -->
          <div class="col-12 col-md-4">
     		<a href="<?=site_url('docs')?>">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fa fa-copy"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Docs</span>
                <span class="info-box-number"><?=count($docs)?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
			</a>
          </div>
          <!-- /.col -->

          <!-- fix for small devices only -->
          <div class="clearfix hidden-md-up"></div>
          <div class="col-12 col-md-4">
		  <a href="<?=site_url('users')?>">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-warning elevation-1"><i class="fa fa-users"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Users</span>
                <span class="info-box-number"><?=count($users)?></span>
              </div>
              <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
			</a>
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->

        <div class="row">
          <div class="col-md-12">
            <!-- DONUT CHART -->
            <div class="card card-dark">
              <div class="card-header">
                <h3 class="card-title">Docs Chart</h3>

                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-card-widget="collapse">
                    <i class="fa fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove">
                    <i class="fa fa-times"></i>
                  </button>
                </div>
              </div>
              <div class="card-body">
                <canvas id="donutChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!--/. container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright &copy; 2022 Dana Pensiun CARDIG Group All right reserved. Supported by <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.1.0
    </div>
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.1/js/jquery.overlayScrollbars.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>

<!-- PAGE PLUGINS -->
<!-- ChartJS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.0/chart.min.js"></script>
<script>
  $(function () {
    /* ChartJS
     * -------
     * Here we will create a few charts using ChartJS
     */
    //-------------
    //- DONUT CHART -
    //-------------
    // Get context with jQuery - using jQuery's .get() method.
    var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
    var donutData        = {
      labels: [
			  <?php	foreach($data_chart as $dc){echo "'".$dc->cname."', ";} ?>
      ],
      datasets: [
        {
          data: [<?php	foreach($data_chart as $dc){echo "'".$dc->jml."', ";} ?>],
          backgroundColor : [<?php	foreach($data_chart as $dc){echo "'".$dc->ccolor."', ";} ?>],
        }
      ]
    }
    var donutOptions     = {
      maintainAspectRatio : false,
      responsive : true,
		plugins: {
			legend: {
				display: true,
				labels: {
					color: 'rgb(255, 99, 132)'
				}
			}
		}
	}
    //Create pie or douhnut chart
    // You can switch between pie and douhnut using the method below.
    new Chart(donutChartCanvas, {
      type: 'doughnut',
      data: donutData,
      options: donutOptions
    })

  })
</script>