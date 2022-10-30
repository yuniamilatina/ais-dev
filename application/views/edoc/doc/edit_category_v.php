<aside class="right-side">
    <section class="content-header">
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><span><strong>Edit Time</strong></span></li>
		</ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('edoc/doc_c/update_category', 'class="form-horizontal"');
        ?> 

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> TIME</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
						
						<input name="INT_ID_DOC" class="form-control" type="hidden" value="<?php echo $data->INT_ID_DOC; ?>">
						
						<fieldset disabled>
							<div class="form-group">
								<label class="col-sm-3 control-label">Document Name</label>
								<div class="col-sm-5">
									<input type="text" id="disabledTextInput" class="form-control" value="<?php echo $data->CHR_DOC_TITLE; ?>">
								</div>
							</div>
						</fieldset>

                        <div class="form-group">
								<label class="col-sm-3 control-label">Display Time</label>
								<div class="col-sm-5">
									<input name="INT_DOC_HOUR" type="number" style="width: 40px;" value = "<?php echo $data->INT_DOC_HOUR; ?>"> hour
									<input name="INT_DOC_MINUTE" type="number" min="0" max="59" style="width: 40px;" value = "<?php echo $data->INT_DOC_MINUTE; ?>"> minute     
									<input name="INT_DOC_SECOND" type="number" min="0" max="59" style="width: 40px;" value = "<?php echo $data->INT_DOC_SECOND; ?>"> second
								</div>
							</div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('edoc/setting_display_c/index', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>