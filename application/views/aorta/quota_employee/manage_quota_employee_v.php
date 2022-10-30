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
        -webkit-border-horizontal-spacing: 0px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }

    #filterx {
        -webkit-border-horizontal-spacing: 20px;
        -webkit-border-vertical-spacing: 10px;
        border-collapse: separate;
    }

    .td-fixed {
        width: 30px;
    }

    .td-no {
        width: 10px;
    }

    .ddl {
        width: 120px;
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
            <li><a href="<?php echo base_url('index.php/aorta/quota_employee_c') ?>"><strong>Manage Overtime </strong></a></li>
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
                        <span class="grid-title"><strong>QUOTA REQUEST</strong></span>
                        <div class="pull-right grid-tools">
                            <?php if ($role == 1 || $role == 6 || $role == 13 || $role == 30 || $role == 32 || $role == 33 || $role == 18 || $role == 19 || $role == 20 || $role == 22 || $role == 23 || $role == 24 || $role == 26 || $role == 27 || $role == 40 || $role == 58  || $role == 61 || $role == 67 || $role == 69 || $role == 103) { ?>
                                <a href="<?php echo base_url('index.php/aorta/quota_employee_c/create_quota_employee/' . $period . '/' . $dept . '/' . $section) ?>" class="btn btn-primary" data-toggle="tooltip" data-placement="left" title="Request Quota" style="color:#FFFFFF;height:30px;font-size:13px;width:110px;padding-left:10px;">Create</a>
                            <?php } else { ?>
                                <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table id='filter' width="100%">
                                <tr>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -24; $x <= 1; $x++) { $y = $x * 28 ?>
                                                <option value="<?php echo site_url('aorta/quota_employee_c/index/' . date("Ym", strtotime("+$y day")) . '/' . trim($dept) . '/' . trim($section)); ?>" <?php
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
                                                <option value="<? echo site_url('aorta/quota_employee_c/index/' . $period . '/' . trim($row->CHR_DEPT) . '/' . $section); ?>" <?php
                                                                                                                                                                                if (trim($dept) == trim($row->CHR_DEPT)) {
                                                                                                                                                                                    echo 'SELECTED';
                                                                                                                                                                                }
                                                                                                                                                                                ?>><?php echo trim($row->CHR_DEPT); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">
                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<? echo site_url('aorta/quota_employee_c/index/' . $period . '/' . trim($dept) . '/' . $row->KODE); ?>" <?php
                                                                                                                                                                        if (trim($section) == trim($row->KODE)) {
                                                                                                                                                                            echo 'SELECTED';
                                                                                                                                                                        }
                                                                                                                                                                        ?>><?php echo trim($row->KODE); ?></option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="60%">
                                    </td>
                            </table>
                        </div>
                        <div id="table-luar">
                            <table id="dataTables2" class="table table-condensed table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style='text-align:center;'>No</th>
                                        <th style="text-align:center;">No Quota Req.</th>
                                        <th style="text-align:center;">Upload Date</th>
                                        <th style="text-align:center;">Dept</th>
                                        <th style="text-align:center;">Total MP</th>
                                        <th style="text-align:center;">Status</th>
                                        <th style="text-align:center;">Quota Description</th>
                                        <th style="text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td style='text-align:center;'>$i</td>";

                                        $allow_del = false;
                                        if ($isi->SPV_APPROVE == 0 && $isi->KADEP_APPROVE == 0 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) {
                                            $color = '#E63F53';
                                        }
                                        if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 0 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) {
                                            $color = '#F5811E';
                                        }
                                        if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 1 && $isi->GM_APPROVE == 0 && $isi->DIR_APPROVE == 0) {
                                            $color = '#FFCA01';
                                        }
                                        if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 1 && $isi->GM_APPROVE == 1 && $isi->DIR_APPROVE == 0) {
                                            $color = '#7DD488';
                                        }
                                        if ($isi->SPV_APPROVE == 1 && $isi->KADEP_APPROVE == 1 && $isi->GM_APPROVE == 1 && $isi->DIR_APPROVE == 1) {
                                            $color = '#0C87F2';
                                        }

                                        echo "<td style='text-align:center;background:$color;color:#fff;'><strong>$isi->ID_DOC</strong></td>";
                                        echo "<td style='text-align:center;'>$isi->TGL_DOC</td>";
                                        echo "<td style='text-align:center;'>$isi->KD_DEPT</td>";
                                        echo "<td style='text-align:center;'>$isi->TOT_MP</td>";
                                        echo "<td style='text-align:center;font-style: italic;'>$isi->FLG_FINISH_APPROVE</td>";
                                        echo "<td style='white-space:pre-wrap ; word-wrap:break-word;'>$isi->ALASAN</td>";
                                    ?>
                                        <td style='text-align:center;'>
                                            <a onclick="get_data_detail(<?php echo $isi->ID_DOC; ?>,<?php echo $isi->STAT; ?>);" data-toggle="modal" data-target="#modalDetailQuotaReq<?php echo $isi->ID_DOC ?>" data-placement="left" data-toggle="tooltip" title="View Detail" class="label label-info"><span class="fa fa-search"></span></a>

                                            <?php if ($role == 1 || $role == 6 || $role == 13 || $role == 30 || $role == 32 || $role == 33 || $role == 18 || $role == 19 || $role == 20 || $role == 22 || $role == 23 || $role == 24 || $role == 26 || $role == 27 || $role == 40 || $role == 58 || $role == 67 || $role == 69 || $role == 103) { ?>
                                                <!-- <a disabled href="<?php echo base_url('index.php/aorta/quota_employee_c/edit_quota_employee') . "/" . $isi->ID_DOC . "/" . $period . "/" . $dept . "/" . $section ?>" class="label label-warning" data-placement="top" data-toggle="tooltip" title="Edit"><span class="fa fa-pencil"></span></a>-->
                                                <a href="<?php echo base_url('index.php/aorta/quota_employee_c/print_quota_employee') . "/" . $isi->ID_DOC . "/" . $period . "/" . $dept . "/" . $section ?>" class="label label-warning" data-placement="right" data-toggle="tooltip" title="Print"><span class="fa fa-print"></span></a>
                                                <?php if ($allow_del == true) { ?>
                                                    <a href="<?php echo base_url('index.php/aorta/quota_employee_c/delete_quota_employee') . "/" . $isi->ID_DOC . "/" . $period . "/" . $dept . "/" . $section ?>" class="label label-danger" data-placement="right" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure want to delete this quota request with code : ' + <?php echo $isi->ID_DOC ?>);"><span class="fa fa-times"></span></a>
                                            <?php }
                                            } ?>

                                        </td>
                                        </tr>
                                    <?php
                                        $i++;
                                    }
                                    ?>
                                </tbody>
                            </table>

                        </div>

                        <div style="width: 100%;padding-bottom:10px;">
                            <table width="100%" id='filterx' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>L e g e n d : </strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#E63F53;width:50px;height:10px;color:white;'></button> : Not Yet Approved
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#F5811E;width:50px;height:10px;color:white;'></button> : Approved By SPV
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#FFCA01;width:50px;height:10px;color:white;'></button> : Approved By MGR
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#7DD488;width:50px;height:10px;color:white;'></button> : Approved By GM
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#0C87F2;width:50px;height:10px;color:white;'></button> : Approved By DIR*
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <span style="font-size:9pt;">* jika kuota melebihi 40 jam perbulan</span>
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
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Detail Overtime QR No : <?php echo $isi->ID_DOC ?></strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <div id="table-luar" style='overflow: auto;white-space: nowrap;width:1000px;'>
                                                <table id="example" class="table table-condensed table-bordered table-striped table-hover display" cellspacing="0" width="100%">
                                                    <thead>
                                                        <tr>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">No</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">NPK</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Nama</th>
                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Section/Sub</th>

                                                            <!-- <th colspan="31" style="text-align:center;">Date</th> -->
                                                            <th colspan="5" style="text-align:center;">Production (H)</th>

                                                            <!-- <th colspan="31" style="text-align:center;">Date</th> -->
                                                            <th colspan="5" style="text-align:center;">Improvement (H)</th>

                                                            <th rowspan="2" style="vertical-align: middle;text-align:center;">Final Approval</th>
                                                            <!-- <th rowspan="2" style="vertical-align: middle;text-align:center;">Max Quota</th> -->

                                                        </tr>
                                                        <tr>
                                                            <!-- <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">1</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">2</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">3</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">4</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">5</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">6</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">7</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">8</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">9</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">10</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">11</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">12</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">13</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">14</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">15</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">16</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">17</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">18</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">19</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">20</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">21</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">22</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">23</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">24</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">25</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">26</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">27</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">28</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">29</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">30</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">31</td> -->

                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">Request</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">As-Is</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Used</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Saldo</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>To-Be</td>

                                                            <!-- <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">1</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">2</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">3</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">4</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">5</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">6</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">7</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">8</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">9</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">10</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">11</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">12</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">13</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">14</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">15</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">16</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">17</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">18</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">19</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">20</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">21</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">22</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">23</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">24</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">25</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">26</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">27</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">28</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">29</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">30</td>
                                                            <td style="white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4">31</td> -->

                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Request</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>As-Is</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Used</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>Saldo</td>
                                                            <td style='white-space:pre-wrap ; word-wrap:break-word;vertical-align: middle;text-align:center;background: #F4F4F4'>To-Be</td>
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



            </div>
        </div>

    </section>
</aside>

<script>
    function get_data_detail(qrno, stat) {
        $("#data_detail").html("");
        $.ajax({
            async: false,
            type: "POST",
            // dataType: 'json',
            url: "<?php echo site_url('aorta/quota_employee_c/view_detail_quota_employee_by_user'); ?>",
            data: {
                qrno: qrno,
                stat: stat
            },
            success: function(data) {
                $("#data_detail" + qrno).html(data);
            },
            error: function(request, error) {
                alert(request.responseText);
            }
        });

    }
</script>