<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }

    #table-luar {
        font-size: 12px;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 100px;
    }

    .ddl {
        width: 100px;
        height: 30px;
    }

    .ddl2 {
        width: 180px;
        height: 30px;
    }

    .fileUpload {
        position: relative;
        overflow: hidden;
        width: 100px;
        margin-left: 15px;
    }

    .fileUpload input.upload {
        position: absolute;
        top: 0;
        right: 0;
        margin: 0;
        padding: 0;
        font-size: 20px;
        cursor: pointer;
        opacity: 0;
        filter: alpha(opacity=0);
    }

    .input-upload {
        border: none;
        width: 50px;
        background: transparent;
        text-align: right;
    }

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
</style>

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

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/part/process_part_c/"') ?>">Cycle Time</a></li>
            <li class="active"> <a href="#"><strong>Upload Cycle Time</strong></a></li>
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
                        <i class="fa fa-upload"></i>
                        <span class="grid-title"><strong>UPLOAD CYCLE TIME</strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/part/process_part_c/getTemplate') . "/" . $work_center;  ?>" data-placement="right" data-toggle="tooltip" title="Download template"><i class="fa fa-download"></i>&nbsp; Download template <?php echo $work_center ?></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%">Work Center
                                    </td>
                                    <td width="10%">
                                        <select id="e1" style='width:160px;' onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<?php echo site_url('part/process_part_c/create_process_part/' . trim($row->CHR_WORK_CENTER)); ?>" <?php
                                                                                                                                                                    if (trim($work_center) == trim($row->CHR_WORK_CENTER)) {
                                                                                                                                                                        echo 'selected';
                                                                                                                                                                    }
                                                                                                                                                                    ?>> <?php echo trim($row->CHR_WORK_CENTER); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="90%"></td>
                                </tr>
                            </table>
                        </div>

                        <?php echo form_open_multipart('part/process_part_c/uploadCycleTime', 'class="form-horizontal"'); ?>

                        <input type="hidden" name="CHR_WORK_CENTER" id="id_work_center" value="<?php echo $work_center; ?>"></input>

                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>File (.xlsx)</strong></td>
                                    <td width="27%" style='text-align:left;' colspan="3">
                                        <input type="file" name="upload_schedule" class="form-control" id="import" required>
                                    </td>
                                    <td width="43%">
                                        <button style="margin-left:-5px;margin-top:4px;" type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Lets Processing data"><i class="fa fa-upload"></i> Verifikasi Cek</button>
                                    </td>
                                    <td width="10%" style='text-align:right;'> </td>
                                    <td width="10%" style='text-align:right;'> </td>
                            </table>
                        </div>

                    </div>

                    <?php echo form_close(); ?>
                    <?php echo form_open('part/process_part_c/save_process_part', 'class="form-horizontal"'); ?>

                    <input type="hidden" name="CHR_WORK_CENTER" id="id_work_center" value="<?php echo $work_center; ?>"></input>

                    <div class="grid-body">
                        <div id="table-luar">
                            <table id="example2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;">No</th>
                                        <th style="text-align:center;">Work Center</th>
                                        <th style="text-align:center;">Part No</th>
                                        <th style="text-align:center;">Back No</th>
                                        <th style="text-align:center;">Cycle Time</th>
                                        <th style="text-align:center;">Man Power</th>
                                        <th style="text-align:center;display:none;">Flg Delete</th>
                                        <th style="white-space:pre-wrap ; word-wrap:break-word;text-align:center;"> Verification Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php

                                    $x = 1;
                                    for ($y = 0; $y < $increment; $y++) {
                                    ?>

                                        <tr class='gradeX'>
                                            <td><?php echo $x ?></td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_WORK_CENTER]" type='text' value="<?php echo $data[$y]['CHR_WORK_CENTER']; ?>" style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_PART_NO]" type='text' value="<?php echo $data[$y]['CHR_PART_NO']; ?>" style='border:none;width:150px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][CHR_BACK_NO]" type='text' value="<?php echo $data[$y]['CHR_BACK_NO']; ?>" style='border:none;width:150px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][INT_CYCLE_TIME]" type='text' value="<?php echo $data[$y]['INT_CYCLE_TIME']; ?>" style='border:none;width:150px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="text-align:center;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][INT_MP]" type='text' value="<?php echo $data[$y]['INT_MP']; ?>" style='border:none;width:150px;background:transparent;text-align:center;'></input>
                                            </td>
                                            <td style="display:none;">
                                                <input readonly name="tableRow[<?php echo $y; ?>][INT_FLG_DEL]" type='text' value="<?php echo $data[$y]['INT_FLG_DEL']; ?>" style='border:none;width:50px;background:transparent;text-align:center;'></input>
                                            </td>

                                            <?php

                                            if ($data[$y]['INT_FLG_DEL'] == 1) {
                                                $stat = "background:#FE2D45;color:#fff";
                                            } else {
                                                $stat = "background:#55D785;color:#fff";
                                            }
                                            ?>

                                        <?php

                                        if ($data[$y]['ERROR_MESSAGE']) {
                                            echo "<td style='$stat;white-space:pre-wrap ; word-wrap:break-word;text-align:left'><strong>" . $data[$y]['ERROR_MESSAGE'] . "</strong></td>";
                                        } else {
                                            echo "<td style='background:#55D785;color:#fff;white-space:pre-wrap ; word-wrap:break-word;text-align:left'><strong>-</strong></td>";
                                        }

                                        echo "</tr>";

                                        $x++;
                                    }
                                        ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="grid-body">
                        <div style="width: 30%;float:right;">
                            <table width="100%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>S t a t u s : </strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#FE2D45;width:50px;height:10px;color:white;'></button> : Failed
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#55D785;width:50px;height:10px;color:white;'></button> : Success
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <br>
                        <?php if ($data == true) { ?>
                            <button type="submit" name="submit" class="btn btn-success" value="1" data-toggle="tooltip" data-placement="right" title="Save this data" style="width:180px;" onclick='return confirm("Data yang bermasalah tidak akan disimpan, melanjutkan perintah ?")'><i class="fa fa-check"></i> Save</button>
                            <a href="<?php echo base_url('index.php/part/process_part_c/index/' . $work_center) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                        <?php } else { ?>
                            <button type="submit" name="submit" disabled class="btn btn-success" data-toggle="tooltip" data-placement="right" title="Save this data" style="width:180px;" onclick='return confirm("Data yang bermasalah tidak akan disimpan, melanjutkan perintah ?")'><i class="fa fa-check"></i> Save</button>
                            <a href="<?php echo base_url('index.php/part/process_part_c/index/' . $work_center) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>
                        <?php } ?>

                        <?php echo form_close(); ?>

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


<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>">
<script>
    $(document).ready(function() {
        var table = $('#example2').DataTable({
            scrollY: "250px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            bFilter: false,
            fixedColumns: {
                leftColumns: 0
            }
        });

    });
</script>