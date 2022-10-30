<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/scan_out_rfid_rm_c/') ?>">MASTER DATA USER</a></li>
            <li><a href="#"><strong>Create Employee</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php

        echo form_open('raw_material/scan_out_rfid_rm_c/save_user', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>CREATE EMPLOYEE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div id="dept" class="form-group">
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-3">
                                <select name="CHR_DEPT" class="form-control">
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="PRD">Production</option>
                                    <option value="QUA">Quality</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NPK</label>
                            <div class="col-sm-2">
                                <select name="CHR_NPK" id="e1" class="form-control">
                                    <option selected="true" value="">--Pilih NPK--</option>
                                    <?php
                                    foreach ($data_npk as $isi) {
                                    ?>
                                        <option value="<?php echo $isi->CHR_NPK; ?>"><?php echo $isi->CHR_NPK; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <!-- <div id="dept" class="form-group" >
                            <label class="col-sm-3 control-label">Line</label>
                            <div class="col-sm-2">
                                <select name="CHR_LINE" id="e2" class="form-control">
                                    <option selected="true" value="">--Pilih Line--</option>
                                    <?php
                                    foreach ($data_line as $isi) {
                                    ?>
                                        <option value="<?php echo $isi->CHR_WORK_CENTER; ?>"><?php echo $isi->CHR_WORK_CENTER; ?></option>
                                        <?php
                                    }
                                        ?> 
                                </select>
                            </div>
                        </div> -->
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('raw_material/scan_out_rfid_rm_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
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