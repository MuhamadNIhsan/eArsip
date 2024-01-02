  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0"><?=$heading?></h1>
			<?=$msg?>
			<?php if($errors != NULL){
				foreach($errors as $error){
					echo '<label class="alert alert-error">'.$error.'</label>';
				};
			}?>
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
            <div class="card">
              <div class="card-header">
                <h3 class="card-title"><a href="<?=site_url('docs/create')?>" class="btn btn-warning btn-block text-dark font-weight-bold">Create</a></h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive">
				<div class="row">
					<div class="col-sm-8 text-right">
						<span>Advanced Search:</span>

					</div>
					<div class="col-sm-2">
						<select class="custom-select" id="search_column">
							<option value="0">Box<option>
							<option selected value="1">Docs<option>
							<option value="2">File Name<option>
							<option value="3">Uploaded by<option>
							<option value="4">Uploaded at<option>
						</select>
					</div>
					<div class="col-sm-2">
						<input type="text" class="form-control" id="search_column_val" value=""/>						
					</div>
				</div>
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
					<th>Box</th>
                    <th>Docs Category</th>
                    <th>File Name</th>
					<th>Uploaded by</th>
					<th>Uploaded at</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
				  <?php foreach($docs as $doc):?>
				  <tr>
					<td><?=$doc->bcode?></td>
					<td><?=$doc->cname?></td>
					<td><?=$doc->fname?></td>
					<td><?=$doc->uname?></td>
					<td><?=$doc->fuploaded_at?></td>
                    <td class="text-center">
						<a href="#" id="viewFile" class="btn btn-warning text-dark" title="View Data" data-file="<?=$doc->fpath?>" data-toggle="modal" data-target="#modal-view<?=$doc->fid?>"><i class="fa fa-eye"></i></a>
						<a href="<?=site_url('docs/edit/'.$doc->fid)?>" title="Edit Data" class="btn btn-warning text-dark"><i class="fa fa-edit"></i></a>
						<?php if($this->session->userdata('level')==='0'):?>
						<a href="<?=site_url('docs/delete/'.$doc->fid)?>" title="Delete Data" class="btn btn-warning text-dark"><i class="fa fa-trash"></i></a>
						<?php endif;?>
					</td>
					<div class="modal fade" id="modal-view<?=$doc->fid?>">
						<div class="modal-dialog modal-lg">
						  <div class="modal-content">
							<div class="modal-header">
							  <h4 class="modal-title">Docs Details</h4>
							  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							  </button>
							</div>
							<?php if($doc->fpath == NULL): ?>
							<div class="modal-body">
								<h3>You haven't upload the file.</h3>
							</div>
							<?php else: ?>
							<div class="modal-body">
							<!--
								<object data="../assets/files/<?=$doc->fpath?>" type="application/pdf" width="100%" height="800px"> 
								  <p>It appears you don't have a PDF plugin for this browser.
								   No biggie... you can <a href="../assets/files/<?=$doc->fpath?>">click here to
								  download the PDF file.</a></p>  
								</object>
							-->
								<div id="viewFile"></div>
							  <div class="form-group">
								<label for="fileName">File Name</label>
								<input type="text" class="form-control" id="fileName" name="fileName" value="<?=$doc->fname?>" disabled>
							  </div>
  							  <div class="form-group">
								<label>Box Storage</label>
								<input type="text" class="form-control" id="bcode" name="bcode" value="<?=$doc->bcode?>" disabled>
							  </div>
							  <div class="form-group">
								<label>Description</label>
								<textarea class="form-control" rows="3" name="fileDesc" disabled><?=$doc->fdesc?></textarea>
							  </div>                  
							</div>
							<?php endif;?>
							<div class="modal-footer justify-content-between">
							  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
							</div>
						  </div>
						  <!-- /.modal-content -->
						</div>
						<!-- /.modal-dialog -->
					 </div>
					<!-- /.modal -->
				  </tr>
				  <?php endforeach;?>
                  </tbody>
                </table>
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
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.js"></script>
<!-- Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.1/js/bootstrap.bundle.min.js"></script>
<!-- DataTables  & Plugins -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-responsive/2.2.9/dataTables.responsive.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-responsive-bs4/2.2.9/responsive.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.1.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables.net-buttons-bs4/2.1.1/buttons.bootstrap4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.7.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.4/vfs_fonts.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.1.1/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.1.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/datatables-buttons/2.1.1/js/buttons.colVis.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/js/adminlte.min.js"></script>
<!-- Page specific script -->
<script>
	$(document).ready(function(){
		$("a#viewFile").click(function(){
			let filePath = $(this).attr('data-file');
			console.log("load the file with id" + filePath);
			let file = '<object data="../assets/files/'+ filePath +'" type="application/pdf" width="100%" height="800px"><p>It appears you do not have a PDF plugin for this browser.No biggie... you can <a href="../assets/files/'+ filePath +'">click here to download the PDF file.</a></p></object>';
			$('div#viewFile').html(file);
		});
		
		function searchByColumn(table){
			var defSearch = 0;
			$(document).on('change','#search_column',function(){
				defSearch = this.value;
				if(defSearch=='4'){
					$('#search_column_val').datepicker({ dateFormat: 'yy-mm-dd' });
				}else{
					$('#search_column_val').datepicker("destroy");
				}
			});
			$(document).on('keyup change','#search_column_val',function(){
				defSearch = $('#search_column').val();
				table.search('').columns().search('').draw();
				console.log(defSearch);
				console.log(this.value);
				table.column(defSearch).search(this.value).draw().buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
			});
		}
		var table = $('#example1').DataTable({
      "responsive": false, "lengthChange": false, "autoWidth": false,
	  "dom": '<"top"Bi>rt<"bottom"lp>',
      "buttons": [				
				{
					extend: "copy",
					exportOptions:{
						columns: ':visible'
					}
				},

				{
					extend: "csv",
					exportOptions:{
						columns: ':visible'
					}
				},
				{
					extend: "excel",
					exportOptions:{
						columns: ':visible'
					}
				},
				{
					extend: "pdf",
					exportOptions:{
						columns: ':visible'
					}
				},
				{
					extend: "print",
					exportOptions:{
						columns: ':visible'
					}
				},
				"colvis"]
    });
		searchByColumn(table);
	});
</script>
