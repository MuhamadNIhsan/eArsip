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
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
		              <!-- general form elements -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title">Create</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
				<?=form_open_multipart('docs/insert')?>
				<?=validation_errors()?>
				<?php if($errors != NULL){
					foreach($errors as $error){
						echo '<label class="alert alert-warning">'.$error.'</label>';
					};
				}?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="fileName">File Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fileName" name="fileName" required>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                      <label for="fileStatus">Status</label>
                        <select class="custom-select" id="fileStatus" name="fileStatus">
                          <option value="1" selected>Active</option>
                          <option value="0">Inactive</option>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label for="fileExp">Exp. Date</label>
                        <input type="text" class="form-control" id="fileExp" name="fileExp">
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="row">
                      <div class="col-md-6">
                        <label>Category</label>
                        <select class="custom-select" name="catFile">
                          <?php foreach($categories as $cat):?>
                            <option value="<?=$cat->cid ?>"><?=$cat->cname ?></option>
                          <?php endforeach;?>
                        </select>
                      </div>
                      <div class="col-md-6">
                        <label>Box Storage</label>
                        <select class="custom-select" name="boxFile">
                          <?php foreach($boxes as $box):?>
                            <option value="<?=$box->bcode ?>"><?=$box->bcode ?></option>
                          <?php endforeach;?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" rows="3" name="fileDesc"></textarea>
                  </div>                  
        				  <div class="form-group">
                    <label for="InputFile">File input <span class="text-danger">*</span></label>
                    <div class="input-group">
                      <div class="custom-file">
                        <input type="file" class="custom-file-input" id="InputFile" name="InputFile" required>
                        <label class="custom-file-label" for="InputFile">Choose file</label>
                      </div>
                    </div>
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
                  <button type="submit" class="btn btn-warning text-dark font-weight-bold">Insert</button>
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
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<!-- Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap4-duallistbox/4.0.2/jquery.bootstrap-duallistbox.min.js" integrity="sha512-l/BJWUlogVoiA2Pxj3amAx2N7EW9Kv6ReWFKyJ2n6w7jAQsjXEyki2oEVsE6PuNluzS7MvlZoUydGrHMIg33lw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
$('.duallistbox').bootstrapDualListbox()
$('#fileExp').datepicker({ dateFormat: 'yy-mm-dd' });
bsCustomFileInput.init()
</script>
