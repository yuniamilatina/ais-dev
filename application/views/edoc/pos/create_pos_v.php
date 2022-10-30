<aside class="right-side">
	<?php $data_name_section = explode("-", $data_name_section);?>
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/"') ?>"><span>Home</span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/section_c/"') ?>"><span>PR3</span></a></li>
			<li><a href="<?php echo base_url('index.php/edoc/subsection_c/index/NULL' . "/" . $data_id_section) ?>"><span><?php echo $data_name_section[1];?></span></a></li>
            <li><a href="<?php echo base_url('index.php/edoc/pos_c/index/NULL' . "/" . $data_id_subsection) ?>"><span><?php echo $data_name_subsection;?></span></a></li>
            <li><span><strong>Create Pos</strong></span></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('edoc/pos_c/save_pos' . "/" . $data_id_subsection, 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> POS</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        
						<input name="INT_ID_SUB_SECTION" class="form-control" type="hidden" value="<?php echo $data_id_subsection; ?>">
						
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pos Number</label>
                            <div class="col-sm-5" >
                                <input name="INT_POS_NUMBER" id="section" class="form-control" required type="text" style="width: 100px;">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Pos Title</label>
                            <div class="col-sm-5">
                                <input name="CHR_POS_TITLE" class="form-control" maxlength="40" required type="text">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('edoc/pos_c/index/NULL' . "/" . $data_id_subsection, 'Cancel', 'class="btn btn-default"');
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

