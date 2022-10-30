
<script language="JavaScript">
    function angka(objek) {
        a = objek.value;
        b = a.replace(/[^\d]/g, "");
        c = "";
        panjang = b.length;
        j = 0;
        for (i = panjang; i > 0; i--) {
            j = j + 1;
            if (((j % 3) == 1) && (j != 1)) {
                c = b.substr(i - 1, 1) + "" + c;
            } else {
                c = b.substr(i - 1, 1) + c;
            }
        }
        objek.value = Number(c);
    }

    function Number(s) {
        while (s.substr(0, 1) == '0' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }

</script>


<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>"><span>Home</span></a></li>
            <li> <a href="<?php echo base_url('index.php/part/pos_c/manage_pos') ?>">MANAGE  POS</a></li>
            <li> <a href="#"><strong>EDIT POS</strong></a></li>
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
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT POS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open_multipart('prd/pos_c/reupload_pos', 'class="form-horizontal"');
                    ?>
                   
                   <div class="form-group">
                            <label class="col-sm-3 control-label">Dept</label>
                            <div class="col-sm-2">
                                <select name="INT_ID_DEPT" class="form-control" id="dept_to_work_center" onchange="get_data_work_center();get_data_part();">
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
                                    <select id="work_center" name="CHR_WORK_CENTER" class="form-control" onchange="get_data_part();">
                                            <?php
                                            foreach ($all_work_centers as $row) {
                                                if (trim($row->CHR_WORK_CENTER) == trim($data->CHR_WORK_CENTER)) {
                                                    ?>
                                                    <option selected value="<?php echo trim($data->CHR_WORK_CENTER); ?>" > <?php echo trim($data->CHR_WORK_CENTER); ?> </option>
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
                            <label class="col-sm-3 control-label">Part No</label>
                            <div class="col-sm-6" >
                                <select class="form-control" name="CHR_PART_NO" id="part_by_work_center" required style="width:200px;">
                                    <?php 
                                    foreach ($data_part_no as $row) {
                                        if (trim($row->CHR_PART_NO) == trim($data->CHR_PART_NO)) {
                                            ?>
                                            <option selected value="<?php echo trim($data->CHR_PART_NO); ?>" > <?php echo trim($data->CHR_PART_NO); ?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo trim($row->CHR_PART_NO); ?>" > <?php echo trim($row->CHR_PART_NO); ?> </option>
                                            <?php
                                        }
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>

                    <div class="form-group">
                            <label class="col-sm-3 control-label">Pos</label>
                            <div class="col-sm-2" >
                                <input type="text" name="CHR_POS_PRD" autocomplete="off" onkeyup="angka(this);" maxlength="50" required class="form-control" value="<?php echo $data->CHR_POS_PRD ?>">
                            </div>
                    </div>
                    
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Work Instruction</label>
                            <div class="col-sm-4">
                                <input name="CHR_IMG_FILE_NAME" id="upload" type="file" required> 
                            </div>
                    </div>
                    <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-refresh"></i> Update</button>
                                    <?php
                                    echo anchor('prd/pos_c', 'Cancel', 'class="btn btn-default"');
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

function get_data_part(){
                var work_center = document.getElementById('work_center').value;
        
                $.ajax({
                    async: false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('part/part_c/get_data_part_by_work_center'); ?>",
                    data:  {
                            CHR_WCENTER: work_center
                            },
                    success: function (json_data) {
                        $("#part_by_work_center").html(json_data['data']);
                    },
                    error: function (request) {
                        alert(request.responseText);
                    }
                });
            }
</script>