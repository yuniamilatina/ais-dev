<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/patricia/master_spec_part_c/main_routing') ?>">MANAGE MAIN ROUTING</a></li>
            <li> <a href="#"><strong>EDIT MAIN ROUTING</strong></a></li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT MAIN ROUTING</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php
                        echo form_open_multipart('patricia/master_spec_part_c/update_route', 'class="form-horizontal"');
                        ?>
                        <input name="CHR_PART_NO" class="form-control" required type="hidden" value="<?php echo $data->CHR_PART_NO; ?>">
                        <input name="CHR_PV" class="form-control" required type="hidden" value="<?php echo $data->CHR_PV; ?>">
                        <!-- <div class="form-group">
                        <label class="col-sm-3 control-label">Parameter Description</label>
                            <div class="col-sm-6">
                                <textarea name="CHR_PARAMS_DESC" rows="5" cols="500" required class="form-control"  maxlength="500"><?php echo trim($data->CHR_PARAMETER) ?></textarea>
                            </div>
                                
                    </div> -->
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status Routing Utama (*Ganti T)</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_STATUS" required class="form-control" value="<?php echo $data->CHR_MAIN_STATUS ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('patricia/master_spec_part_c/main_routing', 'Cancel', 'class="btn btn-default"');
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