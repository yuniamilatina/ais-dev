<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
		<ol class="breadcrumb">
			<li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/section_c/') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
			<li><span><strong>Edit Line</strong><span></a></li>
		</ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('efiling/subsection_c/update_subsection', 'class="form-horizontal"');
        ?> 

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> LINE</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <input name="INT_ID_SUB_SECTION" class="form-control" type="hidden" value="<?php echo $data->INT_ID_SUB_SECTION; ?>">
						<input name="INT_ID_SECTION" class="form-control" type="hidden" value="<?php echo $data_id_section; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Line Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_SUB_SECTION" class="form-control" maxlength="7" required type="text" value="<?php echo trim($data->CHR_SUB_SECTION); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Line Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_SUB_SECTION_DESC" class="form-control" maxlength="40" required type="text" value="<?php echo trim($data->CHR_SUB_SECTION_DESC); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('efiling/subsection_c/index/NULL' . "/" . $data_id_section, 'Cancel', 'class="btn btn-default"');
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