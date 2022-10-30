<script>
    $(document).ready(function() {

        $('input').change(function() {

            $(this).toggleClass('redBackground', $(this).val() < 0);
            $(this).toggleClass('greenBackground', $(this).val() > 0);

        });

        $('input').keypress(function(event) {
            if (event.keyCode == 13) {
                event.preventDefault();
            }
        });

    });
</script>
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

    input.redBackground {
        color: #FE2D45;
    }

    input.greenBackground {
        color: #55D785;
    }
</style>

<aside class="right-side">

    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/home_c/"') ?>">Home</a></li>
            <li><a href="<?php echo base_url('index.php/aorta/quota_employee_c/"') ?>">Manage Quota Employee</a></li>
            <li class="active"> <a href="#"><strong>Balancing Quota Employee</strong></a></li>
        </ol>
    </section>

    <section class="content">

        <div id='message-error' class='alert alert-danger' style='display:none;'></div>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-refresh"></i>
                        <span class="grid-title"><strong>BALANCING QUOTA PRODUCTION</strong></span>
                        <div class="pull-right grid-tools">
                        </div>
                    </div>

                    <?php echo form_open('aorta/quota_employee_c/balancing_quota', 'class="form-horizontal"'); ?>

                    <div class="grid-body" style="padding-top: 25px;">
                        <div class="pull" style="margin-top: -20px;">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Dept / Section</strong></td>
                                    <td width="10%" style='text-align:left;'>
                                        <select style="width:150px;" class="form-control" name='CHR_DEPT' onchange="get_data_section_by_dept(this.value)">
                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<?php echo trim($row->CHR_DEPT); ?>" <?php
                                                                                                    if (trim($dept) == trim($row->CHR_DEPT)) {
                                                                                                        echo 'SELECTED';
                                                                                                    }
                                                                                                    ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;'>
                                        <select style="width:100px;" class="form-control" name='CHR_SECTION' id='section'>
                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<?php echo $row->KODE; ?>" <?php
                                                                                            if ($section == $row->KODE) {
                                                                                                echo 'SELECTED';
                                                                                            }
                                                                                            ?>><?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="70%" style='text-align:right;'>
                                    </td>

                                </tr>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Periode</strong></td>
                                    <td width="10%">
                                        <select style="width:150px;" class="form-control" name='CHR_PERIOD'>
                                            <?php for ($x = -3; $x <= 0; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<?php echo date("Ym", strtotime("+$y day")); ?>" <?php
                                                                                                                if ($period == date("Ym", strtotime("+$y day"))) {
                                                                                                                    echo 'SELECTED';
                                                                                                                }
                                                                                                                ?>> <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;'>
                                        <button type='submit' class="btn btn-info" data-toggle="tooltip" data-placement="right" title="Filter this data" style="width:100px;padding:7px;margin-top:-2px;margin-bottom:-2px;"><i class="fa fa-filter"></i> Filter</button>
                                    </td>
                                    <td width="70%" style='text-align:left;'>
                                    </td>
                                </tr>

                            </table>
                        </div>
                    </div>

                    <?php echo form_close(); ?>

                    <?php echo form_open('aorta/quota_employee_c/update_balancing_quota_employee', 'class="form-horizontal"'); ?>

                    <div class="grid-body" style="padding-top: 0px;">

                        <div id="table-luar">
                            <table id="example" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="text-align:center;"></th>
                                        <th rowspan="2" style="vertical-align:center;text-align:center;">NPK</th>
                                        <th rowspan="2" style="vertical-align:center;text-align:center;">Nama</th>
                                        <th colspan="3" style="text-align:center;">Production</th>
                                        <th rowspan="2" style="text-align:center;">Incr <span style='color:#55D785;'>(+)</span>/Decr <span style='color:#FE2D45;'>(-)</span></th>
                                        <th rowspan="2" style="text-align:center;">To be</th>
                                        <th rowspan="2" style="text-align:center;display:none;"></th>
                                        <!-- <th style="text-align:center;color:#BCBDBE;border-left: 1px solid #DDDDDD;">Quota</th> -->
                                        <!-- <th style="text-align:center;color:#BCBDBE;">Used</th>
                                        <th style="text-align:center;">Remain</th>-->
                                        <th rowspan="2" style="text-align:center;display:none;"></th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:center;color:#BCBDBE;">Quota</th>
                                        <th style="text-align:center;color:#BCBDBE;">Used</th>
                                        <th style="text-align:center;color:#BCBDBE;">Remain</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($x = 0; $x < count($data); $x++) { ?>

                                        <tr class='gradeX'>
                                            <td style='text-align:center;'><?php echo $data[$x]['NO']; ?></td>
                                            <td style='text-align:center;'><strong><input type='text' readonly name='tableRow[<?php echo $x; ?>][NPK]' style='width:35px;font-weight:600;text-align:center;border:none;outline:none;background:rgba(0, 0, 0, 0);' value='<?php echo $data[$x]['NPK']; ?>'></strong></td>
                                            <td style='text-align:left;border-right: 1px solid #DDDDDD;'><?php echo $data[$x]['NAMA']; ?></td>
                                            <td style='text-align:center;color:#BCBDBE;border-left: 1px solid #DDDDDD;'><strong><?php echo str_replace('.', ',', $data[$x]['QUOTAPLAN']) ?></strong></td>
                                            <td style='text-align:center;color:#BCBDBE;'><strong><?php echo str_replace('.', ',', $data[$x]['TERPAKAIPLAN']) ?></strong></td>
                                            <td style='text-align:center;'><strong><input type='text' readonly name='tableRow[<?php echo $x; ?>][SISAPLAN]' style='width:50px;font-weight:600;text-align:center;border:none;outline:none;background:rgba(0, 0, 0, 0);' value='<?php echo str_replace('.', ',', $data[$x]['SISAPLAN']) ?>'></strong></td>
                                            <td style='text-align:center;border-left: 1px solid #DDDDDD;'><strong><input type='number' name='tableRow[<?php echo $x; ?>][INT_REQ]' style='width:60px;font-weight:600;text-align:center;' class='input-quota' value='0'></td>
                                            <td style='text-align:center;border-left: 1px solid #DDDDDD;'><strong><input type='text' readonly style='width:50px;font-weight:600;text-align:center;border:none;outline:none;background:rgba(0, 0, 0, 0);'></strong></td>
                                            <td style='text-align:center;border-left: 1px solid #DDDDDD;display:none;'><input type='text' name='tableRow[<?php echo $x; ?>][INT_FLG_UPDATE]' readonly style='width:50px;font-weight:600;text-align:center;border:none;outline:none;background:rgba(0, 0, 0, 0);'></td>
                                            <!-- <td style='text-align:center;color:#BCBDBE;border-left: 1px solid #DDDDDD;'><strong>" . str_replace('.', ',', $data[$x]['QUOTAPLAN1']) . "</strong></td>
                                            <td style='text-align:center;color:#BCBDBE;'><strong>" . str_replace('.', ',', $data[$x]['TERPAKAIPLAN1']) . "</strong></td>
                                            <td style='text-align:center;'><strong>" . str_replace('.', ',', $data[$x]['SISAPLAN1']) . "</strong></td> -->
                                            <td style='text-align:center;display:none;'><?php echo $data[$x]['NPK']; ?></td>
                                        </tr>

                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px>
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>NB : </strong></td>
                                    <td width="10%">
                                        Quota for Period <input type="text" disabled style="text-weight:500;background:yellow;color:black;padding:5px;height:20px;width:55px;border: none;border-color: transparent;" value="<?php echo $period; ?>"></input>
                                        for Department <strong style="background:yellow;color:black;"><input type="text" disabled style="text-weight:500;background:yellow;color:black;padding:5px;height:20px;width:45px;border: none;border-color: transparent;" value="<?php echo $dept; ?>"></input></strong>
                                        for Section <strong style="background:yellow;color:black;"><input type="text" disabled style="text-weight:500;background:yellow;color:black;padding:5px;height:20px;width:45px;border: none;border-color: transparent;" value="<?php echo $section; ?>"></input></strong>
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="pull-right" style="padding-left:600px;margin-top: -40px;">

                            <input type="hidden" name="CHR_PERIOD" value="<?php echo $period; ?>"></input>
                            <input type="hidden" name="CHR_DEPT" value="<?php echo $dept; ?>"></input>
                            <input type="hidden" name="CHR_SECTION" value="<?php echo $section; ?>"></input>

                            <div style="float:right;">
                                <button type='button' id='button-verify' class="btn btn-default" style="width:160px;" onclick='checkdata();' value='1'><i class="fa fa-check"></i> Verify</button>
                                <button id='button-save' type="submit" style='display:none;' name="submit" class="btn btn-success" value="1" data-toggle="tooltip" data-placement="right" title="Save this data" onclick='return confirm("Apakah anda sudah yakin dengan data yang akan diupdate ?")'><i class="fa fa-save"></i> Save</button>
                            </div>

                        </div>

                    </div>

                    <?php echo form_close(); ?>

                </div>
            </div>
        </div>

        <div id='message-error-improvement' class='alert alert-danger' style='display:none;'></div>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-refresh"></i>
                        <span class="grid-title"><strong>BALANCING QUOTA IMPROVEMENT</strong></span>
                        <div class="pull-right grid-tools">
                        </div>
                    </div>

                    <?php echo form_open('aorta/quota_employee_c/update_balancing_quota_employee_improvement', 'class="form-horizontal"'); ?>

                    <div class="grid-body">

                        <div id="table-luar">
                            <table id="quota_improvement" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="text-align:center;"></th>
                                        <th rowspan="2" style="vertical-align:center;text-align:center;">NPK</th>
                                        <th rowspan="2" style="vertical-align:center;text-align:center;">Nama</th>
                                        <th colspan="3" style="text-align:center;">Improvement</th>
                                        <th rowspan="2" style="text-align:center;">Incr <span style='color:#55D785;'>(+)</span>/Decr <span style='color:#FE2D45;'>(-)</span></th>
                                        <th rowspan="2" style="text-align:center;">To be</th>
                                        <th rowspan="2" style="text-align:center;display:none;"></th>
                                        <th rowspan="2" style="text-align:center;display:none;"></th>
                                    </tr>
                                    <tr>
                                        <th style="text-align:center;color:#BCBDBE;">Quota</th>
                                        <th style="text-align:center;color:#BCBDBE;">Used</th>
                                        <th style="text-align:center;color:#BCBDBE;">Remain</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    for ($x = 0; $x < count($data); $x++) { ?>

                                        <tr class='gradeX'>
                                            <td style='text-align:center;'><?php echo $data[$x]['NO']; ?></td>
                                            <td style='text-align:center;'><strong><input type='text' readonly name='tableRowImprovement[<?php echo $x; ?>][NPK]' style='width:35px;font-weight:600;text-align:center;border:none;outline:none;background:rgba(0, 0, 0, 0);' value='<?php echo $data[$x]['NPK']; ?>'></strong></td>
                                            <td style='text-align:left;border-right: 1px solid #DDDDDD;'><?php echo $data[$x]['NAMA']; ?></td>
                                            <td style='text-align:center;color:#BCBDBE;border-left: 1px solid #DDDDDD;'><strong><?php echo str_replace('.', ',', $data[$x]['QUOTAPLAN1']) ?></strong></td>
                                            <td style='text-align:center;color:#BCBDBE;'><strong><?php echo str_replace('.', ',', $data[$x]['TERPAKAIPLAN1']) ?></strong></td>
                                            <td style='text-align:center;'><strong><input type='text' readonly name='tableRowImprovement[<?php echo $x; ?>][SISAPLAN1]' style='width:50px;font-weight:600;text-align:center;border:none;outline:none;background:rgba(0, 0, 0, 0);' value='<?php echo str_replace('.', ',', $data[$x]['SISAPLAN1']) ?>'></strong></td>
                                            <td style='text-align:center;border-left: 1px solid #DDDDDD;'><strong><input type='number' name='tableRowImprovement[<?php echo $x; ?>][INT_REQ]' style='width:60px;font-weight:600;text-align:center;' class='input-quota-improvement' value='0'></td>
                                            <td style='text-align:center;border-left: 1px solid #DDDDDD;'><strong><input type='text' readonly style='width:50px;font-weight:600;text-align:center;border:none;outline:none;background:rgba(0, 0, 0, 0);'></strong></td>
                                            <td style='text-align:center;border-left: 1px solid #DDDDDD;display:none;'><input type='text' name='tableRowImprovement[<?php echo $x; ?>][INT_FLG_UPDATE]' readonly style='width:50px;font-weight:600;text-align:center;border:none;outline:none;background:rgba(0, 0, 0, 0);'></td>
                                            <td style='text-align:center;display:none;'><?php echo $data[$x]['NPK']; ?></td>
                                        </tr>

                                    <?php }
                                    ?>
                                </tbody>
                            </table>
                        </div>

                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px>
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>NB : </strong></td>
                                    <td width="10%">
                                        Quota for Period <input type="text" disabled style="text-weight:500;background:yellow;color:black;padding:5px;height:20px;width:55px;border: none;border-color: transparent;" value="<?php echo $period; ?>"></input>
                                        for Department <strong style="background:yellow;color:black;"><input type="text" disabled style="text-weight:500;background:yellow;color:black;padding:5px;height:20px;width:45px;border: none;border-color: transparent;" value="<?php echo $dept; ?>"></input></strong>
                                        for Section <strong style="background:yellow;color:black;"><input type="text" disabled style="text-weight:500;background:yellow;color:black;padding:5px;height:20px;width:45px;border: none;border-color: transparent;" value="<?php echo $section; ?>"></input></strong>
                                    </td>
                                    <td width="10%">
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <div class="pull-right" style="padding-left:600px;margin-top: -40px;">

                            <input type="hidden" name="CHR_PERIOD" value="<?php echo $period; ?>"></input>
                            <input type="hidden" name="CHR_DEPT" value="<?php echo $dept; ?>"></input>
                            <input type="hidden" name="CHR_SECTION" value="<?php echo $section; ?>"></input>

                            <div style="float:right;">
                                <button type='button' id='button-verify-improvement' class="btn btn-default" style="width:160px;" onclick='checkdataBalanceImprovementQuota();' value='1'><i class="fa fa-check"></i> Verify</button>
                                <button id='button-save-improvement' type="submit" style='display:none;' name="submit" class="btn btn-success" value="1" data-toggle="tooltip" data-placement="right" title="Save this data" onclick='return confirm("Apakah anda sudah yakin dengan data yang akan diupdate ?")'><i class="fa fa-save"></i> Save</button>
                            </div>

                        </div>

                    </div>

                    <?php echo form_close(); ?>

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
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 0
            }
        });

        var table = $('#quota_improvement').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            fixedColumns: {
                leftColumns: 0
            }
        });

        $('.dataTables_filter input').attr('placeholder', 'Search');
    });

    function get_data_section_by_dept(KODE) {
        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('aorta/quota_employee_c/get_section_by_dept'); ?>",
            data: {
                KODE: KODE
            },
            success: function(json_data) {
                $("#section").html(json_data['data']);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }

    function checkdata() {
        if ($("#button-verify").val() == '1') {
            var total = 0;
            var negative = 0;
            var positif = 0;
            var status = true;
            $("#example > tbody > tr").each(function() {
                var quota_req = parseFloat($(this).find("td:eq(6) input[type='number']").val());

                if (isNaN(quota_req)) {
                    quota_req = 0;
                }

                total = parseFloat(total) + (quota_req);

                if (quota_req < 0) {
                    negative = parseFloat(negative) + (quota_req);
                } else {
                    positif = parseFloat(positif) + (quota_req);
                }

                var result = parseFloat($(this).find("td:eq(5) input[type='text']").val().replace(",", ".")) + (quota_req);

                $(this).find("td:eq(7) input[type='text']").val(result.toFixed(2));

                if (result.toFixed(2) < 0) {
                    $(this).find("td:eq(7) input[type='text']").css('color', '#FE2D45');
                    status = false;
                } else {
                    $(this).find("td:eq(7) input[type='text']").css('color', '#666666');
                }

                if (quota_req == 0) {
                    $(this).find("td:eq(8) input[type='text']").val(0);
                } else {
                    $(this).find("td:eq(8) input[type='text']").val(1);
                }

            });

            if (status == true) {
                if (positif + (negative) == 0) {

                    $('#button-save').show();
                    $('#button-save').width('160px');

                    $('.input-quota').prop('readonly', true);
                    $('#button-verify').html("<i class='fa fa-refresh'></i> Cancel");
                    $('#button-verify').val('0');
                    $('#message-error').hide();

                } else {

                    $('#message-error').show();
                    $('#message-error').html("<strong> Terjadi galat </strong> Quota yang ditambah (" + positif + ") ,harus sama dengan yang dikurangi (" + negative + ") , Quota over " + total);
                    $('#button-save').hide();
                    $('#button-verify').html("<i class='fa fa-check'></i> Verify");
                    $('#button-verify').val('1');
                    $('.input-quota').prop('readonly', false);
                    $('.scroll-to-top').click();

                }
            } else {
                $('#message-error').show();
                $('#message-error').html("<strong> Terjadi galat </strong> Pengurangan quota production tidak boleh lebih dari sisa quota");
                $('#button-save').hide();
                $('#button-verify').html("<i class='fa fa-check'></i> Verify");
                $('#button-verify').val('1');
                $('.input-quota').prop('readonly', false);
                $('.scroll-to-top').click();
            }
        } else {
            // $('#message-error').hide();
            $('#button-save').hide();
            $('#button-verify').html("<i class='fa fa-check'></i> Verify");
            $('#button-verify').val('1');
            $('.input-quota').prop('readonly', false);
        }
    }

    function checkdataBalanceImprovementQuota() {
        if ($("#button-verify-improvement").val() == '1') {
            var total = 0;
            var negative = 0;
            var positif = 0;
            var status = true;
            $("#quota_improvement > tbody > tr").each(function() {
                var quota_req = parseFloat($(this).find("td:eq(6) input[type='number']").val());

                if (isNaN(quota_req)) {
                    quota_req = 0;
                }

                total = parseFloat(total) + (quota_req);

                if (quota_req < 0) {
                    negative = parseFloat(negative) + (quota_req);
                } else {
                    positif = parseFloat(positif) + (quota_req);
                }

                var result = parseFloat($(this).find("td:eq(5) input[type='text']").val().replace(",", ".")) + (quota_req);

                $(this).find("td:eq(7) input[type='text']").val(result.toFixed(2));

                if (result.toFixed(2) < 0) {
                    $(this).find("td:eq(7) input[type='text']").css('color', '#FE2D45');
                    status = false;
                } else {
                    $(this).find("td:eq(7) input[type='text']").css('color', '#666666');
                }

                if (quota_req == 0) {
                    $(this).find("td:eq(8) input[type='text']").val(0);
                } else {
                    $(this).find("td:eq(8) input[type='text']").val(1);
                }

            });

            if (status == true) {
                if (positif + (negative) == 0) {

                    $('#button-save-improvement').show();
                    $('#button-save-improvement').width('160px');

                    $('.input-quota-improvement').prop('readonly', true);
                    $('#button-verify-improvement').html("<i class='fa fa-refresh'></i> Cancel");
                    $('#button-verify-improvement').val('0');
                    $('#message-error-improvement').hide();

                } else {

                    $('#message-error-improvement').show();
                    $('#message-error-improvement').html("<strong> Terjadi galat </strong> Quota yang ditambah (" + positif + ") ,harus sama dengan yang dikurangi (" + negative + ") , Quota over " + total);
                    $('#button-save-improvement').hide();
                    $('#button-verify-improvement').html("<i class='fa fa-check'></i> Verify");
                    $('#button-verify-improvement').val('1');
                    $('.input-quota-improvement').prop('readonly', false);
                    $('.scroll-to-top').click();

                }
            } else {
                $('#message-error-improvement').show();
                $('#message-error-improvement').html("<strong> Terjadi galat </strong> Pengurangan quota improvement tidak boleh lebih dari sisa quota");
                $('#button-save-improvement').hide();
                $('#button-verify-improvement').html("<i class='fa fa-check'></i> Verify");
                $('#button-verify-improvement').val('1');
                $('.input-quota-improvement').prop('readonly', false);
                $('.scroll-to-top').click();
            }
        } else {
            // $('#message-error').hide();
            $('#button-save-improvement').hide();
            $('#button-verify-improvement').html("<i class='fa fa-check'></i> Verify");
            $('#button-verify-improvement').val('1');
            $('.input-quota-improvement').prop('readonly', false);
        }
    }
</script>