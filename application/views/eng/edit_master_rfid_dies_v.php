    <aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/eng/dies_c/') ?>">Manage Master RFID Dies</a></li>
            <li><a href="#"><strong>Edit RFID Dies</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('eng/dies_c/update_master_rfid_dies', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT</strong> RFID DIES</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Part Number</label>
                            <div class="col-sm-3">
                                <input name="CHR_PART_NO" class="form-control" maxlength="12" readonly required type="text" value="<?php echo trim($data->CHR_PART_NO); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Back Number</label>
                            <div class="col-sm-2">
                                <input name="CHR_BACK_NO" autocomplete="off" class="form-control" maxlength="5" required type="text" value="<?php echo trim($data->CHR_BACK_NO); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part Marking</label>
                            <div class="col-sm-2">
                                <input name="CHR_PART_MODEL" autocomplete="off" class="form-control" maxlength="5" required type="text" value="<?php echo trim($data->CHR_PART_MODEL); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">ID Part Dies</label>
                            <div class="col-sm-2">
                                <input name="INT_ID_PART_DIES" autocomplete="off" class="form-control" maxlength="5" required type="text" value="<?php echo trim($data->INT_ID_PART_DIES); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dies Code</label>
                            <div class="col-sm-2">
                                <input name="CHR_DIES_CODE" autocomplete="off" class="form-control" maxlength="20" required type="text" value="<?php echo trim($data->CHR_DIES_CODE); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">RFID Code</label>
                            <div class="col-sm-2">
                                <input name="CHR_RFID_CODE" autocomplete="off" class="form-control" maxlength="20" required type="text" value="<?php echo trim($data->CHR_RFID_CODE); ?>">
                            </div>
                        </div>
                          
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('eng/dies_c', 'Cancel', 'class="btn btn-default"');
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