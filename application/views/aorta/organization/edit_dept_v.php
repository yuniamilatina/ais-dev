<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/aorta/master_data_c/') ?>">Manage Department</a></li>
            <li><a href="#"><strong>Edit Department</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('aorta/master_data_c/update_dept', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-sitemap"></i>
                        <span class="grid-title"><strong>EDIT</strong> DEPARTMENT</span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="DEPT" class="form-control" type="hidden" value="<?php echo $data->KODE; ?>">

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department Description</label>
                            <div class="col-sm-5">
                                <input name="DEPT_DESC" class="form-control" maxlength="40" required type="text" value="<?php echo $data->NAMA_DEP; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department Head</label>
                            <div class="col-sm-5">
                                <select name="MANAGER" id="e2" class="form-control" style="width:200px">
                                    <?php
                                    foreach ($data_manager as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->CHR_NPK; ?>"
                                        <?php
                                            if(trim($data->KADEP_NPK) == trim($isi->CHR_NPK)){
                                                echo ' selected';
                                            }
                                        ?>><?php echo $isi->CHR_NPK . ' - ' . strtoupper($isi->CHR_USERNAME); ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Group Department</label>
                            <div class="col-sm-5">
                                <select name="GROUP_DEPT" id="group" class="form-control" style="width:200px">
                                    <?php
                                    foreach ($data_groupdept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->KD_GROUP; ?>"
                                        <?php
                                            if(trim($data->KD_GROUP) == trim($isi->KD_GROUP)){
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
                            <label class="col-sm-3 control-label">Division</label>
                            <div class="col-sm-5">
                                <select name="DIVISION" id="div" class="form-control" style="width:200px">
                                    <option value="PLNT" selected>PLANT</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Min. Backdate</label>
                            <div class="col-sm-2">
                                <input name="MIN_BACKDATE" class="form-control" maxlength="4" required type="text" value="<?php echo $data->MIN_BACKDATE; ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Category OT</label>
                            <div class="col-sm-5">
                                <select name="CATEGORY[]" multiple id="e1" class="form-control" style="width:400px">
                                    <?php
                                    foreach ($data_category as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->CHR_ID_CAT; ?>"
                                        <?php
                                            $aortadb = $this->load->database("aorta", TRUE);
                                            $dept = $data->KODE;
                                            $id_cat = trim($isi->CHR_ID_CAT);
                                            $check = $aortadb->query("SELECT OT_CATEGORY FROM TM_DEP WHERE KODE = '$dept' AND OT_CATEGORY LIKE '%$id_cat%'")->num_rows();
                                            if($check > 0){
                                                echo ' selected';
                                            }
                                        ?>><?php echo $isi->CHR_ID_CAT . ' - ' . $isi->CHR_DESC_CAT; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php echo anchor('aorta/master_data_c/manage_dept', 'Cancel', 'class="btn btn-default"');
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

