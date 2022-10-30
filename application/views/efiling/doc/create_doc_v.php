<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/section_c/"') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
            <li><a href="<?php echo base_url('index.php/efiling/pos_c/index/NULL' . "/" . $data_id_subsection) ?>"><span><?php echo $data_name_subsection;?></span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/doc_c/index/NULL' . "/" . $data_id_pos) ?>"><span>Pos <?php echo $data_number_pos;?></span></a></li>
            <li><span><strong>Upload Doc</strong></span></li>
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
                        <span class="grid-title"><strong>UPLOAD</strong> DOC</span>
                    </div>
                    <div class="grid-body">
                        <form method="POST" action="<?php echo site_url("efiling/doc_c/save_doc" . "/" . $data_id_pos) ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
							<input name="INT_ID_POS" class="form-control" type="hidden" value="<?php echo $data_id_pos; ?>">
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Document Name</label>
								<div class="col-sm-5">
									<select name="INT_ID_DOC" class="form-control">
										<?php
										foreach ($data_doc as $isi) {
											if ($data->INT_ID_DOC == 1) {
                                            ?> 
                                            <option selected="true" value="<?php echo $isi->INT_ID_DOC; ?>"><?php echo $isi->CHR_DOC_TITLE; ?></option>
                                        <?php } else { ?>
                                            <option value="<?php echo $isi->INT_ID_DOC; ?>"><?php echo $isi->CHR_DOC_TITLE; ?></option>
                                            <?php
											}
                                        }
										?> 
									</select>
								</div>
								<div class="col-sm-4">
									<a href="<?php echo base_url('index.php/efiling/doc_c/create_category') . "/" . $data_id_pos ?>" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="New Category Document" style="height:35px;font-size:14px;width:100px;"><b>New</b></a>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Select File</label>
								<div class="col-sm-5">
									<input class="file" type="file" id="import" name="import" size="20"  value="">
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-5">
									<div class="btn-group">
										<button type="submit" value="1" name="btn_submit" id="add-feedback" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
										<?php
										echo anchor('efiling/doc_c/index/NULL' . "/" . $data_id_pos, 'Cancel', 'class="btn btn-default"');
										echo form_close();
										?>
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
		</script>
    </section>
</aside>

