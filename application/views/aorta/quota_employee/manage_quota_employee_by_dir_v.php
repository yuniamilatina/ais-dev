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
            <li><a href="<?php echo base_url('index.php/aorta/quota_employee_c') ?>"><strong>Quota Request Approval</strong></a></li>
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
                        <span class="grid-title"><strong>QUOTA REQUEST PERIOD <?php echo $period; ?> / DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;'><strong>Periode / Dept</strong></td>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -24; $x <= 1; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<?php echo site_url('aorta/quota_employee_c/prepare_approve_quota_by_dir/' . date("Ym", strtotime("+$y day")) . '/' . $dept); ?>" <?php
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
                                                <option value="<? echo site_url('aorta/quota_employee_c/prepare_approve_quota_by_dir/' . $period . '/' . $row->KODE); ?>" <?php
                                                                                                                                                                            if ($dept == $row->KODE) {
                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                            }
                                                                                                                                                                            ?>><?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="70%">
                                    </td>
                            </table>
                        </div>

                        <?php echo form_open('aorta/quota_employee_c/approve_all_quota_employee_by_dir', 'class="form-horizontal"'); ?>

                        <div id="table-luar">
                            <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style='text-align:center;'>No</th>
                                        <th style="text-align:center;">No Quota Req.</th>
                                        <th style="text-align:center;">Upload Date</th>
                                        <th style="text-align:center;">Dept</th>
                                        <th style="text-align:center;">Status</th>
                                        <th style="text-align:center;">Quota Description</th>
                                        <th style="text-align:center;">Total MP</th>
                                        <th style="text-align:center;">QR PRD</th>
                                        <th style="text-align:center;">QR IMP</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        if ($isi->GM_APPROVE == 1 && $isi->DIR_APPROVE == 0) {
                                            $color = '#FE2D45';
                                            $display = 'enabled';
                                        }
                                        if ($isi->GM_APPROVE == 1 && $isi->DIR_APPROVE == 1) {
                                            $color = '#55D785';
                                            $display = 'disabled';
                                        }
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:right;'><input class='icheck' $display type='checkbox' name='noquota[]' id='noquota' value='$isi->ID_DOC'></td>";
                                        echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td style='background:$color;color:#fff;'>$isi->ID_DOC</td>";
                                        echo "<td style='text-align:center;'>$isi->TGL_DOC</td>";
                                        echo "<td style='text-align:center;'>$isi->KD_DEPT</td>";
                                        echo "<td style='text-align:center;'>$isi->FLG_FINISH_APPROVE</td>";
                                        echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->ALASAN</td>";
                                        echo "<td style='text-align:center;'><strong>$isi->TOT_MP</strong></td>";
                                        echo "<td style='text-align:center;'><strong>" . number_format($isi->QUOTA_PR, 2, ',', '.') . "</strong></td>";
                                        echo "<td style='text-align:center;'><strong>" . number_format($isi->QUOTA_IM, 2, ',', '.') . "</strong></td>";
                                    ?>
                                        <td style='text-align:center;'>
                                            <?php if ($isi->DIR_APPROVE == 0) { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->ID_DOC ?>);" data-toggle="modal" data-target="#modalDetailQuotaReq<?php echo $isi->ID_DOC ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <a href="<?php echo base_url('index.php/aorta/quota_employee_c/approve_quota_employee_by_dir') . "/" . $isi->ID_DOC . "/" . $dept . "/" . $period; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this quota request with code : ' + <?php echo $isi->ID_DOC ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } else { ?>
                                                <a onclick="get_data_detail(<?php echo $isi->ID_DOC ?>);" data-toggle="modal" data-target="#modalDetailQuotaReq<?php echo $isi->ID_DOC ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>
                                                <!--<a disabled href="<?php echo base_url('index.php/aorta/quota_employee_c/reject_quota_employee_by_dir') . "/" . $isi->ID_DOC . "/" . $dept . "/" . $period; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Reject this quota request with code : ' + <?php echo $isi->ID_DOC ?>);"><span class="fa fa-thumbs-down"></span></a>-->
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
                                    <td width="10%">
                                        <button disabled style='border:0;background:#55D785;width:25px;height:25px;color:white;'></button> : Approved
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="pull-right" style="margin-top: -30px;">
                            <?php echo form_open('aorta/quota_employee_c/approve_all_quota_employee_by_dir', 'class="form-horizontal"'); ?>

                            <input name="CHR_DEPT_2" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                            <input name="CHR_PERIOD_2" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">
                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Under development" onclick="return confirm('Are you sure want to Approve this quota request in this dept and this period');"><i class="fa fa-thumbs-up"></i> Approve All</button>

                            <?php echo form_close(); ?>
                        </div>
                        <span style="font-size:9pt">
                            <!--* only exceeds the standard quota -->
                        </span>
                        <!--(40 hours) -->
                    </div>

                </div>

                <?php
                $array_qr = 0;
                $id_qrcode[$array_qr] = 0;
                foreach ($data as $isi) {
                    if ($id_qrcode[$array_qr] != $isi->ID_DOC) {
                        $id_qrcode[$array_qr] = $isi->ID_DOC;
                ?>

                        <div class="modal fade" id="modalDetailQuotaReq<?php echo $isi->ID_DOC ?>" tabindex="-1" role="dialog" aria-labelledby="modalprogress" aria-hidden="true" style="display: none;">

                            <div class="modal-wrapper">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header  bg-primary">
                                            <?php echo form_open('aorta/quota_employee_c/approve_form_quota_employee_by_dir', 'class="form-horizontal"'); ?>

                                            <input name="ID_DOC" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->ID_DOC ?>">
                                            <input name="CHR_DEPT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                                            <input name="CHR_PERIOD" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">

                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Detail Quota QR No : <?php echo $isi->ID_DOC ?></strong></h4>
                                        </div>
                                        <div class="modal-body">

                                            <div id="table-luar" style="max-height: 450px; overflow-y: scroll;">
                                                <table id="dataTables11" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Nama</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Section</th>
                                                            <th rowspan="2" style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;">Sub Section</th>

                                                            <th style="vertical-align: middle;text-align:center;" colspan="5">Production (H)</th>
                                                            <th style="vertical-align: middle;text-align:center;" colspan="5">Improvement (H)</th>

                                                        </tr>
                                                        <tr>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Request</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Current</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Used</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Saldo</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Next Saldo</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Request</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Current</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Used</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Saldo</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Next Saldo</td>
                                                        </tr>

                                                    </thead>
                                                    <tbody id="data_detail<?php echo $isi->ID_DOC ?>">
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                <?php if ($isi->DIR_APPROVE == 0) { ?>
                                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Approve This Quota Request" onclick="return confirm('Are you sure want to Approve this quota request with code : ' + <?php echo $isi->ID_DOC ?>);"><i class="fa fa-thumbs-up"></i> Approve</button>
                                                <?php } ?>
                                                <?php echo form_close();
                                                ?>
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
            <div class="col-md-8">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>SUMMARY THIS PERIODE - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='275px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_section/" . $period . "/" . $dept); ?>"></iframe>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>PLANT SUMMARY</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <table class="table table-condensed table-hover display" cellspacing="0" width="50%" style="font-size: 11px;">
                            <!-- <thead>
                                <tr>
                                    <td colspan='3' align='center' style="font-weight: bold;">Summary This Periode</td>
                                </tr>
                            </thead> -->
                            <tr>
                                <td>Total MP</td>
                                <td>:</td>
                                <td><strong><?php echo $detail_quota_plant->KRY ?> MP</strong></td>
                            </tr>
                            <tr>
                                <td>Quota STD</td>
                                <td>:</td>
                                <td><strong><?php echo number_format($detail_quota_plant->QUOTA_STD, 2, ',', '.'); ?> H</strong></td>
                            </tr>
                            <tr>
                                <td>Quota Plan</td>
                                <td>:</td>
                                <td><strong><?php echo number_format(($detail_quota_plant->QUOTAPLAN + $detail_quota_plant->QUOTAPLAN1), 2, ',', '.'); ?> H</strong></td>
                            </tr>
                            <tr style="background-color: whitesmoke;">
                                <td>Actual OT</td>
                                <td>:</td>
                                <td><strong><?php echo number_format(($detail_quota_plant->TERPAKAIPLAN + $detail_quota_plant->TERPAKAIPLAN1), 2, ',', '.'); ?> H</strong></td>
                            </tr>
                            <tr>
                                <td>Saldo Quota</td>
                                <td>:</td>
                                <td><strong><?php echo number_format(($detail_quota_plant->SISAPLAN + $detail_quota_plant->SISAPLAN1), 2, ',', '.'); ?> H</strong></td>
                            </tr>
                            <tr>
                                <td>Avg Quota (Est 22 WD)</td>
                                <td>:</td>
                                <td><strong><?php echo number_format(($detail_quota_plant->AVG_QUOTA + $detail_quota_plant->AVG_QUOTA1), 2, ',', '.'); ?> H/Day</strong></td>
                            </tr>
                            <tr>
                                <td>Avg OT (Est 22 WD)</td>
                                <td>:</td>
                                <td><strong><?php echo number_format(($detail_quota_plant->AVG_OT + $detail_quota_plant->AVG_OT1), 2, ',', '.'); ?> H/Day</strong></td>
                            </tr>
                            <tr>
                                <td>Avg Saldo (Est 22 WD)</td>
                                <td>:</td>
                                <td><strong><?php echo number_format(($detail_quota_plant->AVG_SISA + $detail_quota_plant->AVG_SISA1), 2, ',', '.'); ?> H/Day</strong></td>
                            </tr>
                            <tr style="background-color: whitesmoke;">
                                <td>Budget Quota</td>
                                <td>:</td>
                                <td><strong><?php echo number_format($detail_quota_plant->INT_BUDGET_QUOTA, 2, ',', '.'); ?> H</strong></td>
                            </tr>
                            <?php
                            $act_vs_budget = (($detail_quota_plant->TERPAKAIPLAN + $detail_quota_plant->TERPAKAIPLAN1) / $detail_quota_plant->INT_BUDGET_QUOTA) * 100;
                            $style_color = '';
                            if ($act_vs_budget <= 90) {
                                $style_color = 'background-color: #55D785;color:white;';
                            } else if ($act_vs_budget > 90 && $act_vs_budget <= 100) {
                                $style_color = 'background-color: orange;color:white;';
                            } else if ($act_vs_budget > 100) {
                                $style_color = 'background-color: #FE2D45;color:white;';
                            }
                            ?>
                            <tr style="<?php echo $style_color; ?>">
                                <td>Actual vs Budget (%)</td>
                                <td>:</td>
                                <td>
                                    <strong><?php echo number_format((($detail_quota_plant->TERPAKAIPLAN + $detail_quota_plant->TERPAKAIPLAN1) / $detail_quota_plant->INT_BUDGET_QUOTA) * 100, 2, ',', '.'); ?> %</strong>
                                    <a  data-toggle="modal" data-target="#modalQuota" data-placement="left" data-toggle="tooltip" title="Quota Usage per Dept" class="label label-info"><span class="fa fa-search"></span></a>
                                </td>
                            </tr>
                        </table>
                        <!--<iframe frameBorder="0" width='100%' height='250px' src="<?php //echo site_url("aorta/overtime_c/view_detail_ot_plant/" . $period);  
                                                                                        ?>"></iframe>-->
                    </div>
                </div>
            </div>
        </div>
        <!--        <div class="row">
                    <div class="col-md-12">
                        <div class="grid">
                            <div class="grid-header">
                                <i class="fa fa-bars"></i>
                                <span class="grid-title"><strong>DETAIL QUOTA OT PER MONTH - DEPT <?php //echo $dept;  
                                                                                                    ?></strong></span>
                                <div class="pull-right grid-tools">
                                    <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                                </div>
                            </div>
                            <div class="grid-body">
                                <iframe frameBorder="0" width='100%' height='160px' src="<?php //echo site_url("aorta/overtime_c/view_detail_ot_per_month/" . substr($period,0,4) . "/" . $dept);  
                                                                                            ?>"></iframe>
                            </div>
                        </div>
                    </div>
                </div>-->
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL QUOTA OT PER MONTH - PLANT</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='280px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month_dir/" . $period); ?>"></iframe>
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



    function get_data_detail(qrno) {
        $("#data_detail").html("");
        $.ajax({
            async: false,
            type: "POST",
            url: "<?php echo site_url('aorta/quota_employee_c/view_detail_quota_employee_by_dir'); ?>",
            data: "qrno=" + qrno,
            success: function(data) {
                $("#data_detail" + qrno).html(data);
            }
        });

    }
</script>