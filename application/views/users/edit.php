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
                <h3 class="card-title">Edit user</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
              <?=form_open('users/update_auth')?>
			  <?=validation_errors()?>
			  <?php foreach($users as $user):?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="uname">Username</label>
                    <input type="text" class="form-control" id="uname" name="uname" value="<?=$user->uname?>">
					<input type="hidden" class="form-control" id="uid" name="uid" value="<?=$user->uid?>">
                  </div>
                  <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" class="form-control" id="email" name="email" value="<?=$user->umail?>">
                  </div>
                  <div class="form-group">
                    <label for="pwd">Password</label>
                    <input type="password" class="form-control" id="pwd" name="pwd">
                  </div>
                  <div class="form-group">
                    <label for="level">User Level</label>
                    <select class="custom-select" id="level" name="level">
						<option value="">- - Choose - -</option>
						<option value="0"<?=$user->ulevel == '0'? 'selected':''?>>Superadmin</option>
						<option value="1"<?=$user->ulevel == '1'? 'selected':''?>>Admin</option>
					</select>
                  </div>
                  <div class="form-group">
                    <label for="level">User status</label>
                    <select class="custom-select" id="level" name="active_status">
						<option value="">- - Choose - -</option>
						<option value="0"<?=$user->uis_active == '0'? 'selected':''?>>Not Active</option>
						<option value="1"<?=$user->uis_active == '1'? 'selected':''?>>Active</option>
					</select>
                  </div>
					<div class="form-group">
					  <label>Group Data</label>
						  <select class="duallistbox" multiple="multiple" id="group[]" name="group[]">
						  <?php $user_groups = explode("@",$user->gid);?>
							<?php foreach ($groups as $group): ?>
								<option value="<?= $group->gid ?>" <?php if(array_search($group->gid,$user_groups)!=""){ echo "selected=selected";}?>><?= $group->gname ?></option>
							<?php endforeach;?>
						  </select>
					</div>
                </div>
				<?php endforeach;?>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-warning text-dark font-weight-bold">Update</button>
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
