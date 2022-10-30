<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/mrp/manage_mrp_c/capacity_line') ?>">MANAGE CAPACITY LINE</a></li>
            <li> <a href="#"><strong>EDIT CAPACITY LINE</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        echo form_open_multipart('mrp/manage_mrp_c/update_capacity', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT CAPACITY LINE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Line</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_LINE" readonly class="form-control" value="<?php echo $data->CHR_WORK_CENTER ?>">
                            </div>
                            <input name="CHR_ID" class="form-control" type="hidden" value="<?php echo $data->INT_ID; ?>">

                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Capacity Per Day</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_CAPACITY" required class="form-control" value="<?php echo $data->CHR_PCS_PER_DAY ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('mrp/manage_mrp_c/capacity_line/', 'Cancel', 'class="btn btn-default"');
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
<script type="text/javascript" language="javascript">
    $("#upload").fileinput({
        'showUpload': false
    });
</script>