<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/samanta/spare_parts_rack_c_2') ?>">Manage Rack Spare Part</a></li>
            <li><a href="#"><strong>Edit Rack</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-gear"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT</strong> RACK SPARE PART</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>                    
                    <div class="grid-body">
                    <?php echo form_open_multipart('samanta/spare_parts_rack_c_2/update_rack', 'class="form-horizontal"'); ?>                        
                        <input name="INT_ID" class="form-control" type="hidden" value="<?php echo $data->INT_ID; ?>">
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Spare Part No</label>
                            <div class="col-sm-3">
                                <input name="CHR_PART_NO" autofocus class="form-control" maxlength="15" type="text" autocomplete="off" required value="<?php echo trim($data->CHR_PART_NO); ?>" disabled>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">Rack</label>
                            <div class="col-sm-3">
                                <input name="CHR_RACK_NO" class="form-control" maxlength="30" required type="text" autocomplete="off" value="<?php echo trim($data->CHR_RACK_NO); ?>">
                            </div>
                        </div>
                        <br>
                        <div class="form-group">
                            <div class="col-sm-offset-4 col-sm-5">
                                <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                <?php
                                echo anchor('samanta/spare_parts_rack_c_2/', 'Cancel', 'class="btn btn-default"');
                                ?>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
        </div>
        </div>
    </section>
</aside>
<script type="text/javascript" language="javascript">
        $("#upload").fileinput({
            'showUpload': false
        });
</script>
