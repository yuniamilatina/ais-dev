<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/section_c/"') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
            <li><a href="<?php echo base_url('index.php/edoc/pos_c/index/NULL' . "/" . $data_id_subsection) ?>"><span><?php echo $data_name_subsection;?></span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/doc_c/index/NULL' . "/" . $data_id_pos) ?>"><span>Pos <?php echo $data_number_pos;?></span></a></li>
            <li><span><strong>Create Doc</strong></span></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
		if ($msg != NULL && $msg != "NULL") {
            echo $msg;
        }
		?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> DOC</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <form method="POST" action="<?php echo site_url("edoc/doc_c/save_doc" . "/" . $data_id_pos) ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
							<input name="INT_ID_POS" class="form-control" type="hidden" value="<?php echo $data_id_pos; ?>">
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Document Name</label>
								<div class="col-sm-5">
									<select name="INT_ID_DOC" class="form-control">
										<?php
										foreach ($data_doc as $isi) {
											?>
											<option value="<?php echo $isi->INT_ID_DOC; ?>"><?php echo $isi->CHR_DOC_TITLE; ?></option>
											<?php
										}
										?> 
									</select>
									<button id="signin_button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModalNorm">
										Launch Normal Form
									</button>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Select File</label>
								<div class="col-sm-5">
									<input type="file" id="import" name="import" size="20"  value="">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-5">
									<div class="btn-group">
										<button type="submit" value="1" name="btn_submit" id="add-feedback" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
										<?php
										echo anchor('edoc/doc_c/index/NULL' . "/" . $data_id_pos, 'Cancel', 'class="btn btn-default"');
										echo form_close();
										?>
									</div>
								</div>
							</div>
							
							<!-- Modal -->
							<div class="modal fade" id="myModalNorm" tabindex="-1" role="dialog" 
								 aria-labelledby="myModalLabel" aria-hidden="true">
								<div class="modal-dialog">
									<div class="modal-content">
										<!-- Modal Header -->
										<div class="modal-header">
											<button type="button" class="close" 
											   data-dismiss="modal">
												   <span aria-hidden="true">&times;</span>
												   <span class="sr-only">Close</span>
											</button>
											<h4 class="modal-title" id="myModalLabel">
												Modal title
											</h4>
										</div>
										
										<!-- Modal Body -->
										<div class="modal-body">
											
											<form role="form">
											  <div class="form-group">
												<label for="exampleInputEmail1">Email address</label>
												  <input type="email" class="form-control"
												  id="exampleInputEmail1" placeholder="Enter email"/>
											  </div>
											  <div class="form-group">
												<label for="exampleInputPassword1">Password</label>
												  <input type="password" class="form-control"
													  id="exampleInputPassword1" placeholder="Password"/>
											  </div>
											  <div class="checkbox">
												<label>
													<input type="checkbox"/> Check me out
												</label>
											  </div>
											  <button type="submit" class="btn btn-default">Submit</button>
											</form>
											
											
										</div>
										
										<!-- Modal Footer -->
										<div class="modal-footer">
											<button type="button" class="btn btn-default"
													data-dismiss="modal">
														Close
											</button>
											<button type="button" class="btn btn-primary">
												Save changes
											</button>
										</div>
									</div>
								</div>
							</div>
						</form>
                    </div>
                </div>
            </div>
        </div>
		
		
		
		<script type="text/javascript" language="javascript">
			$("#import").fileinput({
				'showUpload': false
			});

			$("#signin_button").click(function (e) {
			  e.preventDefault();
			  // code
			}
		</script>
    </section>
</aside>

