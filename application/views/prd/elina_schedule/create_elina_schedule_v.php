<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/prd/elina_schedule_c/"') ?>">Manage Schedule ELINA</a></li>
            <li class="active"> <a href="#"><strong>Create New Schedule ELINA</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('prd/elina_schedule_c/save_data', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>CREATE NEW SCHEDULE ELINA</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">AREA </label>
                            <div class="col-sm-2">
                                <select name="CHR_AREA" id="CHR_AREA" class="form-control" style="width:150px" required>
                                    <!-- <option value="">--Silahkan Pilih--</option> -->
                                    <option value="DL">DL</option>
                                    <option value="BP">BP</option>
                                    <option value="CC">CC</option>
                                    <option value="CD">CD</option>
                                    <option value="ST">ST</option>
                                    <option value="IN">IN</option>
                                </select>
                            </div>
                        </div>                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">TIME ORDER </label>
                            <div class="col-sm-2">
                                <input type="text"  name="CHR_TIME" id="CHR_TIME" class="form-control" required="" minlength="4" placeholder="HHmm">
                            </div>
                        </div>
                        <div class="form-group">
                                <label class="col-sm-3 control-label">FUNCTION</label>
                                <div class="col-sm-3">
                                    <select name="CHR_FUNCTION" class="form-control" style="width:150px">
                                        <option selected value="Order">Order</option>
                                        <option value="Print">Print</option>
                                    </select>
                                </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo form_close();
                                    ?>
                                    <a href="<?php echo base_url('index.php/prd/elina_schedule_c') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>
