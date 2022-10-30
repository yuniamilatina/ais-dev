<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/patricia/master_spec_part_c/capacity_line') ?>">MANAGE CAPACITY LINE</a></li>
            <li> <a href="#"><strong>CREATE CAPACITY LINE</strong></a></li>
        </ol>
    </section>
    <section class="content">

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE CAPACITY LINE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php
                        echo form_open_multipart('patricia/master_spec_part_c/save_capacity', 'class="form-horizontal"');
                        ?>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center </label>
                            <div class="col-sm-2">
                                <select name="CHR_LINE" id="e2" class="form-control" required>
                                    <option value="">--- Pilih Line ---</option>
                                    <?php foreach ($data_line as $list) { ?>
                                        <option value="<?php echo trim($list->CHR_WCENTER); ?>"><?php echo trim($list->CHR_WCENTER); ?></option>
                                    <?php }
                                    ?>
                                </select>
                            </div>
                            <!-- <input name="CHR_DEPT" class="form-control" type="hidden" value="<?php echo $id_dept; ?>"> -->
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Capacity Per Day</label>
                            <div class="col-sm-2">
                                <input type="text" name="CHR_CAPACITY" required class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('patricia/master_spec_part_c/capacity_line/', 'Cancel', 'class="btn btn-default"');
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