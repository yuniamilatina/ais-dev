<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/master_line_part_c"') ?>"><strong>Master Data Inspection Device</strong></a></li>
            <li class="active"> <a href="#"><strong>Create New Device</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        
        echo form_open_multipart('raw_material/master_line_part_c/save_device', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>CREATE NEW DEVICE</strong></span>
                        <!--<div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>-->
                    </div>
                    <div class="grid-body">    
                        <!-- <div class="form-group">
                            <label class="col-sm-3 control-label">Device ID</label>
                            <div class="col-sm-3">
                                <input type="text"  name="CHR_DEV_ID" id="CHR_DEV_ID" class="form-control" >
                            </div>
                        </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Device Name</label>
                            <div class="col-sm-3">
                                <input type="text"  name="CHR_DEV_NM" id="CHR_DEV_NM" class="form-control" >
                            </div>
                        </div>
                        <!--<div class="form-group" >
                            <label class="col-sm-3 control-label">Line</label>
                            <div class="col-sm-2">
                                <select  name="CHR_LINE" id="e2" class="form-control" >
                                        <option value="">--- Pilih Line  ---</option>
                                        <?php foreach ($data_line as $list) { ?>
                                            <option value="<?php echo trim($list->CHR_WCENTER); ?>"><?php echo trim($list->CHR_WCENTER); ?></option>
                                        <?php }
                                        ?> 
                                    </select>
                            </div>
                        </div>-->
                        <div  class="form-group">
                            <label class="col-sm-3 control-label">Callibration Date</label>
                            <div class="col-sm-3">
                                <div class="input-group" >
                                    <input name="CHR_CAL_DATE" id="datepicker1" class="form-control" autocomplete="off"  type="text" style="width:200px;" value="">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('raw_material/master_line_part_c', 'Back', 'class="btn btn-default"');
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
