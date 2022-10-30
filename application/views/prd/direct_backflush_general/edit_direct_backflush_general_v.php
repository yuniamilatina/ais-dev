
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
            <li> <a href="<?php echo base_url('index.php/part/direct_backflush_general_c/manage_direct_backflush_general') ?>">MANAGE POS</a></li>
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
                        <span class="grid-title" id="stat-create2"><strong id="stat-create">EDIT</strong> ROTATION KANBAN </span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse" id="collapse-header"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php
                    echo form_open('prd/direct_backflush_general_c/get_data_direct_backflush_general', 'class="form-horizontal"');
                    ?>
                   
                   <div class="form-group">
                            <label class="col-sm-3 control-label">Department</label>
                            <div class="col-sm-2">
                                <select name="INT_ID_DEPT" class="form-control" id="dept_to_work_center">
                                <?php
                                    foreach ($dept as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->CHR_DEPT; ?>"><?php echo $isi->CHR_DEPT; ?></option>
                                        <?php
                                    }
                                    ?> 
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Work Center</label>
                            <div class="col-sm-2">
                                <input name="CHR_WCENTER" autocomplete="off" class="form-control" maxlength="5" required type="text" value="<?php echo trim($data->CHR_WCENTER); ?>">
                            </div>
                        </div>
                        
                    <div class="form-group">
                            <label class="col-sm-3 control-label">Rotation Kanban (m)</label>
                            <div class="col-sm-2" >
                                <input type="text" autocomplete="off" onkeyup="angka(this);" maxlength="50" required name="CHR_ROTATION KANBAN_PRD" required class="form-control">
                            </div>
                    </div>

                    <div class="form-group">
                            <label class="col-sm-3 control-label">Status</label>
                            <div class="col-sm-2" >
                            <select name="TYPE_ACTIVE" class="form-control" id="dept_to_work_center">
                                <?php
                                    foreach ($active_machine as $isi) {
                                        ?>
                                        <option value="<?php echo $isi->TYPE_ACTIVE; ?>"><?php echo $isi->TYPE_ACTIVE; ?></option>
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
                                    <?php
                                    echo anchor('prd/direct_backflush_general_c', 'Cancel', 'class="btn btn-default"');
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