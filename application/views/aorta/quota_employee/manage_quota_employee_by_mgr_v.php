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
                        <span class="grid-title"><strong>QUOTA REQUEST PERIOD <?php echo strtoupper(date('M Y', strtotime($period))); ?> / DEPT <?php echo $dept; ?></strong></span>
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
                                                <option value="<?php echo site_url('aorta/quota_employee_c/prepare_approve_quota_by_mgr/' . date("Ym", strtotime("+$y day")) . '/' . $dept . '/' . $section); ?>" <?php
                                                                                                                                                                                                                    if ($period == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                                        echo 'SELECTED';
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                    ?>> <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                            <?php } ?>

                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<?php echo site_url('aorta/quota_employee_c/prepare_approve_quota_by_mgr/' . $period . '/' . $row->CHR_DEPT . '/' . $section); ?>" <?php
                                                                                                                                                                                                    if ($dept == $row->CHR_DEPT) {
                                                                                                                                                                                                        echo 'SELECTED';
                                                                                                                                                                                                    }
                                                                                                                                                                                                    ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="60%">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<? echo site_url('aorta/quota_employee_c/prepare_approve_quota_by_mgr/' . $period . '/' . trim($dept) . '/' . $row->KODE); ?>" <?php
                                                                                                                                                                                                if (trim($section) == trim($row->KODE)) {
                                                                                                                                                                                                    echo 'SELECTED';
                                                                                                                                                                                                }
                                                                                                                                                                                                ?>><?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                    </td>
                            </table>
                        </div>

                        <?php echo form_open('aorta/quota_employee_c/approve_all_quota_employee_by_mgr', 'class="form-horizontal"'); ?>

                        <div id="table-luar">
                            <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="text-align: center;">&nbsp;</th>
                                        <th style='text-align:center;'>No</th>
                                        <th style="text-align:center;">No Quota Req.</th>
                                        <th style="text-align:center;">Upload Date</th>
                                        <!-- <th style="text-align:center;">Dept</th> -->
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
                                        if ($isi->SPV_APPROVE == 0 && $isi->KADEP_APPROVE == 0 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) {
                                            $color = '#FE2D45';
                                            $display = 'enabled';
                                        }
                                        else if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 0 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) {
                                            $color = '#F5811E';
                                            $display = 'disabled';
                                        }
                                        else if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 1 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) {
                                            $color = '#FFCA01';
                                            $display = 'disabled';
                                        }
                                        else if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 1 && $isi->GM_APPROVE == 1 && $isi->DIR_APPROVE == 0) {
                                            $color = '#55D785';
                                            $display = 'disabled';
                                        }
                                        else if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 1 && $isi->GM_APPROVE == 1 && $isi->DIR_APPROVE == 1) {
                                            $color = '#0C87F2';
                                            $display = 'disabled';
                                        }

                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:right;'><input class='icheck' $display type='checkbox' name='noquota[]' id='noquota' value='$isi->ID_DOC'></td>";
                                        echo "<td style='text-align:center;'>$i</td>";
                                        echo "<td style='background:$color;color:#fff;'>$isi->ID_DOC</td>";
                                        echo "<td style='text-align:center;'>$isi->TGL_DOC</td>";
                                        // echo "<td style='text-align:center;'>$isi->KD_DEPT</td>";
                                        echo "<td style='text-align:center;'>$isi->FLG_FINISH_APPROVE</td>";
                                        echo "<td style='white-space:pre-wrap; word-wrap:break-word;'>$isi->ALASAN</td>";
                                        echo "<td style='text-align:center;'><strong>$isi->TOT_MP</strong></td>";
                                        echo "<td style='text-align:center;'><strong>" . number_format($isi->QUOTA_PR, 2, ',', '.') . "</strong></td>";
                                        echo "<td style='text-align:center;'><strong>" . number_format($isi->QUOTA_IM, 2, ',', '.') . "</strong></td>";
                                    ?>
                                        <td style='text-align:center;'>
                                            <a onclick="get_data_detail(<?php echo $isi->ID_DOC ?>);" data-toggle="modal" data-target="#modalDetailQuotaReq<?php echo $isi->ID_DOC ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>

                                            <?php if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 0) { ?>
                                                <a href="<?php echo base_url('index.php/aorta/quota_employee_c/approve_quota_employee_by_mgr') . "/" . $isi->ID_DOC . "/" . $dept . "/" . $section . "/" . $period; ?>" class="label label-primary" data-placement="left" data-toggle="tooltip" title="Approve" onclick="return confirm('Are you sure want to Approve this quota request with code : ' + <?php echo $isi->ID_DOC ?>);"><span class="fa fa-thumbs-up"></span></a>
                                            <?php } ?>
                                            <?php if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 1 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) { ?>
                                                <a href="<?php echo base_url('index.php/aorta/quota_employee_c/unapprove_quota_employee_by_mgr') . "/" . $isi->ID_DOC . "/" . $dept . "/" . $section . "/" . $period; ?>" class="label label-danger" data-placement="left" data-toggle="tooltip" title="Unapprove" onclick="return confirm('Are you sure want to Reject this quota request with code : ' + <?php echo $isi->ID_DOC ?>);"><span class="fa fa-thumbs-down"></span></a>
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
                                        <button disabled style='border:0;background:#F5811E;width:25px;height:25px;color:white;'></button> : Approved By SPV
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#FFCA01;width:25px;height:25px;color:white;'></button> : Approved By MGR
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#55D785;width:25px;height:25px;color:white;'></button> : Approved By GM
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#0C87F2;width:25px;height:25px;color:white;'></button> : Approved By DIR*
                                    </td>
                                </tr>
                            </table>
                        </div>

                        <span style="font-size:9pt">* only exceeds the standard quota </span>
                        <!--(40 hours) -->
                        <div class="pull-right" style="margin-top: -30px;">

                            <input name="CHR_DEPT_2" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                            <input name="CHR_SECTION_2" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $section ?>">
                            <input name="CHR_PERIOD_2" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">

                            <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Approve All" onclick="return confirm('Are you sure want to Approve this quota request in this dept and this period');"><i class="fa fa-thumbs-up"></i> Approve All</button>

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
                                        <div class="modal-header bg-primary">

                                            <?php if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 0) { ?>
                                                <?php echo form_open('aorta/quota_employee_c/approve_form_quota_employee_by_mgr', 'class="form-horizontal"'); ?>
                                            <?php } ?>
                                            <?php if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 1 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) { ?>
                                                <?php echo form_open('aorta/quota_employee_c/unapprove_form_quota_employee_by_mgr', 'class="form-horizontal"'); ?>
                                            <?php } ?>

                                            <input name="ID_DOC" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->ID_DOC ?>">
                                            <input name="CHR_DEPT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                                            <input name="CHR_SECTION" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $section ?>">
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
                                                    <tbody id="data<?php echo $isi->ID_DOC ?>">
                                                    </tbody>
                                                </table>

                                                <table id="dataTables12" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th style="text-align:center;">No</th>
                                                            <th style="text-align:center;">NPK</th>
                                                            <th style="text-align:center;">Nama</th>
                                                            <?php for ($f = 1; $f <= 31; $f++) {
                                                                echo "<td style='text-align:center;'>$f</td>";
                                                            } ?>
                                                        </tr>

                                                    </thead>
                                                    <tbody id="data_detail<?php echo $isi->ID_DOC ?>">
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>
                                        <div class="modal-footer">
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> &nbsp;&nbsp;&nbsp;
                                                <?php if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 0) { ?>
                                                    <button type="submit" class="btn btn-primary" data-placement="left" data-toggle="tooltip" title="Approve This Quota Request" onclick="return confirm('Are you sure want to Approve this quota request with code : ' + <?php echo $isi->ID_DOC ?>);"><i class="fa fa-thumbs-up"></i> Approve</button>
                                                <?php } ?>
                                                <?php if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 1 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) { ?>
                                                    <button type="submit" class="btn btn-danger" data-placement="left" data-toggle="tooltip" title="Unapprove This Quota Request" onclick="return confirm('Are you sure want to Unapprove this quota request with code : ' + <?php echo $isi->ID_DOC ?>);"><i class="fa fa-thumbs-down"></i> Unapprove</button>
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

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>SUMMARY QUOTA THIS PERIODE - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='280px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_section/" . $period . "/" . $dept); ?>"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-bars"></i>
                        <span class="grid-title"><strong>DETAIL QUOTA OT PER MONTH - DEPT <?php echo $dept; ?></strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                        <iframe frameBorder="0" width='100%' height='250px' src="<?php echo site_url("aorta/overtime_c/view_detail_ot_per_month/" . $period . "/" . $dept); ?>"></iframe>
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
        $("#data_detail" + qrno).html("");
        $("#data" + qrno).html("");

        $.ajax({
            async: false,
            dataType: 'json',
            type: "POST",
            url: "<?php echo site_url('aorta/quota_employee_c/view_detail_quota_employee_by_mgr'); ?>",
            data: "qrno=" + qrno,
            success: function(json_data) {
                $("#data" + qrno).html(json_data.data);
                $("#data_detail" + qrno).html(json_data.data_detail);
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
    }
</script>