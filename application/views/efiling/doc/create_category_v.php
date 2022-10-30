<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/section_c/"') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
            <li><a href="<?php echo base_url('index.php/efiling/pos_c/index/NULL' . "/" . $data_id_subsection) ?>"><span><?php echo $data_name_subsection;?></span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/doc_c/index/NULL' . "/" . $data_id_pos) ?>"><span>Pos <?php echo $data_number_pos;?></span></a></li>
            <li><a href="<?php echo base_url('index.php/efiling/doc_c/create_doc/NULL' . "/" . $data_id_pos) ?>"><span>Upload Doc</span></a></li>
			<li><span><strong>New Doc Category</strong></span></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
		?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> DOC CATEGORY</span>
                    </div>
                    <div class="grid-body">
                        <form method="POST" action="<?php echo site_url("efiling/doc_c/save_category" . "/" . $data_id_pos) ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Document Name</label>
								<div class="col-sm-5">
									<input name="CHR_DOC_TITLE" class="form-control" required type="text">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Display Time</label>
								<div class="col-sm-5">
									<input name="INT_DOC_HOUR" value="0" type="number" style="width: 40px;" required type="text"> hour
									<input name="INT_DOC_MINUTE" value="0" type="number" min="0" max="59" style="width: 40px;" required type="text"> minute     
									<input name="INT_DOC_SECOND" value="0" type="number" min="0" max="59" style="width: 40px;" required type="text"> second
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-5">
									<div class="btn-group">
										<button type="submit" value="1" name="btn_submit" id="add-feedback" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
										<?php
										echo anchor('efiling/doc_c/create_doc/NULL' . "/" . $data_id_pos, 'Cancel', 'class="btn btn-default"');
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
    </section>
</aside>

