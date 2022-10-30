<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/samanta/spare_parts_rack_c_2/') ?>">Manage Rack Spare Parts</a></li>
            <li><a href="#"><strong>Create New Rack</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php if ($msg != NULL) {
                echo $msg;
        } ?>
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('samanta/spare_parts_rack_c_2/save_rack', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>CREATE</strong> RACK SPARE PARTS</span>
                        <div class="pull-right">
                            <a href="#" class="btn btn-warning" data-target="#modalUploadDataRack" data-toggle="modal" data-placement="left" title="Upload massive data" style="height:35px;font-size:13px;width:150px;">Upload Data Rack</a>
                        </div>
                    </div>
                    <div class="grid-body">
                         <div class="form-group">
                            <label class="col-sm-3 control-label">Spare Part No</label>
                            <div class="col-sm-2">
                                <select  name="CHR_PART_NO" id="e1" class="form-control" style="width:400px">
                                    <?php foreach ($list_part as $list) { ?>
                                        <option value="<?php echo $list->CHR_PART_NO; ?>"><?php echo trim($list->CHR_PART_NO) . " - " . trim($list->CHR_SPECIFICATION); ?></option>
                                    <?php } ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Rack No</label>
                            <div class="col-sm-2">
                                <input name="CHR_RACK_NO" class="form-control" maxlength="10" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('samanta/spare_parts_rack_c_2', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalUploadDataRack" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form class="form-horizontal" method="post"  role="form" action="<?php echo base_url('index.php/samanta/spare_parts_rack_c/upload_data_rack_sp'); ?>"  enctype="multipart/form-data" role="form">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                <h4 class="modal-title" id="myModalLabel2">Upload Data Rack Spare Parts</h4>
                            </div>
                            <div class="modal-body" >
                                <div class="form-group" style="text-align:center;">
                                    <span style="text-align:center;"><i class="fa fa-download"></i>&nbsp;<a href="<?php echo base_url('index.php/samanta/spare_parts_rack_c/generate_template'); ?>">Download Template</a></span>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Upload File</label>
                                    <div class="col-sm-7">
                                        <input type="file" class="form-control" name="import_data" id="import_data" size="20" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal"> Close</button>
                                    <button class="btn btn-primary" value="1" name="upload_button"> Upload</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>

