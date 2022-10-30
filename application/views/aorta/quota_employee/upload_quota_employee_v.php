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
        font-size: 11px;
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
    function exportTemplate() {
        alert('Save as data ke format .xlsx');
        tableToExcel('template_upload');
    }

    var tableToExcel = (function() {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="https://www.w3.org/TR/html40/"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
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
                worksheet: name || <?php echo $period; ?>,
                table: table.innerHTML
            }
            window.location.href = uri + base64(format(template, ctx))
        }
    })()
</script>

<script>
    // setTimeout(function() {
    //     document.getElementById("hide-sub-menus").click();
    // }, 15);
</script>

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/aorta/quota_employee_c/"') ?>">Manage Quota Employee</a></li>
            <li class="active"> <a href="#"><strong>Upload Quota Employee</strong></a></li>
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
                        <span class="grid-title"><strong>REQUEST QUOTA DEPT <?php echo $dept . ' PERIOD ' . $period ?> </strong></span>
                        <div class="pull-right grid-tools">
                            <a onclick="exportTemplate()" data-toggle="tooltip" data-placement="right" title="Download template"><i class="fa fa-download"></i>&nbsp; Download template <?php echo 'Dept ' . $dept ?></a>
                        </div>
                    </div>
                    <div class="grid-body" style="padding-top: 25px;">
                        <?php echo form_open_multipart('aorta/quota_employee_c/upload_quota_employee', 'class="form-horizontal"'); ?>

                        <input type="hidden" name="CHR_DEPT" value="<?php echo $dept; ?>"></input>
                        <input type="hidden" name="CHR_SECTION" value="<?php echo $section; ?>"></input>

                        <div class="pull" style="margin-top: -20px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Periode</strong></td>
                                    <td width="25%">
                                        <select class="ddl" name="CHR_PERIOD" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -2; $x <= 2; $x++) { $y = $x * 28 ?>
                                                <option value="<?php echo site_url('aorta/quota_employee_c/create_quota_employee/' . date("Ym", strtotime("+$y day")) . '/' . $dept); ?>" <?php if ($period == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                echo 'selected';
                                                                                                                                                                                            } ?>>
                                                    <?php echo date("M Y", strtotime("+$y day")); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>

                                    <td width="20%"></td>

                                    <td width="5%" style='text-align:right;'>
                                        <strong>Reason</strong>
                                    </td>
                                    <td width="50%" style='text-align:right;'>
                                        <div>
                                            <textarea id="reason" name="CHR_REASON" rows="2" cols="500" class="form-control" placeholder="Please detail your quota request" maxlength="400">Quota Standar</textarea>
                                        </div>
                                    </td>

                            </table>
                        </div>

                        <div class="pull" style="margin-top: -15px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>File (.xlsx)</strong></td>
                                    <td width="27%" style='text-align:left;' colspan="3">
                                        <input type="file" name="upload_quota" class="form-control" id="upload" required>
                                    </td>
                                    <td width="43%">
                                        <button style="margin-left:-5px;margin-top:4px;" type="submit" name="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="right" title="Lets Processing data"><i class="fa fa-upload"></i> Verifikasi Upload</button>
                                    </td>
                                    <td width="10%" style='text-align:right;'> </td>
                                    <td width="10%" style='text-align:right;'> </td>
                            </table>
                        </div>

                        <div class="pull" style="margin-top: -10px;">
                            <table width="100%" id='filter' border=0>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Quota Type</td>
                                    <td width="10%" style='text-align:left;' colspan="5">
                                        <label class="container-radio">Quota Standar<input type="radio" name="INT_TYPE_QUOTA" value="0" id="enable" checked>
                                            <span class="checkmark"></span>
                                        </label>

                                    </td>
                                    <td width="10%">
                                        <label class="container-radio">Quota Tambahan<input type="radio" name="INT_TYPE_QUOTA" value="1" id="disable">
                                            <span class="checkmark"></span>
                                        </label>
                                    </td>
                                    <td width="70%" style='text-align:right;'>
                                    </td>
                            </table>
                        </div>

                        <?php echo form_close(); ?>
                    </div>

                    <?php echo form_open('aorta/quota_employee_c/save_temp_quota_employee', 'class="form-horizontal"'); ?>

                    <input type="hidden" name="CHR_PERIOD" value="<?php echo $period; ?>"></input>
                    <input type="hidden" name="CHR_DEPT" value="<?php echo $dept; ?>"></input>
                    <input type="hidden" name="CHR_SECTION" value="<?php echo $section; ?>"></input>

                    <div class="grid-body" style="padding-top: 0px;">
                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Name</th>
                                        <th colspan="5" style="vertical-align: middle;text-align:center;">Quota Production (H)</th>
                                        <th colspan="5" style="vertical-align: middle;text-align:center;">Quota Improvement (H)</th>
                                        <th rowspan="2" style="vertical-align: middle;text-align:center;">Alasan</th>

                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>

                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>

                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>

                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>
                                        <th rowspan="2" style='display:none;'></th>

                                    </tr>
                                    <tr>
                                        <td style="text-align:center;background: #F4F4F4">Current</td>
                                        <td style='text-align:center;background: #F4F4F4'>Used</td>
                                        <td style='text-align:center;background: #F4F4F4'>Before</td>
                                        <td style='text-align:center;background: #F4F4F4'>Request</td>
                                        <td style='text-align:center;background: #F4F4F4'>After</td>

                                        <td style='text-align:center;background: #F4F4F4'>Current</td>
                                        <td style='text-align:center;background: #F4F4F4'>Used</td>
                                        <td style='text-align:center;background: #F4F4F4'>Before</td>
                                        <td style='text-align:center;background: #F4F4F4'>Request</td>
                                        <td style='text-align:center;background: #F4F4F4'>After</td>
                                    </tr>

                                </thead>
                                <tbody>
                                    <?php
                                    $tot_qr_pr = 0;
                                    $tot_saldo_pr = 0;
                                    $tot_qr_im = 0;
                                    $tot_saldo_im = 0;

                                    $x = 1;
                                    for ($y = 0; $y < $increment; $y++) {
                                        if ($data[$y]['FLG_DELETE'] == 1) {
                                            $stat = "background:#FE2D45;";
                                        } else {
                                            $stat = "background:#55D785;";
                                        }

                                    ?>

                                        <tr class='gradeX'>
                                            <td><?php echo $x ?></td>
                                            <td><input name="tableRow[<?php echo $y; ?>][NPK]" type='text' value="<?php echo $data[$y]['NPK']; ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td><input name="tableRow[<?php echo $y; ?>][NAMA]" type='text' value="<?php echo $data[$y]['NAMA']; ?>" readonly style='border:none;width:200px;background:transparent;'></input></td>

                                            <td style='text-align:center;'><input name="tableRow[<?php echo $y; ?>][SISA_QUOTA_PR]" type='text' value="<?php echo number_format($data[$y]['SISA_QUOTA_PR'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td style='text-align:center;'><input name="tableRow[<?php echo $y; ?>][TERPAKAI_QUOTA_PR]" type='text' value="<?php echo number_format($data[$y]['TERPAKAI_QUOTA_PR'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td style='text-align:center;'><input name="tableRow[<?php echo $y; ?>][SALDO_QUOTA_PR]" type='text' value="<?php echo number_format($data[$y]['SALDO_QUOTA_PR'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td style='text-align:center;font-weight:700;'><input name="tableRow[<?php echo $y; ?>][QUANTITY_QUOTA_PR]" type='text' value="<?php echo number_format($data[$y]['QUANTITY_QUOTA_PR'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td style='text-align:center;'><input name="tableRow[<?php echo $y; ?>][NEXT_SALDO_PR]" type='text' value="<?php echo number_format($data[$y]['NEXT_SALDO_PR'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>

                                            <td style='text-align:center;'><input name="tableRow[<?php echo $y; ?>][SISA_QUOTA_IM]" type='text' value="<?php echo number_format($data[$y]['SISA_QUOTA_IM'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td style='text-align:center;'><input name="tableRow[<?php echo $y; ?>][TERPAKAI_QUOTA_IM]" type='text' value="<?php echo number_format($data[$y]['TERPAKAI_QUOTA_IM'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td style='text-align:center;'><input name="tableRow[<?php echo $y; ?>][SALDO_QUOTA_IM]" type='text' value="<?php echo number_format($data[$y]['SALDO_QUOTA_IM'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td style='text-align:center;font-weight:700;'><input name="tableRow[<?php echo $y; ?>][QUANTITY_QUOTA_IM]" type='text' value="<?php echo number_format($data[$y]['QUANTITY_QUOTA_IM'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td style='text-align:center;'><input name="tableRow[<?php echo $y; ?>][NEXT_SALDO_IM]" type='text' value="<?php echo number_format($data[$y]['NEXT_SALDO_IM'], 2, ',', '.'); ?>" readonly style='border:none;width:35px;background:transparent;'></input></td>
                                            <td style='text-align:left;color:#fff;<?php echo $stat ?>;'><?php echo $data[$y]['ERROR_MESSAGE'] ?></td>

                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][ALASAN]" type='hidden' value="<?php echo $data[$y]['ALASAN']; ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][FLG_DELETE]" type='hidden' value="<?php echo $data[$y]['FLG_DELETE']; ?>"></input></td>

                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][ADJ_QUOTA_PR_BULAN]" type='hidden' value="<?php echo number_format($data[$y]['ADJ_QUOTA_PR_BULAN'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][ADJ_QUOTA_IM_BULAN]" type='hidden' value="<?php echo number_format($data[$y]['ADJ_QUOTA_IM_BULAN'], 2, ',', '.'); ?>"></input></td>

                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_1]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_1'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_2]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_2'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_3]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_3'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_4]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_4'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_5]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_5'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_6]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_6'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_7]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_7'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_8]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_8'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_9]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_9'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_10]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_10'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_11]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_11'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_12]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_12'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_13]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_13'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_14]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_14'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_15]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_15'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_16]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_16'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_17]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_17'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_18]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_18'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_19]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_19'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_20]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_20'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_21]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_21'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_22]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_22'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_23]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_23'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_24]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_24'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_25]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_25'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_26]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_26'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_27]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_27'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_28]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_28'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_29]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_29'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_30]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_30'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_PR_DAY_31]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_PR_DAY_31'], 2, ',', '.'); ?>"></input></td>

                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_1]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_1'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_2]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_2'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_3]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_3'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_4]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_4'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_5]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_5'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_6]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_6'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_7]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_7'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_8]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_8'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_9]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_9'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_10]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_10'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_11]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_11'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_12]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_12'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_13]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_13'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_14]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_14'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_15]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_15'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_16]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_16'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_17]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_17'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_18]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_18'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_19]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_19'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_20]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_20'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_21]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_21'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_22]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_22'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_23]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_23'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_24]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_24'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_25]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_25'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_26]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_26'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_27]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_27'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_28]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_28'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_29]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_29'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_30]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_30'], 2, ',', '.'); ?>"></input></td>
                                            <td style='display:none;'><input name="tableRow[<?php echo $y; ?>][QUOTA_IM_DAY_31]" type='hidden' value="<?php echo number_format($data[$y]['QUOTA_IM_DAY_31'], 2, ',', '.'); ?>"></input></td>

                                        </tr>

                                    <?php
                                        $x++;
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px>
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>NB : </strong></td>
                                    <td width="10%">
                                        Request quota dengan pesan error tidak akan terupload ke sistem.
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="pull-right" style="padding-left:600px;margin-top: -40px;">

                            <div style="float:right;">
                                <?php if ($data == true) { ?>
                                    <button id='btnPrepareSubmit' type="submit" name="submit" class="btn btn-success" value="1" data-toggle="tooltip" data-placement="right" title="Save this data" style="width:180px;"><i class="fa fa-check"></i> Save</button>
                                    <button id="btnTrueSubmit" type="submit" style="display:none;">True Save</button>
                                <?php } else { ?>
                                    <button id='btnPrepareSubmit' type="submit" name="submit" disabled class="btn btn-success" data-toggle="tooltip" data-placement="right" title="first, u must process the upload file" style="width:180px;"><i class="fa fa-check"></i> Save</button>
                                <?php } ?>
                                <a href="<?php echo base_url('index.php/aorta/quota_employee_c/index/' . $period . '/' . $dept . '/' . $section) ?>" class="btn btn-default" data-toggle="tooltip" data-placement="left" title="Back">Back</a>

                            </div>

                            <?php echo form_close(); ?>
                        </div>

                    </div>

                    <div class="grid-body" style="padding-top: 0px;display:block;">
                        <div id="table-luar">
                            <table id="template_upload" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align:center;;" rowspan="2">No</th>
                                        <th style="text-align:center;;" rowspan="2">NPK</th>
                                        <th style="text-align:center;;" rowspan="2">Name</th>
                                        <th style="vertical-align: middle;text-align:center;" colspan="<?php echo $dayCount; ?>">Production</th>
                                        <th style="vertical-align: middle;text-align:center;" colspan="<?php echo $dayCount; ?>">Improvement</th>
                                        <th style="vertical-align: middle;text-align:center;" colspan="2">Total</th>
                                    </tr>
                                    <tr>
                                        <?php for ($x = 1; $x <= $dayCount; $x++) { ?>
                                            <td style="text-align:center;"><?php echo $x; ?></td>
                                        <?php } ?>

                                        <?php for ($y = 1; $y <= $dayCount; $y++) { ?>
                                            <td style="text-align:center;"><?php echo $y; ?></td>
                                        <?php } ?>

                                        <td style="text-align:center;">PRD</td>
                                        <td style="text-align:center;">IMV</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $x = 1;
                                    $excel = 3;
                                    foreach ($data_template as $isi) {
                                        echo "<tr>";
                                        echo "<td style='text-align:center;' >$x</td>";
                                        echo "<td style='text-align:center;' >'$isi->NPK</td>";
                                        echo "<td style='text-align:left;' >$isi->NAMA</td>";
                                        for ($z = 1; $z <= $dayCount; $z++) {
                                            echo "<td>0</td>";
                                        }
                                        for ($y = 1; $y <= $dayCount; $y++) {
                                            echo "<td>0</td>";
                                        }
                                        if ($dayCount == 28) {
                                            echo "<td style='text-align:center;' >=SUM(D$excel:AE$excel)</td>";
                                            echo "<td style='text-align:center;' >=SUM(AF$excel:BG$excel)</td>";
                                        } else if ($dayCount == 29) {
                                            echo "<td style='text-align:center;' >=SUM(D$excel:AF$excel)</td>";
                                            echo "<td style='text-align:center;' >=SUM(AG$excel:BI$excel)</td>";
                                        } else if ($dayCount == 30) {
                                            echo "<td style='text-align:center;' >=SUM(D$excel:AG$excel)</td>";
                                            echo "<td style='text-align:center;' >=SUM(AH$excel:BK$excel)</td>";
                                        } else if ($dayCount == 31) {
                                            echo "<td style='text-align:center;' >=SUM(D$excel:AH$excel)</td>";
                                            echo "<td style='text-align:center;' >=SUM(AI$excel:BM$excel)</td>";
                                        }
                                        echo "</tr>";
                                        $x++;
                                        $excel++;
                                    }
                                    ?>
                                </tbody>
                            </table>
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
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        var table = $('#example').DataTable({
            scrollY: "400px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 3
            }
        });

        $('.dataTables_filter input').attr('placeholder', 'Search');
    });

    //add by toro
    $("#btnPrepareSubmit").on('click', function(event) {

        if (confirm('Data yang mempunyai pesan error tidak akan terupload, teruskan?')) {
            event.preventDefault();
            var el = $(this);
            $("#btnTrueSubmit").click();
            el.prop('disabled', true);
            return true;
        } else {
            return false;
        }

    });
</script>
<script type="text/javascript" language="javascript">
    $("#upload").fileinput({
        'showUpload': false
    });
</script>