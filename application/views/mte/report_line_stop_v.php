<script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<script>
    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            },
            format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            }
        return function(table, name) {
            if (!table.nodeType)
                table = document.getElementById(table)
            var ctx = {
                worksheet: name || 'Sheet1',
                table: table.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>
<style>
    /* The container */
    .container-radio {
        /* display: block; */
        position: relative;
        padding-left: 30px;
        font-weight: 400;
        cursor: pointer;
        /* font-size: 10pt; */
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
    }

    /* Hide the browser's default radio button */
    .container-radio input {
        position: absolute;
        opacity: 0;
        cursor: pointer;
    }

    /* Create a custom radio button */
    .checkmark {
        position: absolute;
        top: 0;
        left: 0;
        height: 20px;
        width: 20px;
        background-color: #ccc;
        border-radius: 50%;
        /* margin-top: 22px; */
    }

    /* On mouse-over, add a grey background color */
    .container-radio:hover input~.checkmark {
        background-color: darkgrey;
    }

    /* When the radio button is checked, add a blue background */
    .container-radio input:checked~.checkmark {
        background-color: #2196F3;
    }

    /* Create the indicator (the dot/circle - hidden when not checked) */
    .checkmark:after {
        content: "";
        position: absolute;
        display: none;
    }

    /* Show the indicator (dot/circle) when checked */
    .container-radio input:checked~.checkmark:after {
        display: block;
    }

    /* Style the indicator (dot/circle) */
    .container-radio .checkmark:after {
        top: 5px;
        left: 5px;
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: white;
    }

    #table-luar {
        font-size: 11px;
    }

    #td_date {
        text-align: center;
        vertical-align: top;
    }

    #filter {
        -webkit-border-horizontal-spacing: 0px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
        margin-bottom: 10px;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
        border: 1px;
    }

    #testDiv {
        width: 100%;
        white-space: nowrap;
        overflow-x: scroll;
        overflow-y: visible;
        font-size: 12px;
    }

    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

    .td-fixed {
        width: 30px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }
</style>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>REPORT LINE STOP DETAIL</strong></a></li>
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>LINE STOP DETAIL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>

                    <div class="grid-body" style='margin-bottom:-45px;'>
                        <div class="pull">
                            <div class="pull-right grid-tools">
                                <?php echo form_open('mte/report_line_stop_c/print_report_line_stop', 'class="form-horizontal"'); ?>
                            </div>
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -31; $x <= 0; $x++) { ?>
                                                <option value="<?php echo site_url('mte/report_line_stop_c/index/' . date("Ym", strtotime("+$x month")) . '/' . $id_product_group); ?>" <?php
                                                                                                                                                                                        if ($selected_date == date("Ym", strtotime("+$x month"))) {
                                                                                                                                                                                            echo 'SELECTED';
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>> <?php echo date("M Y", strtotime("+$x month")); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl2">
                                            <?php foreach ($all_product_group as $row) { ?>
                                                <option value="<?php echo site_url('mte/report_line_stop_c/index/' . $selected_date . '/' . $row->INT_ID); ?>" <?php
                                                                                                                                                                if ($id_product_group == $row->INT_ID) {
                                                                                                                                                                    echo 'SELECTED';
                                                                                                                                                                }
                                                                                                                                                                ?>><?php echo trim($row->CHR_PRODUCT_GROUP); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="80%" style="text-align:right;">
                                        <input type="submit" style="margin-top:4px;" class="btn btn-primary" value="Export to Excel"><i class="fa fa-download-up"></i></input>
                                    </td>

                                </tr>
                            </table>
                        </div>
                        <input name="CHR_DATE_SELECTED" value="<?php echo $selected_date ?>" type="hidden">
                        <input name="INT_GROUP_PROD" value="<?php echo $id_product_group ?>" type="hidden">
                        <?php echo form_close() ?>
                    </div>

                    <div class="grid-body">
                        <div class="pull">
                            <div id="table-luar">
                                <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr class='gradeX'>
                                            <th style="text-align:center;">No</th>
                                            <th style="text-align:center;text-align:center;">Work <br>Center</th>
                                            <th style="text-align:center;">Shift</th>
                                            <th style="text-align:center;">Type</th>
                                            <th style="text-align:center;">Date</th>
                                            <th style='text-align:center;background:#fef983;color:#e59800;'>LS Start</th>
                                            <th style='text-align:center;background:#ff967d;color:#b12828;'>CALL <br>Start</th>
                                            <th style='text-align:center;'>Waiting <br> Duration</th>
                                            <th style='text-align:center;background:#a5d2e6;color:#0a2350;'>Follow Up <br> Start</th>
                                            <th style='text-align:center;'>Repair <br> Duration</th>
                                            <th style='text-align:center;background:#ACDF87;color:#19410a;'>LS Stop</th>
                                            <th style="text-align:center;">Repaired by</th>
                                            <th style="text-align:center;">LS Total (m)</th>
                                            <th style='text-align:center;'>Comment</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($data_line_stop_machine_by_period as $isi) {
                                            echo "<tr class='gradeX'>";
                                            echo "<td 'style=text-align:center;'>$i</td>";
                                            echo "<td 'style=text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                            echo "<td 'style=text-align:center;'>$isi->CHR_SHIFT</td>";
                                            echo "<td>$isi->CHR_LINE_STOP</td>";
                                            echo "<td>" . date('d-m-Y', strtotime($isi->CHR_CREATED_DATE)) . "</td>";
                                            if ($isi->CHR_START_TIME == ':') {
                                                echo "<td style='text-align:center;'>-</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#fef983;color:#e59800;'>" . $isi->CHR_START_TIME . "</td>";
                                            }
                                            if ($isi->CHR_WAITING_TIME == NULL) {
                                                echo "<td style='text-align:center;'>-</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#ff967d;color:#b12828;'>" . date('H:i', strtotime($isi->CHR_WAITING_TIME)) . "</td>";
                                            }
                                            if ($isi->CHR_WAITING_TIME == NULL) {
                                                echo "<td style='text-align:center;'>-</td>";
                                            } else {
                                                echo "<td style='text-align:center;'>$isi->INT_DURASI_WAITING</td>";
                                            }
                                            if ($isi->CHR_FOLLOWUP_TIME == NULL) {
                                                echo "<td style='text-align:center;'>-</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#a5d2e6;color:#0a2350;'>" . date('H:i', strtotime($isi->CHR_FOLLOWUP_TIME)) . "</td>";
                                            }
                                            if ($isi->CHR_FOLLOWUP_TIME == NULL) {
                                                echo "<td style='text-align:center;'>-</td>";
                                            } else {
                                                echo "<td style='text-align:center;'>$isi->INT_DURASI_REPAIR</td>";
                                            }
                                            if ($isi->CHR_STOP_TIME == ':') {
                                                echo "<td style='text-align:center;'>-</td>";
                                            } else {
                                                echo "<td style='text-align:center;background:#ACDF87;color:#19410a;'>$isi->CHR_STOP_TIME</td>";
                                            }
                                            if ($isi->CHR_FOLLOWUP_BY == NULL) {
                                                echo "<td style='text-align:left;'>-</td>";
                                            } else {
                                                echo "<td style='text-align:left;'>$isi->CHR_USERNAME</td>";
                                            }
                                            if ($isi->CHR_STOP_TIME == ':') {
                                                echo "<td style='text-align:center;'>-</td>";
                                            } else {
                                                echo "<td style='text-align:center;'>$isi->INT_DURASI_LS</td>";
                                            }

                                            $color_message = null;
                                            if ($isi->CHR_PROBLEM_DESC == NULL || $isi->CHR_PROBLEM_DESC == '') {
                                                $color_message = "class='label label-primary'";
                                            } else {
                                                if ($isi->INT_FLG_VERIFIED == 1) {
                                                    $color_message = "class='label label-success'";
                                                } else {
                                                    $color_message = "class='label label-warning'";
                                                }
                                            }

                                            // echo "<td style=text-align:center;><a data-toggle='modal' onclick=check_flg_spare($isi->INT_FLG_SPAREPART,'$isi->CHR_CREATED_DATE','$isi->CHR_LINE_STOP'); data-target='#modalAddComment2$isi->INT_ID_LINE_STOP' $color_message  data-placement='top' data-toggle='tooltip' title='Comment'><span class='fa fa-comment'></span></a></td>";
                                            echo "<td style=text-align:center;><a " . $color_message . " data-toggle='modal' onclick=getDataLineStop($isi->INT_ID_LINE_STOP); data-target='#modalAddComment' data-placement='top' data-toggle='tooltip' title='Comment'><span class='fa fa-ellipsis-h'></span></a></td>";

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
        </div>
        <!--GRID TO DISPLAY DETAIL LINE STOP GRID TABLE-->

        <div class="modal fade" id="modalAddComment" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
            <div class="modal-wrapper">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="modalprogress"><strong>Repair Breakdown</strong></h4>
                        </div>

                        <div class="modal-body">
                            <?php echo form_open('mte/report_line_stop_c/save_repair_breakdown', 'class="form-horizontal"'); ?>

                            <input name="CHR_PERIODE" class="form-control" id='periode' type="hidden" value="<?php echo $selected_date; ?>">
                            <input name="INT_ID_PRODUCT_GROUP" class="form-control" id='product_group' required type="hidden" value="<?php echo $id_product_group; ?>">
                            <input name="INT_ID_LINE_STOP" class="form-control" id='INT_ID_LINE_STOP' required type="hidden">

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Machine</label>
                                <div class="col-sm-5">
                                    <input name="CHR_MACHINE" id='CHR_MACHINE' autocomplete=off require class="form-control" maxlength="40" required type="text" style="width:350px">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Problem</label>
                                <div class="col-sm-5">
                                    <input name="CHR_PROBLEM" id='CHR_PROBLEM' autocomplete=off require class="form-control" maxlength="40" required type="text" style="width:350px">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Root Cause</label>
                                <div class="col-sm-5">
                                    <textarea name="CHR_PROBLEM_DESC" id='CHR_PROBLEM_DESC' rows="2" cols="40" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Corrective Action</label>
                                <div class="col-sm-5">
                                    <textarea name="CHR_CORRECTIVE_ACTION" id='CHR_CORRECTIVE_ACTION' rows="2" cols="40" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Notes</label>
                                <div class="col-sm-5">
                                    <textarea name="CHR_NOTE" id="CHR_NOTE" rows="2" cols="40" class="form-control"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Spare part Sources</label>
                                <div class="col-sm-5">
                                    <select name="CHR_SP_SOURCES" class="form-control" onChange='getDataSourceSparePart(this.options[this.selectedIndex].value);'>
                                        <option selected value="0">Not Using Parts</option>
                                        <option value="1">Transaction Parts</option>
                                        <option value="2">Zero Stock</option>
                                        <option value="3">Non-Existing</option>
                                    </select>
                                </div>
                            </div>

                            <div id="table-TransSP" style='margin-top:20px; font-size: 11px;'>
                                <table id="tableTransSP" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">#</th>
                                            <th style="text-align:center;">No</th>
                                            <th style="text-align:center;">Part No</th>
                                            <th style="text-align:center;">Name</th>
                                            <th style="text-align:center;">Specification</th>
                                            <th style="text-align:center;">Model</th>
                                            <th style="text-align:center;">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $i = 1;
                                        foreach ($data_trans_sp as $isi) { ?>
                                            <tr class='gradeX'>
                                                <td style='text-align:right;'><input class='icheck' type='checkbox' name='data_trans_sp[<?php echo $i; ?>][PART_NO]' value='<?php echo $isi->CHR_PART_NO; ?>'></td>
                                                <td style='text-align:center;'><?php echo $i; ?></td>
                                                <td style='text-align:center;'><?php echo $isi->CHR_PART_NO; ?></td>
                                                <td style='text-align:left;'><?php echo $isi->CHR_SPARE_PART_NAME; ?></td>
                                                <td style='text-align:left;'><?php echo $isi->CHR_SPECIFICATION; ?></td>
                                                <td style='text-align:left;'><?php echo $isi->CHR_MODEL; ?></td>
                                                <td style='text-align:center;'><input type='text' class='form-control' name='data_trans_sp[<?php echo $i; ?>][QTY]' value='0'></td>
                                            </tr>
                                        <?php $i++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="table-StockSP" style='margin-top:20px; font-size: 11px;'>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label"></label>
                                    <div class="col-sm-5">
                                        <a target="_blank" href="<?php echo base_url('index.php/samanta/spare_parts_c/create_sp'); ?>" class="btn btn-success" data-toggle="tooltip" data-placement="left" title="New Spare Part"><i class="fa fa-plus"></i>&nbsp;New Spare part</a>
                                    </div>
                                </div>

                                <table id="tableStockSP" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">#</th>
                                            <th style="text-align:center;">No</th>
                                            <th style="text-align:center;">Part No</th>
                                            <th style="text-align:center;">Name</th>
                                            <th style="text-align:center;">Specification</th>
                                            <th style="text-align:center;">Model</th>
                                            <th style="text-align:center;">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $j = 1;
                                        foreach ($data_stock_sp as $isi) { ?>
                                            <tr class='gradeX'>
                                                <td style='text-align:right;'><input class='icheck' type='checkbox' name='data_stock_sp[<?php echo $j; ?>][PART_NO]' value='<?php echo $isi->CHR_PART_NO; ?>'></td>
                                                <td style='text-align:center;'><?php echo $j; ?></td>
                                                <td style='text-align:center;'><?php echo $isi->CHR_PART_NO; ?></td>
                                                <td style='text-align:left;'><?php echo $isi->CHR_SPARE_PART_NAME; ?></td>
                                                <td style='text-align:left;'><?php echo $isi->CHR_SPECIFICATION; ?></td>
                                                <td style='text-align:left;'><?php echo $isi->CHR_MODEL; ?></td>
                                                <td style='text-align:center;'><input type='text' class='form-control' name='data_stock_sp[<?php echo $j; ?>][QTY]' value='0'></td>
                                            </tr>
                                        <?php $j++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div id="table-OrderSP" style='margin-top:20px; font-size: 11px;'>
                                <table id="tableOrderSP" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align:center;">#</th>
                                            <th style="text-align:center;">No</th>
                                            <th style="text-align:center;">Part No</th>
                                            <th style="text-align:center;">Name</th>
                                            <th style="text-align:center;">Specification</th>
                                            <th style="text-align:center;">Model</th>
                                            <th style="text-align:center;">Qty</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $k = 1;
                                        foreach ($data_order_sp as $isi) { ?>
                                            <tr class='gradeX'>
                                                <td style='text-align:right;'><input class='icheck' type='checkbox' name='data_order_sp[<?php echo $k; ?>][PART_NO]' value='<?php echo $isi->CHR_PART_NO; ?>'></td>
                                                <td style='text-align:center;'><?php echo $k; ?></td>
                                                <td style='text-align:center;'><?php echo $isi->CHR_PART_NO; ?></td>
                                                <td style='text-align:left;'><?php echo $isi->CHR_SPARE_PART_NAME; ?></td>
                                                <td style='text-align:left;'><?php echo $isi->CHR_SPECIFICATION; ?></td>
                                                <td style='text-align:left;'><?php echo $isi->CHR_MODEL; ?></td>
                                                <td style='text-align:center;'><input type='text' class='form-control' name='data_order_sp[<?php echo $k; ?>][QTY]' value='0'></td>
                                            </tr>
                                        <?php $k++;
                                        } ?>
                                    </tbody>
                                </table>
                            </div>

                            <div class="modal-footer">
                                <div class="btn-group">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Save this data"><i class="fa fa-check"></i> Save</button>
                                </div>
                            </div>

                            <?php echo form_close(); ?>
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
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>
    $(document).ready(function() {

        $('#table-TransSP').hide();
        $('#table-OrderSP').hide();
        $('#table-StockSP').hide();

        var table = $('#tableTransSP').DataTable({
            scrollY: "200px",
            scrollX: false,
            scrollCollapse: false,
            paging: false
        });
        $('.dataTables_filter input').attr('placeholder', 'Search');

        var table = $('#tableStockSP').DataTable({
            scrollY: "200px",
            scrollX: false,
            scrollCollapse: false,
            paging: false
        });
        $('.dataTables_filter input').attr('placeholder', 'Search');

        var table = $('#tableOrderSP').DataTable({
            scrollY: "200px",
            scrollX: false,
            scrollCollapse: false,
            paging: false
        });
        $('.dataTables_filter input').attr('placeholder', 'Search');

    });
</script>


<script type="text/javascript" language="javascript">
    function getDataLineStop(id) {
        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('mte/report_line_stop_c/get_data_repair_by_id_ls'); ?>",
            data: {
                INT_ID: id
            },
            success: function(json_data) {
                $("#INT_ID_LINE_STOP").val(json_data['INT_ID_LINE_STOP']);
                $("#CHR_MACHINE").val(json_data['CHR_MACHINE']);
                $("#CHR_PROBLEM").val(json_data['CHR_PROBLEM']);
                var pd;
                var ca;
                var notes;

                if (json_data['CHR_PROBLEM_DESC'] == null || json_data['CHR_PROBLEM_DESC'] == '') {
                    pd = '';
                } else {
                    pd = json_data['CHR_PROBLEM_DESC'];
                }

                if (json_data['CHR_CORRECTIVE_ACTION'] == null || json_data['CHR_CORRECTIVE_ACTION'] == '') {
                    ca = '';
                } else {
                    ca = json_data['CHR_CORRECTIVE_ACTION'];
                }

                if (json_data['CHR_NOTE'] == null || json_data['CHR_NOTE'] == '') {
                    notes = '';
                } else {
                    notes = json_data['CHR_NOTE'];
                }

                $("#CHR_PROBLEM_DESC").text(pd);
                $("#CHR_CORRECTIVE_ACTION").text(pd);
                $("#CHR_NOTE").text(notes);

                // $.ajax({
                //     async: false,
                //     type: "POST",
                //     dataType: 'json',
                //     url: "<?php echo site_url('mte/report_line_stop_c/get_data_spare_part'); ?>",
                //     data: {
                //         CHR_ENTRIED_DATE: json_data['CHR_CREATED_DATE'],
                //         LINE_STOP_TYPE: json_data['CHR_LINE_CODE']
                //     },
                //     success: function(json_data) {
                //         console.log(json_data['data']);
                //         $("#data_sparepart").html(json_data['data']);
                //     },
                //     error: function(request) {
                //         alert(request.responseText);
                //     }
                // });

            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function getDataSourceSparePart(id) {

        if (id == 0) {
            $('#table-TransSP').hide();
            $('#table-OrderSP').hide();
            $('#table-StockSP').hide();
            return false;
        } else if (id == 1) {
            $('#table-TransSP').show();
            $('#table-OrderSP').hide();
            $('#table-StockSP').hide();
        } else if (id == 2) {
            $('#table-TransSP').hide();
            $('#table-StockSP').show();
            $('#table-OrderSP').hide();
        } else if (id == 3) {
            $('#table-TransSP').hide();
            $('#table-StockSP').hide();
            $('#table-OrderSP').show();
        }
    }

    // function get_data_sparepart(date, ls) {
    //     $.ajax({
    //         async: false,
    //         type: "POST",
    //         dataType: 'json',
    //         url: "<?php echo site_url('mte/report_line_stop_c/get_data_spare_part'); ?>",
    //         data: {
    //             CHR_ENTRIED_DATE: date,
    //             LINE_STOP_TYPE: ls
    //         },
    //         success: function(json_data) {
    //             console.log(json_data['data']);
    //             $("#data_sparepart").html(json_data['data']);
    //         },
    //         error: function(request) {
    //             alert(request.responseText);
    //         }
    //     });
    // }

    function get_data_spec(e) {
        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('mte/report_line_stop_c/get_spec_spare_part'); ?>",
            data: {
                CHR_SPARE_PART_NAME: e
            },
            success: function(json_data) {
                $("#data_specification").html(json_data['data']);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function check_radio(e) {
        if (e.value == '1') {
            $('.spare-part-div').show();
        }
        if (e.value == '0') {
            $('.spare-part-div').hide();
        }
    }

    // function check_flg_spare(e, date, ls) {
    //     get_data_sparepart(date, ls);

    //     if (e == 1) {
    //         $('.spare-part-div').show();
    //     }

    //     if (e == 0) {
    //         $('.spare-part-div').hide();
    //     }

    // }
</script>