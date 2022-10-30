<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/') ?>">HOME</a></li>
            <li><a href="<?php echo base_url('index.php/raw_material/scan_out_rfid_rm_c/') ?>">Master Data User</a></li>
            <li> <a href="#"><strong>UPDATE DATA USER</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
            echo form_open_multipart('raw_material/scan_out_rfid_rm_c/update_user', 'class="form-horizontal"');
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">UPDATE DATA USER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <input name="CHR_ID" class="form-control" type="hidden" value="<?php echo $data->INT_ID; ?>">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">NPK</label>
                            <div class="col-sm-3">
                                <input name="CHR_NPK" id="CHR_NPK" class="form-control" type="text" value="<?php echo $data->CHR_NPK; ?>" readonly >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Name</label>
                            <div class="col-sm-3">
                                <input name="CHR_NPK" id="CHR_NPK" class="form-control" type="text" value="<?php echo $data->CHR_NAME; ?>" readonly >
                            </div>
                        </div>      
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-3">
                                <select name="CHR_DEPT" id="e1" class="form-control" >
                                    <option value="<?php echo $data->CHR_DEPT; ?>"><?php echo $data->CHR_DEPT; ?></option>
                                    <option value="">- Silahkan Pilih -</option>
                                    <option value="PRD">Production</option>
                                    <option value="QUAR">Quality-Rec</option>
                                </select>
                            </div>
                        </div>                
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Line</label>
                            <div class="col-sm-3">
                                <select name="CHR_LINE" id="e2" class="form-control" >
                                    <?php
                                        foreach ($data_line as $isi) {
                                            if (trim($data->CHR_LINE) == trim($isi->CHR_WORK_CENTER)) {
                                                ?>
                                            <option selected value="<?php echo $isi->CHR_WORK_CENTER; ?>"><?php echo $isi->CHR_WORK_CENTER; ?></option>
                                            <?php
                                        } else {
                                            ?><option value="<?php echo $isi->CHR_WORK_CENTER; ?>"><?php echo $isi->CHR_WORK_CENTER; ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div> 
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('raw_material/scan_out_rfid_rm_c/', 'Cancel', 'class="btn btn-default"');
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
<script type="text/javascript" language="javascript">
        $("#upload").fileinput({
            'showUpload': false
        });
</script>
