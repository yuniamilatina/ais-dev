
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">Home</a></li>
            <li> <a href="#"><strong>Reset User</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('basis/user_c/reset_user', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-user"></i>
                        <span class="grid-title"><strong>RESET USER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="CHR_REGIS_DATE" class="form-control" type="hidden" value="<?php echo $data_reset->CHR_REGIS_DATE; ?>">
                        <input name="CHR_PASS" class="form-control" type="hidden" value="<?php echo $data_reset->CHR_PASS; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">NPK</label>
                            <div class="col-sm-5">
                            <select id="e1" name="CHR_NPK" class="form-control" style="width:150px;">
                                <?php foreach ($data_user as $row) { ?>
                                    <option value="<?php echo trim($row->CHR_NPK); ?>" > <?php echo trim($row->CHR_NPK); ?> </option>
                                <?php } ?>
                            </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Reset this data"><i class="fa fa-refresh"></i> Reset</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php
        echo form_close();
        ?>

    </section>
</aside>
