<script>
    $(document).ready(function () {
        var date = new Date();

        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });
</script>

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
            <li><a href="<?php echo base_url('index.php/prd/schedule_kanban_c/"') ?>">Manage Kanban Schedule</a></li>
            <li class="active"> <a href="#"><strong>Edit Kanban Schedule</strong></a></li>
    </section>
    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        echo form_open('prd/schedule_kanban_c/update_schedule_kanban', 'class="form-horizontal"');
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>EDIT KANBAN SCHEDULE</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <input name="INT_ID" class="form-control"  type="hidden" value="<?php echo $data->INT_ID; ?>">
                    <input name="INT_SEQUENCE_BEFORE" class="form-control"  type="hidden" value="<?php echo $data->INT_SEQUENCE; ?>">

                    <div class="grid-body">
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Sequence</label>
                            <div class="col-sm-1">
                                <input name="INT_SEQUENCE" class="form-control" autocomplete="off" onkeyup="angka(this);" maxlength="50" required type="text" value="<?php echo $data->INT_SEQUENCE; ?>">
                            </div>
                        </div>
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
                        <div id="datepairExample">
                            <div  class="form-group">
                                <label class="col-sm-3 control-label">Schedule Date</label>
                                <div class="col-sm-3">
                                    <div class="input-group" >
                                        <input name="CHR_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:150px;" value='<?php echo date('d-m-Y',strtotime($data->CHR_DATE)); ?>'>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-3 control-label">Lot Size</label>
                            <div class="col-sm-1">
                                <input name="INT_LOT_SIZE" class="form-control" autocomplete="off" onkeyup="angka(this);" maxlength="100" type="text" value='<?php echo $data->INT_LOT_SIZE; ?>'>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-5">
                                <div class="btn-group">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-check"></i> Update</button>
                                    <?php
                                    echo anchor('prd/schedule_kanban_c', 'Cancel', 'class="btn btn-default"');
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

<script >
    $('#datepairExample .time').timepicker({
        'showDuration': true,
        'timeFormat': 'G:i'
    });

    $('#datepairExample .date').datepicker({
        'format': 'dd-mm-yyyy',
        'autoclose': true
    });

    $('#datepairExample').datepair();
</script>

<script type="text/javascript" language="javascript">

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