  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=$heading?></h1>
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
      <div class="container">
		<div class="row">
			<div class="col-sm-3"></div>
			<div class="col-sm-6">
			<?php foreach($user as $usr):?>
				<?=form_open('users/update','class="form-signin"')?>
				<?=validation_errors()?>
				<?=$msg?>	
					  <div class="form-group">
						<input type="text" class="form-control" id="uname" name="uname" value="<?=$usr->uname?>">
						<input type="hidden" class="form-control" id="uid" name="uid" value="<?=$usr->uid?>">
					  </div>
					  <div class="form-group">
						<input type="email" class="form-control" id="email" name="email" value="<?=$usr->umail?>" disabled>
					  </div>
					  <div class="form-group">
						<input type="password" class="form-control" id="pwd" name="pwd" placeholder="New Password">
					  </div>
					  <button type="submit" class="btn btn-warning btn-block text-dark font-weight-bold">Update</button>
				<?=form_close()?>
			<?php endforeach;?>
			</div>
			<div class="col-sm-3"></div>
		</div>
      </div><!--/. container-fluid -->
    </section>
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
</body>
</html>
