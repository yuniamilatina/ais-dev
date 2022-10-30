<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/master_data_c/manage_dept') ?>">Manage Department</a></li>
            <li><a href="#"><strong>View Department</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('aorta/master_data_c/view_dept', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title">VIEW DETAIL <strong><?php echo $data->KODE; ?></strong> DEPARTMENT</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department Code</label>
                            <div class="col-sm-5">
                                <input name="DEPT" class="form-control" maxlength="4" required type="text" style="width: 80px;text-transform: uppercase;" value="<?php echo $data->KODE; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department Description</label>
                            <div class="col-sm-5">
                                <input name="DEPT_DESC" class="form-control" maxlength="40" required type="text" value="<?php echo $data->NAMA_DEP; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department Head</label>
                            <div class="col-sm-5">
                                <?php
                                    $npk = trim($data->KADEP_NPK);
                                    $manager = $this->db->query("SELECT CHR_USERNAME FROM TM_USER WHERE CHR_NPK = '$npk'")->row();
                                    $man_name = '';
                                    if(count($manager) > 0){
                                        $man_name = $manager->CHR_USERNAME;
                                    }
                                ?>
                                <select name="MANAGER" id="manager" class="form-control" style="width:300px">
                                    <option value="<?php echo $data->KADEP_NPK; ?>"><?php echo $data->KADEP_NPK . ' - ' . $man_name; ?></option>                                        
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Group Department</label>
                            <div class="col-sm-5">
                                <select name="GROUP_DEPT" id="source" class="form-control" style="width:200px">
                                    <option value="<?php echo $data->KD_GROUP; ?>"><?php echo $data->KD_GROUP; ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Division</label>
                            <div class="col-sm-5">
                                <select name="DIVISION" id="source" class="form-control" style="width:200px">
                                    <option value="PLNT">PLANT</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Category OT</label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" value="<?php echo $data->OT_CATEGORY; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <?php 
                                        echo anchor('aorta/master_data_c/manage_dept', 'Back', 'class="btn btn-default"');
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

