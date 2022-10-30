<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/pes/maria_elkb_c/trolley_data/"') ?>">Manage Data Trolley</a></li>
            <li class="active"> <a href="#"><strong>Create New Data Trolley</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('pes/maria_elkb_c/save_data_trolley', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-comment"></i>
                        <span class="grid-title"><strong>CREATE NEW DATA TROLLEY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">                       
                        
                       <div class="form-group">
                            <label class="col-sm-3 control-label">NOMOR TROLLEY</label>
                            <div class="col-sm-2">
                                <input type="text"  name="CHR_NO" id="CHR_NO" class="form-control" required="">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">AREA STATION </label>
                            <div class="col-sm-2">
                                <select name="CHR_AREA" class="form-control" style="width:145px" required>
                                    <option value="">--Silahkan Pilih--</option>
                                    <option value="ST">Stamping</option>
                                    <option value="IN">Injection</option>
                                    <option value="RF">Roll Forming</option>
                                    <option value="DF">Door Frame</option>
                                    <option value="DL">Door Lock</option>
                                    <option value="CC">Clucth Cover</option>
                                    <option value="CD">Clucth Disc</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo form_close();
                                    ?>
                                    <a href="<?php echo base_url('index.php/pes/maria_elkb_c/back_troll') ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
</aside>
