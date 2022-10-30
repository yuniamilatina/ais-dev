
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/inventory/temp_part_c/manage_phantom_parts') ?>"><strong>Manage Phantom Parts</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>
        <form method="post" class="form-horizontal" enctype="multipart/form-data" role="form">
            <div class="row">
                <div class="col-md-12">
                    <div class="grid">
                        <div class="grid-header">
                            <i class="fa fa-cube"></i>
                            <span class="grid-title"><strong>UPLOAD PHANTOM PARTS</strong> </span>
                            <div class="pull-right grid-tools">
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            </div>
                        </div>
                        <div class="grid-body">
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Template Upload</label>
                                <div class="col-sm-5" style="margin: 8px 0px 0px 0px;">
                                    <a href="<?php echo base_url("index.php/inventory/temp_part_c/download") ?>">Download</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-3 control-label">Upload File</label>
                                <div class="col-sm-5">
                                    <input type="file" name="upload_parts" id="import" size="20"  value="">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-sm-offset-3 col-sm-5">
                                    <div class="btn-group">
                                        <button type="submit" class="btn btn-primary" name="btn-upload" value="1"><i class="fa fa-check"></i> Upload</button>
                                        <?php
                                        echo anchor('inventory/temp_part_c/manage_phantom_parts', 'Cancel', 'class="btn btn-default"');
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