<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/patricia/master_spec_part_c/ukur_part') ?>">MANAGE GROUPING PART</a></li>
            <li> <a href="#"><strong>EDIT SPEC PART</strong></a></li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT GROUPING PART</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php
                        echo form_open_multipart('patricia/master_spec_part_c/update_groupfg', 'class="form-horizontal"');
                        ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Part No</label>
                            <div class="col-sm-3">
                                <input type="text" name="CHR_POS" readonly class="form-control" value="<?php echo $data->CHR_PART_NO ?>">
                            </div>
                            <input name="CHR_ID" class="form-control" type="hidden" value="<?php echo $data->INT_ID; ?>">
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Group </label>
                            <div class="col-sm-3">
                                <select id="e1" name="CHR_GROUP" class="form-control">
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="OEM">OEM</option>
                                    <option value="AM">AM</option>
                                    <option value="GNP">GNP</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('patricia/master_spec_part_c/group_fg/', 'Cancel', 'class="btn btn-default"');
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