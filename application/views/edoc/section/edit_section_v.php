<aside class="right-side">
    <section class="content-header">
            <ol class="breadcrumb">
                <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
                <li><a href="<?php echo base_url('index.php/edoc/section_c/') ?>">PR3</a></li>
                <li><strong>Edit Section</strong></a></li>
            </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('edoc/section_c/update_section', 'class="form-horizontal"');
        ?> 

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT</strong> SECTION</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">

                        <input name="INT_ID_SECTION" class="form-control" type="hidden" value="<?php echo $data->INT_ID_SECTION; ?>">
						<input name="INT_ID_DEPT" class="form-control" type="hidden" value="23">
						<input name="INT_ID_COST_CENTER" class="form-control" type="hidden" value="63">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Initial</label>
                            <div class="col-sm-5">
                                <input name="CHR_SECTION" class="form-control" maxlength="7" required type="text" value="<?php echo trim($data->CHR_SECTION); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Description</label>
                            <div class="col-sm-5">
                                <input name="CHR_SECTION_DESC" class="form-control" maxlength="40" required type="text" value="<?php echo trim($data->CHR_SECTION_DESC); ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('edoc/section_c', 'Cancel', 'class="btn btn-default"');
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