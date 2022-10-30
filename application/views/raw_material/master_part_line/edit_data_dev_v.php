
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/master_line_part_c/"') ?>"><strong>Master Data Inspection Device</strong></a></li>
            <li><a href=""><strong>Edit Inspection Device</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('raw_material/master_line_part_c/update_dt_dev', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-ticket"></i>
                        <span class="grid-title"><strong>EDIT STATUS AKTIF DEVICE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <input name="CHR_ID" class="form-control" type="hidden" value="<?php echo $data->INT_ID; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Device ID</label>
                            <div class="col-sm-3">
                                <input name="CHR_DEV_ID" class="form-control" readonly="" type="text" value="<?php echo $data->CHR_DEVICE_ID; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Device Name</label>
                            <div class="col-sm-3">
                                <input name="CHR_DEV_NM" class="form-control"  type="text" value="<?php echo $data->CHR_DEVICE_NAME; ?>">
                            </div>
                        </div>
                        <!--<div class="form-group">
                            <label class="col-sm-3 control-label">Line</label>
                            <div class="col-sm-3">
                                <select name="CHR_LINE" id="e2" class="form-control">
                                    <?php
                                    foreach ($data_line as $isi) {
                                        if ($data->CHR_LINE == $isi->CHR_WCENTER) {
                                            ?>
                                            <option selected value="<?php echo $isi->CHR_WCENTER; ?>"><?php echo $isi->CHR_WCENTER; ?></option>
                                            <?php
                                        } else {
                                            ?><option value="<?php echo $isi->CHR_WCENTER; ?>"><?php echo $isi->CHR_WCENTER; ?></option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>-->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Callibration Date</label>
                            <div class="col-sm-3">
                                <div class="input-group" >
                                    <input name="CHR_CAL_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="<?php echo date("d-m-Y", strtotime($data->CHR_CALBR_DATE)); ?>">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('raw_material/master_line_part_c', 'Cancel', 'class="btn btn-default"');
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