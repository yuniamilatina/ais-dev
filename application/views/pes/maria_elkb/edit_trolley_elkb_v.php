
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/pes/maria_elkb_c/trolley_data/"') ?>">Manage Data Trolley</a></li>
            <li><a href=""><strong>Edit Data Trolley</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('pes/maria_elkb_c/update_dt_trolley', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-ticket"></i>
                        <span class="grid-title"><strong>EDIT STATUS AKTIF TROLLEY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Trolley ID</label>
                            <div class="col-sm-3">
                                <input name="CHR_TROLL" class="form-control" readonly="" type="text" value="<?php echo $data->CHR_TROLLEY_ID; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Area</label>
                            <div class="col-sm-3">
                                <input name="CHR_AREA" class="form-control" readonly="" type="text" value="<?php echo $data->CHR_AREA; ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Status Aktif (*Ubah Jadi T)</label>
                            <div class="col-sm-3">
                                <input name="CHR_FLAG" class="form-control" value="<?php echo trim($data->CHR_FLAG_STATUS) ?>"  required type="text">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-3">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('pes/maria_elkb_c/back_troll', 'Cancel', 'class="btn btn-default"');
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