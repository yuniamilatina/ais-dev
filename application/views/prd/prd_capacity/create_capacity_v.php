
<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/prd/prd_capacity_c') ?>">MANAGE CAPACITY WORK CENTER</a></li>
            <li> <a href="#"><strong>CREATE CAPACITY WORK CENTER</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <?php
        if ($msg != NULL) {
            echo $msg;
        }
        ?>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-thumb-tack"></i>
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">CREATE CAPACITY & SCHEDULE WORK CENTER</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open_multipart('prd/prd_capacity_c/save_capacity', 'class="form-horizontal"');
                    ?>
                   
                   <div class="form-group">
                            <label class="col-sm-3 control-label">Dept</label>
                            <div class="col-sm-2">
                                <select name="INT_ID_DEPT" class="form-control" id="dept_to_work_center" onchange="get_data_work_center();">
                                    <?php
                                    foreach ($all_dept_prod as $row) {
                                        if (trim($row->INT_ID_DEPT) == trim($id_dept)) {
                                            ?>
                                            <option selected value="<? echo trim($row->INT_ID_DEPT); ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                        <?php } else { ?>
                                            <option value="<? echo $row->INT_ID_DEPT; ?>"><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-2">
                                <select id="work_center" name="CHR_WORK_CENTER" class="form-control">
                                    <?php
                                    foreach ($all_work_centers as $row) {
                                        if (trim($row->CHR_WORK_CENTER) == trim($work_center)) {
                                            ?>
                                            <option selected value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo trim($row->CHR_WORK_CENTER); ?>" > <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Shift</label>
                            <div class="col-sm-2" >
                                <input type="number" autocomplete="off" min="1" max="4" required name="INT_SHIFT" class="form-control" value="1">
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="col-sm-3 control-label">Capacity Prod</label>
                            <div class="col-sm-2" >
                                <input type="number" autocomplete="off" maxlength="50" required name="INT_CAPACITY_PRD" class="form-control">
                            </div>
                    </div>
                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Schedule Chute <b class="mandatory">*</b></label>
                            <div class="col-sm-2" >
                                <input type="text" style="width:80px;" autocomplete="off" pattern=".{4,4}" required name="CHR_SCHEDULE" class="form-control" placeholder="HHmm">
                            </div>
                    </div>
                    <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('prd/prd_capacity_c', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                    </div>
                        
                    <div>
                        <b class="mandatory">*</b> Format penulisan "HHmm" (ex: 0450)
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

function get_data_work_center(){
    var dept_to_work_center = document.getElementById('dept_to_work_center').value;

    $.ajax({
        async: false,
        type: "POST",
        dataType: 'json',
        url: "<?php echo site_url('prd/direct_backflush_general_c/get_work_center_by_id_dept'); ?>",
        data:  {
                INT_ID_DEPT: dept_to_work_center
                },
        success: function (json_data) {
            $("#work_center").html(json_data['data']);
        },
        error: function (request) {
            alert(request.responseText);
        }
    });
}
</script>