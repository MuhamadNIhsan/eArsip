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
        <div class="row">
          <div class="col-12">
		              <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create a new user</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?=form_open('users/insert')?>
			  <?=validation_errors()?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="uname">Username</label>
                    <input type="text" class="form-control" id="uname" name="uname" placeholder="Username">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="youremail@example.com">
                  </div>
                  <div class="form-group">
                    <label for="pwd">Password</label>
                    <input type="password" class="form-control" id="pwd" name="pwd">
                  </div>
                  <div class="form-group">
                    <label for="level">User Level</label>
                    <select class="custom-select" id="level" name="level">
						<option value="">- - Choose - -</option>
						<option value="0">Superadmin</option>
						<option value="1">Admin</option>
					</select>
                  </div>
                  <div class="form-group">
                    <label for="level">User status</label>
                    <select class="custom-select" id="level" name="active_status">
						<option value="">- - Choose - -</option>
						<option value="0">Not Active</option>
						<option value="1">Active</option>
					</select>
                  </div>
					<div class="form-group">
					  <label>Group Data</label>
						  <select class="duallistbox" multiple="multiple" id="group[]" name="group[]">
							<?php foreach ($groups as $group): ?>
								<option value="<?= $group->gid ?>"><?= $group->gname ?></option>
							<?php endforeach;?>
						  </select>
					</div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-warning text-dark font-weight-bold">Create</button>
                </div>
              <?=form_close()?>
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
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.2/jquery.bootstrap-duallistbox.min.js" integrity="sha512-l/BJWUlogVoiA2Pxj3amAx2N7EW9Kv6ReWFKyJ2n6w7jAQsjXEyki2oEVsE6PuNluzS7MvlZoUydGrHMIg33lw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$('.duallistbox').bootstrapDualListbox()
</script>
