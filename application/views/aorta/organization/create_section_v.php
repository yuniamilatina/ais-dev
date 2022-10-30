<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/aorta/master_data_c/manage_section') ?>">Manage Section</a></li>
            <li><a href="#"><strong>Create Section</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        
        if ($msg != NULL) {
            echo $msg;
        }
        echo form_open('aorta/master_data_c/save_section', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong>CREATE</strong> SECTION</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Code</label>
                            <div class="col-sm-5">
                                <input name="SECTION" class="form-control" minlength="2" maxlength="4" required type="text" style="width: 80px;text-transform: uppercase;">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Description</label>
                            <div class="col-sm-5">
                                <input name="SECTION_DESC" class="form-control" maxlength="40" required type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section Head</label>
                            <div class="col-sm-5">
                                <select name="SECTHEAD" id="secthead" class="form-control" style="width:200px">
                                    <?php
                                    foreach ($data_secthead as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->CHR_NPK; ?>"><?php echo $isi->CHR_NPK . ' - ' . strtoupper($isi->CHR_USERNAME); ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-5">
                                <select name="DEPT" id="dept" class="form-control" style="width:200px">
                                    <?php
                                    foreach ($data_dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->KODE; ?>"><?php echo $isi->KODE . ' - ' . $isi->NAMA_DEP; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php echo anchor('aorta/master_data_c/manage_section', 'Cancel', 'class="btn btn-default"');
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

