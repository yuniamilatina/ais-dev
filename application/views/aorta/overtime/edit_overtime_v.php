<script>
    $(document).ready(function () {
        var date = new Date();

        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });
</script>
<script>
    $(function () {
        //$("#datepicker").datepicker({ dateFormat: 'dd/mm/yy', maxDate: 'today'});
        //Add by bugsMaker to Preparation STO
        $("#datepicker1").datepicker({dateFormat: 'dd/mm/yy', maxDate: 'today'});
    });

    function remove_ot_by_npk(id, npk){

        var x = confirm("Are you sure you want to remove this NPK?");
        if (x)
            $.ajax({
                        async: false,
                        type: "POST",
                        dataType: 'json',
                        url: "<?php echo site_url('aorta/overtime_c/remove_npk'); ?>",
                        data:  {
                                    NO_SEQUENCE: id, 
                                    NPK: npk
                                },
                        success: function (json_data) {
                            $("#list_of_npk_overtime").html(json_data['data']);
                            if(json_data['data']){
                                $("#btn_save").prop( "disabled", false );
                                document.getElementById('datepicker1').readOnly = true;
                                document.getElementById('e2').readOnly = true;
                                document.getElementById('category_id').readOnly = true;
                                document.getElementById('reason_id').readOnly = true;
                            }else{
                                $("#btn_save").prop( "disabled", true );
                                document.getElementById('datepicker1').readOnly = false;
                                document.getElementById('e2').readOnly = false;
                                document.getElementById('category_id').readOnly = false;
                                document.getElementById('reason_id').readOnly = false;
                            }
                            
                        },
                        error: function (request) {
                            alert(request.responseText);
                        }
                    });
        else
            return false;
        
    }

    function save_temp_data(){
        //alert(document.getElementById('value_tgl_overtime_id').value);

        var cat_id = document.getElementById('value_category_id').value;
        var e2 = document.getElementById('value_npk_pic_id').value;
        var tgl_ot_id = document.getElementById('value_tgl_overtime_id').value;
        var shift_id = document.getElementById('value_shift_id').value;
        var alasan_id = document.getElementById('value_alasan_id').value;
        var npk_id = document.getElementById('e1').value;
        var starth = document.getElementById('value_starth').value;
        var startm = document.getElementById('value_startm').value;
        var endh = document.getElementById('value_endh').value;
        var endm = document.getElementById('value_endm').value;
        var id_ot = document.getElementById('no_sequence').value;

        if(starth > 23 || endh > 23){
            alert("jam tidak bisa lebih dari jam 23");
            return;
        }

        if(startm > 60 || endm > 60){
            alert("menit tidak bisa lebih dari jam 60");
            return;
        }

        if(alasan_id == ''){
            alert("alasan masih kosong");
            return;
        }

        if(starth == '' || startm == ''){
            alert("alasan masih kosong");
            return;
        }

        if(endh == '' || endm == ''){
            alert("alasan masih kosong");
            return;
        }

                $.ajax({
                    async: false,
                    type: "POST",
                    dataType: 'json',
                    url: "<?php echo site_url('aorta/overtime_c/save_temp_overtime'); ?>",
                    data:  {
                                TGL_OVERTIME: tgl_ot_id, 
                                NPK: npk_id,
                                KAT_OT: cat_id,
                                NPK_PIC: e2,
                                ALASAN: alasan_id,
                                START_HOUR: starth,
                                START_MINUTE: startm,
                                END_HOUR: endh,
                                END_MINUTE: endm,
                                NO_SEQUENCE: id_ot
                            },
                    success: function (json_data) {

                        $("#list_of_npk_overtime").html(json_data['data']);

                        if(json_data['msg']){
                            alert(json_data['msg']);
                        }

                        if(json_data['data']){
                            $("#btn_save").prop( "disabled", false );
                        
                            document.getElementById('datepicker1').readOnly = true;
                            document.getElementById('e2').readOnly = true;
                            document.getElementById('category_id').readOnly = true;
                            document.getElementById('reason_id').readOnly = true;

                            $("#no_sequence").val(json_data['no_sequence']);
                            $("#no_sequence_sure").val(json_data['no_sequence']);
                        }
                        
                    },
                    error: function (request) {
                        alert(request.responseText);
                    }
                });
            
    }
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
//        while (s.substr(0, 1) == '0' && s.length > 1) {
//            s = s.substr(1, 9999);
//        }
        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }

</script>
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        margin: 0 auto;
    }
    #table-luar{
        font-size: 11px;
    }
    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }
    .td-fixed{
        width: 30px;
    }
    .td-no{
        width: 10px;
    }
    .ddl{
        width: 100px;
        height: 30px;
    }
    .ddl2{
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/aorta/overtime_c/') ?>">Manage Overtime</a></li>
            <li> <a href="<?php echo base_url('index.php/aorta/overtime_c/create_overtime') ?>"><strong>Edit Overtime</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>

        <div class="row">

            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>EDIT OVERTIME</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <?php 
                        echo form_open('aorta/overtime_c/save_overtime', 'class="form-horizontal"');
                    ?>                    

                    <input type="hidden" name="NO_SEQUENCE" id="no_sequence_sure"></input> 

                    <div class="grid-body">

                        <div  class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-2">
                                <div class="input-group" >
                                    <input id="datepicker1" name="TGL_OVERTIME" class="form-control" autocomplete="off" required type="text" value="<?php echo $date; ?>" onchange="document.getElementById('value_tgl_overtime_id').value=value; ">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div  class="form-group" style="display:none;">
                            <label class="col-sm-3 control-label">Dept / Section / Sub Section</label>
                            <div class="col-sm-9">
                                <div class="input-group" >

                                    <select class="ddl" style='width:100px;'>

                                        <?php foreach ($all_dept as $row) { ?>
                                            <option value="<?php echo $row->KD_DEPT; ?>" <?php
                                            if ($dept == $row->KD_DEPT) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php echo trim($row->KD_DEPT); ?></option>
                                                <?php } ?>
                                    </select>

                                    &nbsp;&nbsp;

                                    <select class="ddl" style='width:100px;'>

                                        <?php foreach ($all_section as $row) { ?>
                                            <option value="<?php echo $row->KD_SECTION; ?>" <?php
                                            if (trim($section) == trim($row->KD_SECTION)) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php echo trim($row->KD_SECTION); ?></option>
                                                <?php } ?>
                                    </select>

                                    &nbsp;&nbsp;

                                    <select  class="ddl" style='width:100px;'>
                                        <?php foreach ($all_sub_section as $row) { ?>
                                            <option value="<?php echo $row->KD_SUB_SECTION; ?>" <?php
                                            if (trim($sub_section) == trim($row->KD_SUB_SECTION)) {
                                                echo 'SELECTED';
                                            }
                                            ?> ><?php echo trim($row->KD_SUB_SECTION); ?></option>
                                                <?php } ?>
                                    </select>

                                </div>

                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Type</label>
                                <div class="col-sm-3">
                                    <input type="radio" class="icheck" name="INT_TYPE_QUOTA"  value="0" checked> Normal &nbsp; &nbsp;
                                    <input type="radio" class="icheck" name="INT_TYPE_QUOTA"  value="1" > Improvement
                                </div>
                        </div>

                        <div  class="form-group">
                            <label class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-1">
                                <div class="input-group" >
                                    <select class="ddl" name="KAT_OT" id="category_id" style='width:200px;' onchange="document.getElementById('value_category_id').value=this.options[this.selectedIndex].value; ">
                                        <?php foreach ($all_category as $row) { ?>
                                            <option value="<?php echo $row->CHR_ID_CAT; ?>"><?php echo $row->CHR_DESC_CAT; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div  class="form-group">
                            <label class="col-sm-3 control-label">PIC</label>
                            <div class="col-sm-6">
                                <div class="input-group" >
                                    <select  id="e2" name="NPK_PIC" onchange="document.getElementById('value_npk_pic_id').value=this.options[this.selectedIndex].value; ">
                                        <?php foreach ($all_pic as $row) { ?>
                                            <option value="<?php echo $row->NPK; ?>"><?php echo $row->NPK . ' - ' . $row->NAMA; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reason</label>
                            <div class="col-sm-6">
                                <textarea rows="2" id="reason_id" name="ALASAN" cols="200" onkeyup="document.getElementById('value_alasan_id').value=value;" class="form-control" placeholder="Please detail your reason of overtime" maxlength="500" onchange="document.getElementById('value_alasan_id').value=this.options[this.selectedIndex].value; "></textarea>
                            </div>
                        </div>

                        <div class="pull-right">
                            <span style='padding-right:850px;text-decoration: underline;'></span>
                            <a data-toggle="modal" data-target="#modalPic" data-placement="left" data-toggle="tooltip" title="Add Employee" class='btn btn-success' ><span class="fa fa-plus"></span>&nbsp;&nbsp;Add Employee</a>
                        </div>

                        <div id="table-luar">
                            <table style="margin-bottom:10px;" id="dataTables31" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">PIC NPK</th>

                                        <th style="vertical-align: middle;text-align:center;" colspan="3">Planning (H)</th>
                                        <th style="vertical-align: middle;text-align:center;" colspan="3">Realization (H)</th>

                                        <!-- <th rowspan="2" style="vertical-align: middle;text-align:center;">Terpakai</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Sisa</th> -->
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Actions</th>
                                    </tr>
                                    <tr>
                                        <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Start</td>
                                        <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">End</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Start</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>End</td>
                                        <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                    </tr>
                                </thead>
                                <tbody id="list_of_npk_overtime">
                                    <tr><td colspan="9">No data available in table<td></tr>
                                </tbody>
                            </table>
                            <span >Showing 0 to 0 of 0 entries</span>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-10 text-center">
                                <div class="btn-group">
                                    <button type="submit" disabled id="btn_save" class="btn btn-primary"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('aorta/overtime_c/', 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalPic" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel1"><strong>Add Employee</strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <!-- <?php //echo form_open('aorta/overtime_c/save_temp_overtime', 'class="form-horizontal"'); ?> -->

                                            <input type="hidden" name="KAT_OT" id="value_category_id" value="<?php echo $cat_ot; ?>"></input> 
                                            <input type="hidden" name="NPK_PIC" id="value_npk_pic_id" value="<?php echo $npk_pic; ?>"></input> 
                                            <input type="hidden" name="TGL_OVERTIME" id="value_tgl_overtime_id" value="<?php echo $tgl_ot; ?>"></input> 
                                            <input type="hidden" name="SHIFT" id="value_shift_id" value="<?php echo $shift; ?>"></input> 
                                            <input type="hidden" name="ALASAN" id="value_alasan_id" value="<?php echo $alasan; ?>"></input> 
                                            <input type="hidden" name="NO_SEQUENCE" id="no_sequence"></input> 

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Name</label>
                                                <div class="col-sm-7">
                                                    <select required name="NPK" id="e1"  class="form-control" required>
                                                        <?php foreach ($all_employee as $list) { ?>
                                                            <option value="<?php echo $list->NPK; ?>"><?php echo $list->NPK . ' - ' . trim($list->NAMA); ?></option>
                                                        <?php }
                                                        ?> 
                                                    </select>
                                                </div>
                                            </div>
                                            <div  class="form-group">
                                                <label class="col-sm-3 control-label">Shift</label>
                                                <div class="col-sm-1">
                                                    <div class="input-group" >
                                                        <select class="ddl" style='width:100px;' onchange="document.getElementById('value_shift_id').value=this.options[this.selectedIndex].value; ">
                                                                <option value="1">SHIFT 1</option>
                                                                <option value="2">SHIFT 2</option>
                                                                <option value="3">SHIFT 3</option>
                                                                <option value="4">NON SHIFT</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Start</label>
                                                <div class="col-sm-1">Hour
                                                    <input name="START_HOUR" id="value_starth" autocomplete="off" onkeyup="angka(this);" class="form-control" maxlength="2" required type="text"  style="width: 40px;text-transform: uppercase;">
                                                </div>
                                                <div class="col-sm-1">Minutes
                                                    <input name="START_MINUTE" id="value_startm" autocomplete="off" onkeyup="angka(this);" class="form-control" maxlength="2" required type="text"  style="width: 40px;text-transform: uppercase;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">End</label>
                                                <div class="col-sm-1">
                                                    <input name="END_HOUR" id="value_endh" autocomplete="off" onkeyup="angka(this);" class="form-control" maxlength="2" required type="text"  style="width: 40px;text-transform: uppercase;">
                                                </div>
                                                <div class="col-sm-1">
                                                    <input name="END_MINUTE" id="value_endm" autocomplete="off" onkeyup="angka(this);" class="form-control" maxlength="2" required type="text"  style="width: 40px;text-transform: uppercase;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <a id="btn-ok"  onclick="save_temp_data();" class="btn btn-primary" data-dismiss="modal" data-placement="left" data-toggle="tooltip" title="Add Employee"><i class="fa fa-check"></i> Add</a>
                                                <!-- <?php
                                                // /echo form_close();
                                                ?> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>


    </section>
</aside>
