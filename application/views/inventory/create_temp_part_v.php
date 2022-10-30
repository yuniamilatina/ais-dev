<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/inventory/temp_part_c"') ?>"><strong>Manage Data Temp Part</strong></a></li>
            <li class="active"> <a href="#"><strong>Create New Data</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('inventory/temp_part_c/save_data_temp', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>CREATE NEW DATA</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">                       
                        
                       <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">Nomor Temp</label>
                            <div class="col-sm-2">
                                <input type="text"  name="CHR_NO" id="CHR_NO" class="form-control" required="">
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">PIC</label>
                            <div class="col-sm-2">
                                <input type="text"  name="CHR_PIC" id="CHR_PIC" class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Dept</label>
                            <div class="col-sm-2">
                                <input type="text"  name="CHR_DEPT" id="CHR_DEPT" class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Description</label>
                            <div class="col-sm-6">
                                <textarea name="CHR_DESC" rows="5" cols="500" class="form-control" placeholder="Please detail your issue" maxlength="500"></textarea>
                            </div>
                        </div>
                        <div  class="form-group">
                            <label class="col-sm-3 control-label">Start Date</label>
                            <div class="col-sm-3">
                                <div class="input-group" >
                                    <input name="CHR_ST_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div  class="form-group">
                            <label class="col-sm-3 control-label">Finish Date</label>
                            <div class="col-sm-3">
                                <div class="input-group" >
                                    <input name="CHR_FH_DATE" id="datepicker2" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo form_close();
                                    ?>
                                    <a href="<?php echo base_url('index.php/inventory/temp_part_c') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>
