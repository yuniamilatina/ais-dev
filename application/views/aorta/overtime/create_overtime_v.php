<script>
    $(document).ready(function() {
        // $("#datepicker1").datepicker({dateFormat: 'dd/mm/yy', minDate: '-3h', maxDate: '+15h'});
        $("#datepicker1").datepicker({
            dateFormat: 'dd/mm/yy'
        });

        $(".inputs").keyup(function() {
            if (this.value.length == this.maxLength) {
                $(this).blur();
                $(".inputs2").focus();
            }
        });

        $(".inputs2").keyup(function() {
            if (this.value.length == this.maxLength) {
                $(this).blur();
                $(".inputs3").focus();
            }
        });

        $(".inputs3").keyup(function() {
            if (this.value.length == this.maxLength) {
                $(this).blur();
                $(".inputs4").focus();
            }
        });

        $(".inputs4").keyup(function() {
            if (this.value.length == this.maxLength) {
                $(this).blur();
                $("#btn-ok").focus();
            }
        });

        getTempOvertimeList($("#datepicker1").val(), $("#section").val(), $("#dept").val());

    });

    function getDetailOvertime(no_sequence) {
        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('aorta/overtime_c/getTempOvertime'); ?>",
            data: {
                no_sequence: no_sequence
            },
            success: function(json_data) {

                if (json_data.data === false) {
                    $("#list_of_npk_overtime").html("<tr><td colspan='11'>No data available in table<td></tr>");

                    $("#btn_save").prop("disabled", true);
                    document.getElementById('pic_id').readOnly = false;
                    document.getElementById('category_id').readOnly = false;
                    document.getElementById('alasan_id').readOnly = false;
                    document.getElementById('alasan_id').value = '';
                    $("#form-no-sequence").hide();
                    $("#no_sequence").val('');
                } else {
                    $("#list_of_npk_overtime").html(json_data.data);

                    $("#btn_save").prop("disabled", false);
                    document.getElementById('pic_id').readOnly = true;
                    document.getElementById('category_id').readOnly = true;
                    document.getElementById('alasan_id').readOnly = true;
                    document.getElementById('alasan_id').value = json_data.alasan;
                    $("#form-no-sequence").show();
                    $("#no_sequence").val(no_sequence);
                }
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function getTempOvertimeList(tgl_overtime, section, dept) {
        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('aorta/overtime_c/getListInProcessOvertime'); ?>", //not yet coplete modal
            data: {
                tgl_overtime: tgl_overtime,
                section: section,
                dept: dept
            },
            success: function(json_data) {
                if (json_data) {
                    $("#buttonModalOvertime").click();
                    $("#no_sequence_selected").html(json_data);
                } else {
                    $("#list_of_npk_overtime").html("<tr><td colspan='11'>No data available in table<td></tr>");

                    $("#btn_save").prop("disabled", true);
                    document.getElementById('pic_id').readOnly = false;
                    document.getElementById('category_id').readOnly = false;
                    document.getElementById('alasan_id').readOnly = false;
                    document.getElementById('alasan_id').value = '';
                    $("#form-no-sequence").hide();
                    $("#no_sequence").val('');

                    return false;
                }

            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function get_detail_ot() {
        getTempOvertimeList($("#datepicker1").val(), $("#section").val(), $("#dept").val());
    }

    function selectOvertime() {
        var no_sequence = $("#no_sequence_selected").val();
        $("#closeModalOvertime").click();
        getDetailOvertime(no_sequence);
    }

    function removeNpk(no_sequence, npk) {

        var x = confirm("Are you sure you want to remove this NPK (" + npk + ") ?");
        if (x)
            $.ajax({
                async: false,
                type: "POST",
                dataType: 'json',
                url: "<?php echo site_url('aorta/overtime_c/remove_npk'); ?>",
                data: {
                    no_sequence: no_sequence,
                    npk: npk
                },
                success: function(json_data) {
                    getDetailOvertime(no_sequence);
                },
                error: function(request) {
                    alert(request.responseText);
                }
            });
        else
            return false;

    }

    function addNpk() {
        var cat_id = document.getElementById('category_id').value;
        var pic_id = document.getElementById('pic_id').value;
        var tanggal_overtime = document.getElementById('datepicker1').value;
        var alasan_id = document.getElementById('alasan_id').value;
        var npk = document.getElementById('e1').value;
        var starth = document.getElementById('value_starth').value;
        var startm = document.getElementById('value_startm').value;
        var endh = document.getElementById('value_endh').value;
        var endm = document.getElementById('value_endm').value;
        var no_sequence = document.getElementById('no_sequence').value;

        if (starth > 23 || endh > 23) {
            alert("jam tidak bisa lebih dari jam 23");
            return;
        }

        if (startm > 60 || endm > 60) {
            alert("menit tidak bisa lebih dari jam 60");
            return;
        }

        if (starth == '' || startm == '') {
            alert("jam tidak boleh kosong");
            return;
        }

        if (endh == '' || endm == '') {
            alert("jam tidak boleh kosong");
            return;
        }

        if (alasan_id == null || alasan_id == '') {
            alert("Alasan overtime tidak boleh kosong");
            return;
        }

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('aorta/overtime_c/saveNpkOvertime'); ?>",
            data: {
                TGL_OVERTIME: tanggal_overtime,
                NPK: npk,
                KAT_OT: cat_id,
                NPK_PIC: pic_id,
                ALASAN: alasan_id,
                START_HOUR: starth,
                START_MINUTE: startm,
                END_HOUR: endh,
                END_MINUTE: endm,
                NO_SEQUENCE: no_sequence
            },
            success: function(json_data) {

                if (json_data.msg) {
                    alert(json_data.msg);
                    // $("#close_add_employee").click();
                    return false;
                } else {
                    getDetailOvertime(json_data.no_sequence);
                    $('#modalAdd').modal('hide');
                }
            },
            error: function(request) {
                alert(request.responseText);
            }
        });

    }

    function get_workhour() {
        var shift_id = document.getElementById('shift_id').value;

        if (shift_id == 1) {
            document.getElementById('value_starth').value = '14';
            document.getElementById('value_startm').value = '15';
            document.getElementById('value_endh').value = '16';
            document.getElementById('value_endm').value = '35';
        } else if (shift_id == 2) {
            document.getElementById('value_starth').value = '22';
            document.getElementById('value_startm').value = '15';
            document.getElementById('value_endh').value = '06';
            document.getElementById('value_endm').value = '00';
        } else if (shift_id == 3) {
            document.getElementById('value_starth').value = '16';
            document.getElementById('value_startm').value = '35';
            document.getElementById('value_endh').value = '22';
            document.getElementById('value_endm').value = '15';
        } else {
            document.getElementById('value_starth').value = '16';
            document.getElementById('value_startm').value = '35';
            document.getElementById('value_endh').value = '';
            document.getElementById('value_endm').value = '';
        }

    }

    function change_employee_by_dept(dept) {

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('aorta/overtime_c/change_employee_by_dept'); ?>",
            data: {
                DEPT: dept
            },
            success: function(json_data) {
                if (json_data) {
                    $("#e1").html(json_data.data);
                }
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

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

    function checkreason() {

        if (!$.trim($("#alasan_id").val())) {
            alert('alasan overtime requested');
            return false;
        } else {
            $('#modalAdd').modal({backdrop: 'static', keyboard: false}) 
            $('#modalAdd').modal('show');
        }
    }
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/aorta/overtime_c/') ?>">Manage Overtime</a></li>
            <li> <a href="#"><strong>Create Overtime</strong></a></li>
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
                        <span class="grid-title"><strong>CREATE OVERTIME</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>

                    <?php
                    echo form_open('aorta/overtime_c/save_overtime', 'class="form-horizontal"');
                    ?>

                    <div class="grid-body">

                        <a data-toggle="modal" style="display:none;" data-target="#modalListOvertime" data-placement="left" id="buttonModalOvertime" data-toggle="tooltip" title="modal" class='btn btn-primary'><span class="fa fa-plus"></span>List</a>

                        <div class="form-group" id='form-no-sequence'>
                            <label class="col-sm-3 control-label">Temporary No Sequence</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" style="background:#FFFFFF;" class="form-control" name="NO_SEQUENCE" id="no_sequence" readonly></input>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style='display:none;'>
                            <label class="col-sm-3 control-label">Dept</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" style="background:#FFFFFF;" class="form-control" name="KD_DEPT" id="dept" readonly value="<?php echo $dept; ?>"></input>
                                </div>
                            </div>
                        </div>

                        <div class="form-group" style='display:none;'>
                            <label class="col-sm-3 control-label">Section</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input type="text" style="background:#FFFFFF;" class="form-control" name="KD_SECTION" id="section" readonly value="<?php echo $section; ?>"></input>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Date</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <input id="datepicker1" readonly name="TGL_OVERTIME" style="background:#FFFFFF;" class="form-control" autocomplete="off" required type="text" value="<?php echo $date; ?>" onchange="get_detail_ot();">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Category</label>
                            <div class="col-sm-3">
                                <div class="input-group">
                                    <select class="form-control" name="KAT_OT" id="category_id">
                                        <?php foreach ($all_category as $row) { ?>
                                            <option value="<?php echo $row->CHR_ID_CAT; ?>"><?php echo $row->CHR_DESC_CAT; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">PIC</label>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <select class="form-control" name="NPK_PIC" id="pic_id">
                                        <?php foreach ($all_pic as $row) { ?>
                                            <option value="<?php echo $row->NPK; ?>"><?php echo $row->NAMA; ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-3 control-label">Reason</label>
                            <div class="col-sm-5">
                                <textarea rows="3" id="alasan_id" name="ALASAN" cols="200" class="form-control" placeholder="" maxlength="500"></textarea>
                            </div>
                        </div>

                        <div class="pull-right">
                            <span style='padding-right:850px;text-decoration: underline;'></span>
                            <a onclick="checkreason();" data-placement="left" data-toggle="tooltip" title="Add Employee" class='btn btn-primary'><span class="fa fa-plus"></span>&nbsp;&nbsp;Add Employee</a>
                        </div>

                        <table style="margin-bottom:10px;" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">NPK</th>
                                        <th style="text-align:center;">Nama</th>
                                        <th style="text-align:center;">Start Time</th>
                                        <th style="text-align:center;">End Time</th>
                                        <th style="text-align:center;">Duration</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="list_of_npk_overtime">
                                    <tr>
                                        <td colspan="7">No data available in table
                                        <td>
                                    </tr>
                                </tbody>
                        </table>

                        <div class="form-group">
                            <div class="col-sm-12 text-center">
                                <div class="btn-group">
                                    <button type="submit" id="btn_save" class="btn btn-success" style="width:200px"><i class="fa fa-check"></i> Save</button>
                                    <?php
                                    echo anchor('aorta/overtime_c/index/' . $period . '/' . $dept . '/' . $section, 'Cancel', 'class="btn btn-default"');
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalListOvertime" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header  bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel1"><strong>Overtime on progress</strong></h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label class="col-sm-5 control-label">On Progress Overtime</label>
                                                <div class="col-sm-4">
                                                    <select id="no_sequence_selected" class="form-control">
                                                    </select>
                                                </div>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" id="closeModalOvertime" style="display:none;" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <a onclick='selectOvertime()' class="btn btn-success" data-dismiss="modal" data-placement="left" data-toggle="tooltip" title="Add Employee"><i class="fa fa-plus"></i> Pilih</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1" aria-hidden="true" style="display: none;">
                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header  bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="myModalLabel1"><strong>Add Employee</strong></h4>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Dept</label>
                                                <div class="col-sm-3">
                                                    <select onchange='change_employee_by_dept(this.options[this.selectedIndex].value)' name="DEPT_SELECTED" class="form-control">
                                                        <?php foreach ($all_dept as $row) { ?>
                                                            <option value="<?php echo $row->KODE; ?>" <?php
                                                                if ($dept == trim($row->KODE)) {
                                                                    echo 'SELECTED';
                                                                }
                                                                ?>><?php echo trim($row->KODE); ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Name</label>
                                                <div class="col-sm-7">
                                                    <select required name="NPK" id="e1" class="form-control" required>
                                                        <option value="0">-- Pilih NPK --</option>
                                                        <?php foreach ($all_employee as $list) { ?>
                                                            <option value="<?php echo $list->NPK; ?>"><?php echo $list->NPK . ' - ' . trim($list->NAMA); ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Type</label>
                                                <div class="col-sm-7">
                                                    <input type="radio" class="icheck" name="INT_TYPE_QUOTA" value="0" checked> Normal &nbsp; &nbsp;
                                                    <input type="radio" class="icheck" name="INT_TYPE_QUOTA" value="1"> Improvement
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">Shift</label>
                                                <div class="col-sm-3">
                                                    <div class="input-group">
                                                        <select class="form-control" style='width:120px;' id="shift_id" onchange="get_workhour();">
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
                                                <div class="col-sm-1">Hours
                                                    <input value='14' name="START_HOUR" id="value_starth" autocomplete="off" onkeyup="angka(this);" class="inputs" maxlength="2" required type="text" style="width: 40px;text-transform: uppercase;padding-left:11px;">
                                                </div>
                                                <div class="col-sm-1">Minutes
                                                    <input value='15' name="START_MINUTE" id="value_startm" autocomplete="off" onkeyup="angka(this);" class="inputs2" maxlength="2" required type="text" style="width: 40px;text-transform: uppercase;padding-left:11px;">
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label class="col-sm-3 control-label">End</label>
                                                <div class="col-sm-1">Hours
                                                    <input value='16' name="END_HOUR" id="value_endh" autocomplete="off" onkeyup="angka(this);" class="inputs3" maxlength="2" required type="text" style="width: 40px;text-transform: uppercase;padding-left:11px;">
                                                </div>
                                                <div class="col-sm-1">Minutes
                                                    <input value='35' name="END_MINUTE" id="value_endm" autocomplete="off" onkeyup="angka(this);" class="inputs4" maxlength="2" required type="text" style="width: 40px;text-transform: uppercase;padding-left:11px;">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <a id="btn-ok" onclick="addNpk();" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Add Employee"><i class="fa fa-check"></i> Add</a>
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