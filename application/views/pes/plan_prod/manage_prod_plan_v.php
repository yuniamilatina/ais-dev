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

        while (s.substr(0, 1) == '' && s.length > 1) {
            s = s.substr(1, 9999);
        }
        return s;
    }
</script>
<script>
    $(document).ready(function () {
        var date = new Date();
        $("#datepicker").datepicker(
                {
                    dateFormat: 'dd-mm-yy',
                    //changeMonth: true,
                    //changeYear: false,
                    duration: 'fast'
                            //stepMonths: 0
                }
        ).val();

        $('#dropdownlist_date').on('change', function () {
            $('#textbox_date').val($(this).val());
        });

//        $("#shift_normal").click(function () {
//            $("#value-shift").val("SHIFT1");
//            alert("");
//        });
//
//        $("#datepicker").datepicker({}).on("change", function () {
//            var datepicker = $(this).val();
//            var period = $("#CHR_DATE").val();
//            var work_center = $("#CHR_WORK_CENTER").val();
//            var shift_normal = $("#shift_normal").val();
//            var shift_long = $("#shift_long").val();
//            $.ajax({
//                async: false,
//                type: "POST",
//                url: "<?php echo site_url('pes/prod_plan_c/get_data_detail_by_date'); ?>",
//                data: "datepicker=" + datepicker + "; CHR_DATE=" + period + "; CHR_WORK_CENTER=" + work_center,
//                success: function (data) {
//                    $('#ct').html(data['CHR_CYCLE_TIME']);
//                    $('#prod_target').html(data['CHR_TARGET_PROD']);
//                    $('#ct').html(data['CHR_CYCLE_TIME']);
//                }
//            });
//        });

    });
</script>

<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/pes/plan_prod_c') ?>"><strong>Manage Prod Planning</strong></a></li>
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
                        <i class="fa fa-th"></i>
                        <span class="grid-title"><strong>PROD PLANNING</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="10%">Department</td>
                                    <td width="60%">
                                        <input class="form-control" value="<?php echo $dept; ?>" type="text" readonly style="width:150px;" >
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                                <tr>

                                    <td width="10%">Periode</td>
                                    <td width="60%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -0; $x <= 4; $x++) { ?>
                                                <option value="<?php echo site_url('pes/prod_plan_c/search/' . date("Ym", strtotime("+$x month")) . '/' . trim($work_center)); ?>" <?php
                                                if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("Ym", strtotime("+$x month")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">        
                                    </td>
                                </tr>
                                <tr>
                                    <td width="10%">Work Center</td>
                                    <td width="60%"> 
                                        <select id="e1" onChange="document.location.href = this.options[this.selectedIndex].value;" >
                                            <?php foreach ($all_work_center as $row) { ?>
                                                <option value="<? echo site_url('pes/prod_plan_c/search/' . $selected_date . '/' . trim($row->CHR_WORK_CENTER)); ?>" <?php
                                                if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_WORK_CENTER); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" colspan="4"></td>
                                    <td width="10%">
                                    </td>
                                    <td width="10%">    

                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div id="table-luar">
                            <table id="example" class="table table-striped table-condensed table-bordered table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr class='gradeX'>
                                        <th rowspan="3" style="vertical-align: middle;">Shift</th>                                        
                                        <th rowspan="3" style="vertical-align: middle;">Shift Type</th>
                                        <th colspan="31" style="text-align:center;"> Date </th>
                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        $date = new DateTime($first_saturday);
                                        $thisMonth = $date->format('m');

                                        $z = 0;
                                        while ($date->format('m') === $thisMonth) {
                                            $datesaturday[$z] = $date->format('j');
                                            $date->modify('next Saturday');
                                            $z++;
                                        }

                                        $date1 = new DateTime($first_sunday);
                                        $thisMonth1 = $date1->format('m');

                                        $y = 0;
                                        while ($date1->format('m') === $thisMonth1) {
                                            $datesunday[$y] = $date1->format('j');
                                            $date1->modify('next Sunday');
                                            $y++;
                                        }

                                        $k = 0;
                                        for ($a = 1; $a <= 31; $a++) {
                                            if ($y == 5 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 5 && $z == 4) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesunday[$k + 4] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                            if ($y == 4 && $z == 5) {
                                                if ($datesunday[$k] == $a || $datesunday[$k + 1] == $a || $datesunday[$k + 2] == $a || $datesunday[$k + 3] == $a || $datesaturday[$k] == $a || $datesaturday[$k + 1] == $a || $datesaturday[$k + 2] == $a || $datesaturday[$k + 3] == $a || $datesaturday[$k + 4] == $a) {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:#E34234;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                } else {
                                                    if (date('Ymj') == $selected_date . $a) {
                                                        echo "<td colspan='2' style='text-align:center;background:#007FFF;color:white;border-left-width: 0.1em;'>$a</td>";
                                                    } else {
                                                        echo "<td colspan='2' style='text-align:center;background:whitesmoke;border-left-width: 0.1em;'>$a</td>";
                                                    }
                                                }
                                            }
                                        }
                                        ?>
                                    </tr>
                                    <tr class='gradeX'>
                                        <?php
                                        for ($x = 1; $x <= 62; $x++) {
                                            if ($x % 2 != 0) {
                                                echo "<td style='text-align:center;border-left-width: 0.1em;'><div class='td-fixed'>Target</div></td>";
                                            } else {
                                                echo "<td style='text-align:center;border-right-width: 0;'><div class='td-fixed'>CT</div></td>";
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        if ($isi->INT_SHIFT == 1) {
                                            echo "<td>Shift 1</td>";
                                        } else if ($isi->INT_SHIFT == 2) {
                                            echo "<td>Shift 2</td>";
                                        } else if ($isi->INT_SHIFT == 3) {
                                            echo "<td>Shift 3</td>";
                                        } else {
                                            echo "<td>Non Shift</td>";
                                        }
                                        if ($isi->INT_FLG_SHIFT == 0) {
                                            echo "<td>Normal Shift</td>";
                                        } else {
                                            echo "<td>Long Shift</td>";
                                        }
                                        echo "<td>$isi->TG_1</td>";
                                        echo "<td>$isi->CT_1</td>";
                                        echo "<td>$isi->TG_2</td>";
                                        echo "<td>$isi->CT_2</td>";
                                        echo "<td>$isi->TG_3</td>";
                                        echo "<td>$isi->CT_3</td>";
                                        echo "<td>$isi->TG_4</td>";
                                        echo "<td>$isi->CT_4</td>";
                                        echo "<td>$isi->TG_5</td>";
                                        echo "<td>$isi->CT_5</td>";
                                        echo "<td>$isi->TG_6</td>";
                                        echo "<td>$isi->CT_6</td>";
                                        echo "<td>$isi->TG_7</td>";
                                        echo "<td>$isi->CT_7</td>";
                                        echo "<td>$isi->TG_8</td>";
                                        echo "<td>$isi->CT_8</td>";
                                        echo "<td>$isi->TG_9</td>";
                                        echo "<td>$isi->CT_9</td>";
                                        echo "<td>$isi->TG_10</td>";
                                        echo "<td>$isi->CT_10</td>";
                                        echo "<td>$isi->TG_11</td>";
                                        echo "<td>$isi->CT_11</td>";
                                        echo "<td>$isi->TG_12</td>";
                                        echo "<td>$isi->CT_12</td>";
                                        echo "<td>$isi->TG_13</td>";
                                        echo "<td>$isi->CT_13</td>";
                                        echo "<td>$isi->TG_14</td>";
                                        echo "<td>$isi->CT_14</td>";
                                        echo "<td>$isi->TG_15</td>";
                                        echo "<td>$isi->CT_15</td>";
                                        echo "<td>$isi->TG_16</td>";
                                        echo "<td>$isi->CT_16</td>";
                                        echo "<td>$isi->TG_17</td>";
                                        echo "<td>$isi->CT_17</td>";
                                        echo "<td>$isi->TG_18</td>";
                                        echo "<td>$isi->CT_18</td>";
                                        echo "<td>$isi->TG_19</td>";
                                        echo "<td>$isi->CT_19</td>";
                                        echo "<td>$isi->TG_20</td>";
                                        echo "<td>$isi->CT_20</td>";
                                        echo "<td>$isi->TG_21</td>";
                                        echo "<td>$isi->CT_21</td>";
                                        echo "<td>$isi->TG_22</td>";
                                        echo "<td>$isi->CT_22</td>";
                                        echo "<td>$isi->TG_23</td>";
                                        echo "<td>$isi->CT_23</td>";
                                        echo "<td>$isi->TG_24</td>";
                                        echo "<td>$isi->CT_24</td>";
                                        echo "<td>$isi->TG_25</td>";
                                        echo "<td>$isi->CT_25</td>";
                                        echo "<td>$isi->TG_26</td>";
                                        echo "<td>$isi->CT_26</td>";
                                        echo "<td>$isi->TG_27</td>";
                                        echo "<td>$isi->CT_27</td>";
                                        echo "<td>$isi->TG_28</td>";
                                        echo "<td>$isi->CT_28</td>";
                                        echo "<td>$isi->TG_29</td>";
                                        echo "<td>$isi->CT_29</td>";
                                        echo "<td>$isi->TG_30</td>";
                                        echo "<td>$isi->CT_30</td>";
                                        echo "<td>$isi->TG_31</td>";
                                        echo "<td>$isi->CT_31</td>";
                                        ?>
                                        </tr>
                                        <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <?php
        if (validation_errors()) {
            echo '<div class = "alert alert-danger"><strong>WARNING !</strong>' . validation_errors() . '</div >';
        }
        ?>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-certificate"></i>
                        <span class="grid-title"><strong><div id="title"><?php echo $work_center . '- ' . $selected_date ?></div></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <?php echo form_open('pes/prod_plan_c/save_prod_plan', 'class="form-horizontal"'); ?>
                    <div class="grid-body">

                        <ul class="nav nav-tabs" id="myTab">
                            <li class="active"><a data-toggle="tab" href="#CREATE">CREATE PROD. PLAN</a></li>
                            <li><a data-toggle="tab" href="#EDIT">EDIT PROD. PLAN</a></li>
                        </ul>
                        <div class="tab-content" style="font-size:12px;">
                            <div name="tabadd" id="CREATE" class="tab-pane fade in active">
                                <div class="row" style="margin-bottom:5px;margin-top: 15px;">
                                    <?php echo form_open('pes/prod_plan_c/save_prod_plan', 'class="form-horizontal"'); ?>
                                    <input name="CHR_WORK_CENTER" value="<?php echo $work_center ?>" type="hidden">
                                    <input name="CHR_DATE" value="<?php echo $selected_date ?>" type="hidden">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Shift</label>
                                        <div class="col-sm-5">
                                            <label><input type="radio" name="INT_SHIFT" class="icheck" checked value="1"> Shift 1</label> &nbsp;&nbsp;&nbsp;
                                            <label><input type="radio" name="INT_SHIFT" class="icheck" value="2"> Shift 2</label> &nbsp;&nbsp;&nbsp;
                                            <label><input type="radio" name="INT_SHIFT" class="icheck" value="3"> Shift 3</label> &nbsp;&nbsp;&nbsp;
                                            <label><input type="radio" name="INT_SHIFT" class="icheck" value="4"> Non-Shift</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Shift Type</label>
                                        <div class="col-sm-5">
                                            <label><input type="radio" name="INT_FLG_SHIFT" class="icheck" checked value="0"> Normal</label> &nbsp;&nbsp;&nbsp;
                                            <label><input type="radio" name="INT_FLG_SHIFT" class="icheck" value="1"> Long</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Production Target</label>
                                        <div class="col-sm-5">
                                            <input name="INT_TARGET_PROD" class="form-control" maxlength="6" autocomplete="off" onkeyup="angka(this);" required type="text" style="width: 80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Cycle Time</label>
                                        <div class="col-sm-5">
                                            <input name="INT_CYCLE_TIME" class="form-control" maxlength="2" autocomplete="off" onkeyup="angka(this);" required type="text" style="width: 60px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data" onclick="return confirm('Apakah anda akan menyimpan data ditanggal terpilih?');"><i class="fa fa-check"></i> Save</button>
                                                <?php
                                                echo anchor('pes/prod_plan_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                                echo form_close();
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div name="tabrev" id="EDIT" class="tab-pane fade">
                                <div class="row" style="margin-bottom:5px;margin-top: 15px;">
                                    <?php echo form_open('pes/prod_plan_c/update_prod_plan', 'class="form-horizontal"'); ?>
                                    <input name="CHR_WORK_CENTER" id="CHR_WORK_CENTER" value="<?php echo $work_center ?>" type="hidden">
                                    <input name="CHR_DATE" id="CHR_DATE" value="<?php echo $selected_date ?>" type="hidden">
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Date</label>
                                        <div class="col-sm-5">
                                            <input name="CHR_DATE" id="datepicker" class="form-control" autocomplete="off" required type="text" style="width:150px;" value="<?php echo date('d-m-Y') ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Shift</label>
                                        <div class="col-sm-5">
                                            <label><input type="radio" name="INT_SHIFT" id="shift1" class="icheck" checked value="1"> Shift 1</label> &nbsp;&nbsp;&nbsp;
                                            <label><input type="radio" name="INT_SHIFT" id="shift2" class="icheck" value="2"> Shift 2</label> &nbsp;&nbsp;&nbsp;
                                            <label><input type="radio" name="INT_SHIFT" id="shift3" class="icheck" value="3"> Shift 3</label> &nbsp;&nbsp;&nbsp;
                                            <label><input type="radio" name="INT_SHIFT" id="shift4" class="icheck" value="4"> Non-Shift</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Shift Type</label>
                                        <div class="col-sm-5">
                                            <label><input type="radio" name="INT_FLG_SHIFT" id="shift_normal" class="icheck" checked value="0"> Normal</label> &nbsp;&nbsp;&nbsp;
                                            <label><input type="radio" name="INT_FLG_SHIFT" id="shift_long" class="icheck" value="1"> Long</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Production Target</label>
                                        <div class="col-sm-5">
                                            <input name="INT_TARGET_PROD" class="form-control" id="prod_target" maxlength="6" autocomplete="off" onkeyup="angka(this);" required type="text" style="width: 80px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-3 control-label">Cycle Time</label>
                                        <div class="col-sm-5">
                                            <input name="INT_CYCLE_TIME" class="form-control" id="ct" maxlength="2" autocomplete="off" onkeyup="angka(this);" required type="text" style="width: 60px;">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-offset-3 col-sm-5">
                                            <div class="btn-group">
                                                <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Update this data" onclick="return confirm('Apakah anda akan mengubah data ditanggal terpilih?');"><i class="fa fa-refresh"></i> Update</button>
                                                <?php
                                                echo anchor('pes/prod_plan_c', 'Cancel', 'class="btn btn-default" data-placement="right" data-toggle="tooltip" title="Back to manage"');
                                                echo form_close();
                                                ?>
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

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                                    $(document).ready(function () {
                                                        var table = $('#example').DataTable({
                                                            scrollY: "350px",
                                                            scrollX: true,
                                                            scrollCollapse: true,
                                                            paging: false,
                                                            fixedColumns: {
                                                                leftColumns: 2
                                                            }
                                                        });
                                                    });
</script>