<script>
    $(document).ready(function() {
        var interval_close = setInterval(closeSideBar, 250);

        function closeSideBar() {
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>


<style type="text/css">
    th,
    td {
        white-space: nowrap;
    }

    div.dataTables_wrapper {
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
        width: 30px;
    }

    .td-no {
        width: 10px;
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
            <li><a href="<?php echo base_url('index.php/basis/home_c') ?>"><span>Home</span></a></li>
            <li><a href="<?php echo base_url('index.php/aorta/overtime_c') ?>"><strong>Manage Overtime </strong></a></li>
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
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>APPROVAL OVERTIME - MANAGER & GM</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                        <?php if ($dept == '-') {
                            echo '-';
                        } else if ($dept == 'MIS' || $dept == 'MSU' || $dept == 'PCO' || $dept == 'QUA' || $dept == 'PPC') {?> 
                            <div style="width: 100%;">
                                <table style="background:#fce0de;color:#85172d;" width="100%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                    <tr>
                                        <th style='text-align:left;font-size:14px;' colspan="4"><strong>Noted : </strong></th>
                                    </tr>
                                    <tr>
                                        <td style='text-align:left;font-size:12px;' colspan="4"><b>Planing</b> untuk approval planing overtime, sedangkan <b>Realization</b> untuk approval realisasi overtime.</td>
                                    </tr>
                                    <tr>
                                        <td style='text-align:left;font-size:12px;' colspan="4">Apabila menekan tombol approval realisasi, maka otomatis approval planing juga disetujui!</td>
                                    </tr>
                                </table>
                            </div>   
                        <?php } else { ?>   
                            <div></div>
                        <?php } ?>
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Periode / Dept / Section</strong></td>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -3; $x <= 1; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<? echo site_url('aorta/overtime_c/prepare_approve_ot_by_mgr_and_gm/' . date("Ym", strtotime("+$y day")) . '/' . trim($dept) . '/' . trim($section)); ?>" <?php
                                                                                                                                                                                                                            if ($period == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                                                                            }
                                                                                                                                                                                                                            ?>> <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                            <?php } ?>

                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<? echo site_url('aorta/overtime_c/prepare_approve_ot_by_mgr_and_gm/' . $period . '/' . trim($row->CHR_DEPT) . '/' . trim($section)); ?>" <?php
                                                                                                                                                                                                            if (trim($dept) == trim($row->CHR_DEPT)) {
                                                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<? echo site_url('aorta/overtime_c/prepare_approve_ot_by_mgr_and_gm/' . $period . '/' . $dept . '/' . $row->KODE); ?>" <?php
                                                                                                                                                                                        if (trim($section) == trim($row->KODE)) {
                                                                                                                                                                                            echo 'SELECTED';
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>><?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="50%">

                                    </td>
                                    <td width="10%">
                                    </td>
                            </table>
                        </div>

                        <?php echo form_open('aorta/overtime_c/approve_all_overtime_by_mgr_and_gm', 'class="form-horizontal"'); ?>

                        <div id="table-luar">
                            <table id="dataTables3" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">No SPKL</th>
                                        <th style="text-align: center;">OT Description</th>
                                        <th style="text-align:center;">Total MP</th>
                                        <th style="text-align:center;">Plan OT (H)</th>
                                        <?php
                                            if($dept == 'MIS' || $dept == 'MSU' || $dept == 'PCO' || $dept == 'QUA' || $dept == 'PPC'){
                                                echo "<th style='text-align:center;'>Planing</th>";
                                            } else{
                                                echo "<th style='text-align:center;'>Action</th>";
                                            }
                                        ?>
                                        <th style="text-align:center;">Realization</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        if ($isi->CEK_KADEP == 0 && $isi->CEK_GM == 0) {
                                            $color = 'background:#E63F53;color:#fff;';
                                            $display = 'enabled';
                                        }
                                        if ($isi->CEK_KADEP == 1 && $isi->CEK_GM == 0) {
                                            $color = 'background:#FFCA01;color:#fff;';
                                            $display = 'enabled';
                                        }
                                        if ($isi->CEK_KADEP == 1 && $isi->CEK_GM == 1) {
                                            $color = 'background:#7DD488;color:#fff;';
                                            $display = 'disabled';
                                        }
                                        if ($isi->CEK_GM == 1 && $isi->FLG_DOWNLOAD == 1) {
                                            $color = 'background:#71AEF5;color:#fff;';
                                            $display = 'disabled';
                                        }
                                        if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                            $color = '';
                                            $display = 'disabled';
                                        }

                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:right;'><input class='icheck' $display type='checkbox' name='nospkl[]' id='nospkl' value='$isi->NO_SEQUENCE'></td>";
                                        echo "<td style='text-align:center;'>$i</td>";

                                        echo "<td style='$color'>$isi->NO_SEQUENCE</td>";
                                        if (strlen($isi->ALASAN) > 70) {
                                            echo "<td>" . substr($isi->ALASAN, 0, 70) . " ...</td>";
                                        } else {
                                            echo "<td>" . $isi->ALASAN . "</td>";
                                        }
                                        echo "<td align='center'><strong>$isi->TOT_MP</strong></td>";
                                        echo "<td align='center'><strong>" . number_format($isi->RENC_DURASI_OV_TIME, 2, ',', '.') . "</strong></td>";
                                    ?>
                                        <!-- <td>
                                            <?php
                                            if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_KADEP == 0 && $isi->CEK_GM == 0) {
                                            ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>

                                            <?php } else { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>

                                            <?php } ?>
                                        </td> -->

                                        <?php if ($dept == '-') {
                                            echo '-';
                                        } else if ($dept == 'MIS' || $dept == 'MSU' || $dept == 'PCO' || $dept == 'QUA' || $dept == 'PPC') {?>
                                        <td align='center'>
                                            <?php
                                            if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_KADEP_PLAN == 0 AND $isi->CEK_GM_PLAN == 0 AND $isi->CEK_KADEP == 0 AND $isi->CEK_GM == 0) {
                                            ?>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_plan_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime planing with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_plan_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>
                                            <?php } ?>
                                        </td>
                                        <td align='center' >
                                            <?php
                                            if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_KADEP == 0 && $isi->CEK_GM == 0) {
                                            ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } else { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime planingwith code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>
                                            <?php } ?>
                                        </td>
                                        <?php } else { ?>
                                        <td align='center'>
                                            <?php
                                            if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_KADEP == 0 && $isi->CEK_GM == 0) {
                                            ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                            <?php } else { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                            <?php } ?>
                                        </td>
                                        <td align='center' >
                                            <?php
                                            if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_KADEP == 0 && $isi->CEK_GM == 0) {
                                            ?>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } else { ?>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime planingwith code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>
                                            <?php } ?>
                                        </td>
                                        <?php } ?>

                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d (Realization): </strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#FE2D45;width:25px;height:25px;color:white;'></button> : Not Yet Approved
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#FFCA01;width:25px;height:25px;color:white;'></button> : Approved By MGR
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#55D785;width:25px;height:25px;color:white;'></button> : Approved By GM
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#71AEF5;width:25px;height:25px;color:white;' ></button> : Process by HRD
                                        <span style = "font-size: 9px; color:gray;">(MIS, MSU, PCO, QUA, PPC)</span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="pull-right" style="margin-top: -30px;">

                            <input name="CHR_DEPT_2" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                            <input name="CHR_PERIOD_2" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">
                            <input name="CHR_SECTION_2" required type="hidden" style="width: 300px;" value="<?php echo $section ?>">

                            <button type="submit" class="btn btn-primary" title="Approve all Overtime" onclick="return confirm('Are you sure want to Approve all overtime in this dept and this period');"><i class="fa fa-thumbs-up"></i> Approve All</button>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>

                <?php
                $array_qr = 0;
                $id_qrcode[$array_qr] = 0;
                foreach ($data as $isi) {
                    if ($id_qrcode[$array_qr] != $isi->NO_SEQUENCE) {
                        $id_qrcode[$array_qr] = $isi->NO_SEQUENCE;
                ?>

                        <div class="modal fade" id="modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header  bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Detail Overtime No : <?php echo $isi->NO_SEQUENCE ?></strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open('aorta/overtime_c/approve_form_overtime_by_mgr_and_gm', 'class="form-horizontal"'); ?>

                                            <input name="NO_SEQUENCE" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->NO_SEQUENCE ?>">
                                            <input name="CHR_DEPT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                                            <input name="CHR_PERIOD" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">
                                            <input name="CHR_SECTION" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $section ?>">

                                            <div id="table-luar" style="max-height: 450px; overflow-y: scroll;">
                                                <table id="dataTables11" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Date</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Username</th>
                                                            <th rowspan="2" style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;">Sub Section</th>

                                                            <th style="vertical-align: middle;text-align:center;" colspan="4">Quota (H)</th>
                                                            <th style="vertical-align: middle;text-align:center;" colspan="3">Planning (H)</th>
                                                            <th style="vertical-align: middle;text-align:center;" colspan="3">Realization (H)</th>

                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">PIC NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">PIC Name</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Std</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Plan</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Real</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Saldo</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Start</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">End</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Start</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>End</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                                        </tr>

                                                    </thead>
                                                    <tbody id="data_detail<?php echo $isi->NO_SEQUENCE ?>">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <?php if ($isi->CEK_GM == 0) { ?>
                                                    <button type="submit" value=1 name="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Approve This Quota Request" onclick="return confirm('Are you sure want to Approve this quota request with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><i class="fa fa-thumbs-up"></i> Approve</button>
                                                <?php } else { ?>
                                                    <button type="submit" value=0 name="submit" class="btn btn-danger" data-placement="left" data-toggle="tooltip" title="Unapprove This Quota Request" onclick="return confirm('Are you sure want to Unapprove this quota request with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><i class="fa fa-thumbs-down"></i> Unapprove</button>
                                                <?php } ?>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                        $array_qr++;
                    }
                    $id_qrcode[$array_qr] = 0;
                }
                ?>

                <div class="modal fade" id="modalQuota" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header  bg-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Quota Usage per Dept</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <div id="table-luar" style="max-height: 450px; overflow-y: scroll;">
                                        <table id="dataTables11" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;text-align:center;">No</th>
                                                    <th style="vertical-align: middle;text-align:center;">Dept</th>
                                                    <th style="vertical-align: middle;text-align:center;">Total MP</th>
                                                    <!-- <th style="vertical-align: middle;text-align:center;">Quota STD</th> -->
                                                    <th style="vertical-align: middle;text-align:center;">Quota OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Budget OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Actual OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Act vs Budget (%)</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $no = 1;
                                            foreach ($quota_usage_dept as $usage) { ?>
                                                <tr style="text-align:center;">
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo $usage->KD_DEPT; ?></td>
                                                    <td><?php echo $usage->KRY; ?></td>
                                                    <!-- <td><?php echo number_format($usage->QUOTA_STD, 2, ',', '.'); ?></td> -->
                                                    <td><?php echo number_format($usage->QUOTAPLAN, 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($usage->INT_BUDGET_QUOTA, 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($usage->TERPAKAIPLAN, 2, ',', '.'); ?></td>
                                                    <?php
                                                    if ($usage->INT_BUDGET_QUOTA == 0 || $usage->INT_BUDGET_QUOTA == NULL) {
                                                        $act_vs_budget_dept = (($usage->TERPAKAIPLAN / 100) * 100) + 100;
                                                    } else {
                                                        $act_vs_budget_dept = ($usage->TERPAKAIPLAN / $usage->INT_BUDGET_QUOTA) * 100;
                                                    }

                                                    $style = '';
                                                    if ($act_vs_budget_dept <= 90) {
                                                        $style = 'style="background-color: #55D785; color:white;"';
                                                    } else if ($act_vs_budget_dept > 90 && $act_vs_budget_dept <= 100) {
                                                        $style = 'style="background-color: orange; color:white;"';
                                                    } else if ($act_vs_budget_dept > 100) {
                                                        $style = 'style="background-color: #FE2D45; color:white;"';
                                                    }
                                                    ?>
                                                    <td <?php echo $style; ?>><?php echo number_format($act_vs_budget_dept, 2, ',', '.') . ' %'; ?></td>
                                                </tr>
                                            <?php $no++;
                                            } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-clock-o"></i>
                        <span class="grid-title"><strong>REMINDER APPROVAL OVERTIME - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Dept / Section</strong></td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<? echo site_url('aorta/overtime_c/prepare_approve_ot_by_mgr_and_gm/' . $period . '/' . trim($row->CHR_DEPT) . '/' . trim($section)); ?>" <?php
                                                                                                                                                                                                            if (trim($dept) == trim($row->CHR_DEPT)) {
                                                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<? echo site_url('aorta/overtime_c/prepare_approve_ot_by_mgr_and_gm/' . $period . '/' . $dept . '/' . $row->KODE); ?>" <?php
                                                                                                                                                                                        if (trim($section) == trim($row->KODE)) {
                                                                                                                                                                                            echo 'SELECTED';
                                                                                                                                                                                        }
                                                                                                                                                                                        ?>><?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="50%">

                                    </td>
                                    <td width="10%">
                                    </td>
                            </table>
                        </div>

                        <div id="table-luar">
                            <table id="dataTables1" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">No</th>
                                        <th style="text-align: center;">No SPKL</th>
                                        <th style="text-align: center;">OT Description</th>
                                        <th style="text-align: center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data_approve as $isi) {
                                        if ($isi->CEK_KADEP == 0 && $isi->CEK_GM == 0) {
                                            $color = 'background:#E63F53;color:#fff;';
                                            $display = 'enabled';
                                        }
                                        if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                            $color = '';
                                            $display = 'disabled';
                                        }

                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";

                                        echo "<td style='$color'>$isi->NO_SEQUENCE</td>";
                                        if (strlen($isi->ALASAN) > 80) {
                                            echo "<td>" . substr($isi->ALASAN, 0, 80) . " ...</td>";
                                        } else {
                                            echo "<td>" . $isi->ALASAN . "</td>";
                                        }
                                    ?>
                                        <td align='center'>
                                            <?php
                                            if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                                echo '-';
                                            } else if ($isi->CEK_KADEP == 0 && $isi->CEK_GM == 0) {
                                            ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/approve_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-up"></span></a>

                                            <?php } else { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->NO_SEQUENCE ?>);" data-toggle="modal" data-target="#modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/overtime_c/unapprove_overtime_by_mgr_and_gm') . "/" . $isi->NO_SEQUENCE . "/" . $period . "/" . $dept . "/" . $section; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Unapprove this overtime with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><span class="fa fa-thumbs-down"></span></a>

                                            <?php } ?>
                                        </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>
                        <div style="width: 60%;">
                            <table width="60%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d : </strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#FE2D45;width:25px;height:25px;color:white;'></button> : Not Yet Approved
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

                <?php
                $array_qr = 0;
                $id_qrcode[$array_qr] = 0;
                foreach ($data as $isi) {
                    if ($id_qrcode[$array_qr] != $isi->NO_SEQUENCE) {
                        $id_qrcode[$array_qr] = $isi->NO_SEQUENCE;
                ?>

                        <div class="modal fade" id="modalDetailOvertime<?php echo $isi->NO_SEQUENCE ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header  bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Detail Overtime No : <?php echo $isi->NO_SEQUENCE ?></strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open('aorta/overtime_c/approve_form_overtime_by_mgr_and_gm', 'class="form-horizontal"'); ?>

                                            <input name="NO_SEQUENCE" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->NO_SEQUENCE ?>">
                                            <input name="CHR_DEPT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                                            <input name="CHR_PERIOD" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">
                                            <input name="CHR_SECTION" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $section ?>">

                                            <div id="table-luar" style="max-height: 450px; overflow-y: scroll;">
                                                <table id="dataTables12" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Date</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Username</th>
                                                            <th rowspan="2" style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;">Sub Section</th>

                                                            <th style="vertical-align: middle;text-align:center;" colspan="4">Quota (H)</th>
                                                            <th style="vertical-align: middle;text-align:center;" colspan="3">Planning (H)</th>
                                                            <th style="vertical-align: middle;text-align:center;" colspan="3">Realization (H)</th>

                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">PIC NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">PIC Name</th>
                                                        </tr>
                                                        <tr>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Std</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Plan</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Real</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Saldo</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Start</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">End</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Start</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>End</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Duration</td>
                                                        </tr>

                                                    </thead>
                                                    <tbody id="data_detail<?php echo $isi->NO_SEQUENCE ?>">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <?php if ($isi->CEK_GM == 0) { ?>
                                                    <button type="submit" value=1 name="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Approve This Quota Request" onclick="return confirm('Are you sure want to Approve this quota request with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><i class="fa fa-thumbs-up"></i> Approve</button>
                                                <?php } else { ?>
                                                    <button type="submit" value=0 name="submit" class="btn btn-danger" data-placement="left" data-toggle="tooltip" title="Unapprove This Quota Request" onclick="return confirm('Are you sure want to Unapprove this quota request with code : ' + <?php echo $isi->NO_SEQUENCE ?>);"><i class="fa fa-thumbs-down"></i> Unapprove</button>
                                                <?php } ?>
                                                <?php echo form_close(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                <?php
                        $array_qr++;
                    }
                    $id_qrcode[$array_qr] = 0;
                }
                ?>

                <div class="modal fade" id="modalQuota" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">
                    <div class="modal-wrapper">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header  bg-primary">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                    <h4 class="modal-title" id="modalprogress"><strong>Quota Usage per Dept</strong></h4>
                                </div>
                                <div class="modal-body">
                                    <div id="table-luar" style="max-height: 450px; overflow-y: scroll;">
                                        <table id="dataTables12" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th style="vertical-align: middle;text-align:center;">No</th>
                                                    <th style="vertical-align: middle;text-align:center;">Dept</th>
                                                    <th style="vertical-align: middle;text-align:center;">Total MP</th>
                                                    <!-- <th style="vertical-align: middle;text-align:center;">Quota STD</th> -->
                                                    <th style="vertical-align: middle;text-align:center;">Quota OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Budget OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Actual OT</th>
                                                    <th style="vertical-align: middle;text-align:center;">Act vs Budget (%)</th>
                                                </tr>
                                            </thead>
                                            <?php
                                            $no = 1;
                                            foreach ($quota_usage_dept as $usage) { ?>
                                                <tr style="text-align:center;">
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo $usage->KD_DEPT; ?></td>
                                                    <td><?php echo $usage->KRY; ?></td>
                                                    <!-- <td><?php echo number_format($usage->QUOTA_STD, 2, ',', '.'); ?></td> -->
                                                    <td><?php echo number_format($usage->QUOTAPLAN, 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($usage->INT_BUDGET_QUOTA, 2, ',', '.'); ?></td>
                                                    <td><?php echo number_format($usage->TERPAKAIPLAN, 2, ',', '.'); ?></td>
                                                    <?php
                                                    if ($usage->INT_BUDGET_QUOTA == 0 || $usage->INT_BUDGET_QUOTA == NULL) {
                                                        $act_vs_budget_dept = (($usage->TERPAKAIPLAN / 100) * 100) + 100;
                                                    } else {
                                                        $act_vs_budget_dept = ($usage->TERPAKAIPLAN / $usage->INT_BUDGET_QUOTA) * 100;
                                                    }

                                                    $style = '';
                                                    if ($act_vs_budget_dept <= 90) {
                                                        $style = 'style="background-color: #55D785; color:white;"';
                                                    } else if ($act_vs_budget_dept > 90 && $act_vs_budget_dept <= 100) {
                                                        $style = 'style="background-color: orange; color:white;"';
                                                    } else if ($act_vs_budget_dept > 100) {
                                                        $style = 'style="background-color: #FE2D45; color:white;"';
                                                    }
                                                    ?>
                                                    <td <?php echo $style; ?>><?php echo number_format($act_vs_budget_dept, 2, ',', '.') . ' %'; ?></td>
                                                </tr>
                                            <?php $no++;
                                            } ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>QUOTA PLAN VS ACTUAL - <?php echo $dept . ' ' . $section; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/aorta/quota_employee_c/downloadViewPlanActualQuota/' . $period . '/' . $dept . '/' . $section); ?>" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Export to Excel"><i class="fa  fa-file-excel-o"></i>&nbsp;&nbsp; Export to Excel</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='460px' src="<?php echo site_url("aorta/quota_employee_c/view_plan_vs_actual_quota/" . $period . "/" . $dept); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>QUOTA ACCUMULATION PLAN VS ACTUAL - <?php echo $dept . ' ' . $section; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a href="<?php echo base_url('index.php/aorta/quota_employee_c/downloadViewPlanActualQuotaAccumulative/' . $period . '/' . $dept . '/' . $section); ?>" class="btn btn-default" data-placement="left" data-toggle="tooltip" title="Export to Excel"><i class="fa  fa-file-excel-o"></i>&nbsp;&nbsp; Export to Excel</a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='460px' src="<?php echo site_url("aorta/quota_employee_c/view_plan_vs_actual_quota_accumulation/" . $period . "/" . $dept); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>SUMMARY QUOTA THIS PERIODE - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='325px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_section/" . $period . "/" . $dept); ?>"></iframe>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>GROUP <?php echo $group; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div>
                            <table class="table table-condensed table-hover display" cellspacing="0" width="50%" style="font-size: 11px;">
                                <thead>
                                    <tr>
                                        <td colspan='3' align='center' style="font-weight: bold;">Summary This Periode</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Total MP</td>
                                        <td>:</td>
                                        <td><strong> <?php if ($detail_quota_group) {
                                                            echo $detail_quota_group->KRY;
                                                        } else {
                                                            echo 0;
                                                        } ?> MP</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Quota STD</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->QUOTA_STD, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Quota Plan</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->QUOTAPLAN, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Actual OT</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->TERPAKAIPLAN, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Avg OT/MP</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format(($detail_quota_group->TERPAKAIPLAN / $detail_quota_group->KRY), 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Saldo Quota</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->SISAPLAN, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Avg Quota (Est 22 WD)</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->AVG_QUOTA, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H/Day</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Avg OT (Est 22 WD)</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->AVG_OT, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H/Day</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Avg Saldo (Est 22 WD)</td>
                                        <td>:</td>
                                        <td><strong><?php if ($detail_quota_group) {
                                                        echo number_format($detail_quota_group->AVG_SISA, 2, ',', '.');
                                                    } else {
                                                        echo 0;
                                                    } ?> H/Day</strong></td>
                                    </tr>
                                    <tr style="background-color: whitesmoke;">
                                        <td>Budget Quota</td>
                                        <td>:</td>
                                        <td><strong><?php echo number_format($detail_quota_group->INT_BUDGET_QUOTA, 2, ',', '.'); ?> H</strong></td>
                                    </tr>
                                    <?php
                                    $act_vs_budget = ($detail_quota_group->TERPAKAIPLAN / $detail_quota_group->INT_BUDGET_QUOTA) * 100;
                                    $style_color = '';
                                    if ($act_vs_budget <= 90) {
                                        $style_color = 'background-color: #55D785; color:white;';
                                    } else if ($act_vs_budget > 90 && $act_vs_budget <= 100) {
                                        $style_color = 'background-color: orange; color:white;';
                                    } else if ($act_vs_budget > 100) {
                                        $style_color = 'background-color: #FE2D45;color:white;';
                                    }
                                    ?>
                                    <tr style="<?php echo $style_color; ?>">
                                        <td>Actual vs Budget (%)</td>
                                        <td>:</td>
                                        <td>
                                            <strong><?php echo number_format(($detail_quota_group->TERPAKAIPLAN / $detail_quota_group->INT_BUDGET_QUOTA) * 100, 2, ',', '.'); ?> %</strong>
                                            <a onclick="" data-toggle="modal" data-target="#modalQuota" data-placement="left" data-toggle="tooltip" title="Quota Usage per Dept" class="label label-info"><span class="fa fa-search"></span></a>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                        <!--<iframe frameBorder="0" width='100%' height='250px' src="<?php //echo site_url("aorta/overtime_c/view_detail_ot_group/" . $period . "/" . $group);  
                                                                                        ?>"></iframe>-->
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL QUOTA OT PER MONTH - GROUP <?php echo $group; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='160px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month_gm/" . $period . "/" . $group); ?>"></iframe>
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
        var table = $('#example').DataTable({
            scrollY: "350px",
            scrollX: true,
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 4
            }
        });

        //                                                    $('.dataTables_filter input').addClass('search-query');
        $('.dataTables_filter input').attr('placeholder', 'Search');
    });

    function get_data_detail(nospkl) {
        $("#data_detail").html("");
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('aorta/overtime_c/view_detail_overtime'); ?>",
            data: "nospkl=" + nospkl,
            success: function(data) {
                $("#data_detail" + nospkl).html(data);
            }
        });

    }
</script>