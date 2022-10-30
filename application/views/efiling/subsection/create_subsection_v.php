<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/efiling/section_c/') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/efiling/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
            <li><span><strong>Create Line</strong></span></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('efiling/subsection_c/save_subsection' . "/" . $data_id_section, 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> LINE</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        
						<input name="INT_ID_SECTION" class="form-control" type="hidden" value="<?php echo $data_id_section; ?>">
						
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Line Initial</label>
                            <div class="col-sm-5" >
                                <input name="CHR_SUB_SECTION" id="section" class="form-control" maxlength="7" required type="text" style="width: 100px;text-transform: uppercase;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Line Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_SUB_SECTION_DESC" class="form-control" maxlength="40" required type="text">
                            </div>
                        </div>
						
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
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

