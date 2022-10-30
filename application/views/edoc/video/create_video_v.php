<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
			<li><span><strong>Upload Video</strong></span></li>
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
                        <span class="grid-title"><strong>UPLOAD</strong> VIDEO</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <form method="POST" action="<?php echo site_url("edoc/video_c/save_video") ?>" class="form-horizontal" enctype="multipart/form-data" role="form">
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Video Name</label>
								<div class="col-sm-5" >
									<input name="CHR_DOC_TITLE" class="form-control" maxlength="40" required type="text">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Select File</label>
								<div class="col-sm-5">
									<input type="file" id="import" name="import" size="20"  value="">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Display Time</label>
								<div class="col-sm-5">
									<input name="INT_DOC_HOUR" value="0" type="number" style="width: 40px;"> hour
									<input name="INT_DOC_MINUTE" value="0" type="number" min="0" max="59" style="width: 40px;"> minute     
									<input name="INT_DOC_SECOND" value="0" type="number" min="0" max="59" style="width: 40px;"> second
								</div>
							</div>

							<div class="form-group">
								<div class="col-sm-offset-3 col-sm-5">
									<div class="btn-group">
										<button type="submit" value="1" name="btn_submit" id="add-feedback" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
										<?php
										echo anchor('edoc/video_c/index/NULL', 'Cancel', 'class="btn btn-default"');
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