<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php  echo base_url('index.php/basis/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/aorta/master_employee_c/"') ?>">Manage Employee</a></li>            
            <li><a href="#"><strong>Edit Employee</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('aorta/master_employee_c/update_employee', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-pencil"></i>
                        <span class="grid-title"><strong>EDIT</strong> EMPLOYEE</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="NPK" class="form-control" required type="hidden" value="<?php echo $data->NPK; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-5">
                                <input name="NAME" class="form-control" required type="text" style="width: 400px;text-transform: uppercase;" value="<?php echo trim($data->NAMA); ?>">
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Group</label>
                            <div class="col-sm-5">
                                <select name="GROUP" id="dept" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_group as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->KD_GROUP; ?>"
                                        <?php
                                        if($data->KD_GROUP == $isi->KD_GROUP){
                                            echo ' selected';
                                        }
                                        ?>><?php echo $isi->KD_GROUP; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-5">
                                <select name="DEPT" id="dept" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->KODE; ?>"
                                        <?php
                                        if($data->KD_DEPT == $isi->KODE){
                                            echo ' selected';
                                        }
                                        ?>><?php echo $isi->KODE . ' - ' . $isi->NAMA_DEP; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Section</label>
                            <div class="col-sm-5">
                                <select name="SECTION" id="section" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_sect as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->KODE; ?>"
                                        <?php
                                        if($data->KD_SECTION == $isi->KODE){
                                            echo ' selected';
                                        }
                                        ?>><?php echo $isi->KODE . ' - ' . $isi->NAMA_SECTION; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sub Section</label>
                            <div class="col-sm-5">
                                <select name="SUBSECTION" id="subsection" class="form-control" style="width:400px">
                                    <option value="-">-</option>
                                    <?php
                                    foreach ($data_subsect as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->KODE; ?>"
                                        <?php
                                        if($data->KD_SUB_SECTION == $isi->KODE){
                                            echo ' selected';
                                        }
                                        ?>><?php echo $isi->KODE . ' - ' . $isi->NAMA_SUBSECT; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Update this data"><i class="fa fa-refresh"></i> Update</button>
                                    <?php echo anchor('aorta/master_employee_c', 'Cancel', 'class="btn btn-default" data-toggle="tooltip" data-placement="right" title="Back to manage"'); 
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