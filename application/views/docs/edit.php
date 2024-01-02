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
                <h3 class="card-title">Edit file</h3>
              </div>
              <!-- /.card-header -->
              <!-- form start -->
				<?php foreach($docs as $doc):?>
				<?=form_open_multipart('docs/update')?>
				<?=validation_errors()?>
				<?=$errors?>
				<?=$msg?>
                <div class="card-body">
                  <div class="form-group">
                    <label for="fileName">File Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="fileName" name="fileName" value="<?=$doc->fname?>" required>
					<input type="hidden" class="form-control" id="idFile" name="idFile" value="<?=$doc->fid?>">
                  </div>
				  <div class="form-group">
					<label>Category</label>
					<select class="custom-select" name="catFile">
						<?php foreach($categories as $cat):?>
							<option value="<?=$cat->cid ?>" <?php echo $cat->cid==$doc->cid ? 'selected':''; ?>><?=$cat->cname ?></option>
						<?php endforeach;?>
					</select>
				  </div>
				  <div class="form-group">
					<label>Box Storage</label>
					<select class="custom-select" name="boxFile">
						<?php foreach($boxes as $box):?>
							<option value="<?=$box->bcode ?>" <?php echo $box->bcode==$doc->bcode ? 'selected':''; ?>><?=$box->bcode ?></option>
						<?php endforeach;?>
					</select>
				  </div>
				  <div class="form-group">
					<label>Description</label>
					<textarea class="form-control" rows="3" name="fileDesc"><?=$doc->fdesc?></textarea>
				  </div>                  
				  <div class="form-group">
                    <label for="InputFile">File input</label>
                    <div class="input-group">
                      <div class="custom-file">
						<input type="hidden" class="custom-file-input" id="oldFile" name="oldFile" value="<?=$doc->fpath?$doc->fpath:''?>">
                        <input type="file" class="custom-file-input" id="InputFile" name="InputFile" >
                        <label class="custom-file-label" for="InputFile">Choose file</label>
                      </div>
                    </div>
					<label><?=$doc->fpath?site_url($doc->fpath):''?></label>
                  </div>
					<div class="form-group">
					  <label>Group Data</label>
						  <select class="duallistbox" multiple="multiple" id="group[]" name="group[]">
						  <?php $file_groups = explode("@",$doc->gid);?>
							<?php foreach ($groups as $group): ?>
								<option value="<?= $group->gid ?>" <?php if(array_search($group->gid,$file_groups)!=""){ echo "selected=selected";}?>><?= $group->gname ?></option>
							<?php endforeach;?>
						  </select>
					</div>
                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-warning text-dark font-weight-bold">Update</button>
                </div>
				<?=form_close()?>
				<?php endforeach;?>
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