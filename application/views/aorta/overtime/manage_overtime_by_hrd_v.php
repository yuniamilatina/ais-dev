<script>
    $(document).ready(function () {
        var interval_close = setInterval(closeSideBar, 250);
        function closeSideBar() { 
            $("#hide-sub-menus").click();
            clearInterval(interval_close);
        }
    });
</script>
<style type="text/css">
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
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
    .td-no{
        width: 10px;
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
            <li><a href="<?php echo base_url('index.php/aorta/view_spkl_c') ?>"><strong>View Overtime</strong></a></li>
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
                        <span class="grid-title"><strong>EMPLOYEE OVERTIME</strong></span>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter'>
                                <tr>
                                    <td width="10%" style='text-align:left;' ><strong>Periode / Dept / Section</strong></td>
                                    <td width="10%">
                                        <select class="ddl" id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;">
                                            <?php for ($x = -4; $x <= 1; $x++) { $y = $x * 28 ?>
                                                <option value="<? echo site_url('aorta/view_spkl_c/index/' . date("Ym", strtotime("+$y day")) . '/' . trim($dept) . '/' . $section); ?>" <?php
                                                if ($period == date("Ym", strtotime("+$y day"))) {
                                                    echo 'SELECTED';
                                                }
                                                ?> > <?php echo date("M Y", strtotime("+$y day")); ?> </option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_dept as $row) { ?>
                                                <option value="<? echo site_url('aorta/view_spkl_c/index/' . $period . '/' . trim($row->CHR_DEPT) . '/' . trim($section)); ?>" <?php
                                                if ($dept == trim($row->CHR_DEPT)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->CHR_DEPT); ?></option>
                                                    <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%" style='text-align:left;' colspan="4">
                                        <select id="opt_wcenter" onChange="document.location.href = this.options[this.selectedIndex].value;" class="ddl">

                                            <?php foreach ($all_section as $row) { ?>
                                                <option value="<? echo site_url('aorta/view_spkl_c/index/' . $period . '/' . trim($dept) . '/' . $row->KODE); ?>" <?php
                                                if (trim($section) == trim($row->KODE)) {
                                                    echo 'SELECTED';
                                                }
                                                ?> ><?php echo trim($row->KODE); ?></option>
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
                            <table id="dataTables3" class="table table-condensed  table-striped table-hover display" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th style="vertical-align: middle;text-align:center;">No</th>
                                        <th style="vertical-align: middle;text-align:center;">No SPKL</th>
                                        <th style="vertical-align: middle;text-align:center;">OT Description</th>
                                        <th style="vertical-align: middle;text-align:center;">Total MP</th>
                                        <th style="vertical-align: middle;text-align:center;">Plan OT (H)</th>
                                        <th style="vertical-align: middle;text-align:center;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $i = 1;
                                    foreach ($data as $isi) {
                                        echo "<tr class='gradeX'>";
                                        echo "<td>$i</td>";

                                        if ($isi->CEK_GM == 0) {
                                            $color = 'background:#E63F53;color:#fff;';
                                        }
                                        if ($isi->CEK_KADEP == 1 && $isi->CEK_GM == 1) {
                                            $color = 'background:#7DD488;color:#fff;';
                                        }
                                        if ($isi->CEK_GM == 1 && $isi->FLG_DOWNLOAD == 1) {
                                            $color = 'background:#71AEF5;color:#fff;';
                                        }
                                        if ($isi->CEK_KADEP == '-' && $isi->CEK_GM == '-') {
                                            $color = '';
                                        }

                                        echo "<td style='$color'><strong>$isi->NO_SEQUENCE</strong></td>";
                                        if(strlen($isi->ALASAN) > 80){
                                            if($isi->REAL_MULAI_OV_TIME == 'NULL' || $isi->REAL_SELESAI_OV_TIME == 'NULL'){
                                                echo "<td style='color:#E63F53'>" . substr($isi->ALASAN, 0, 80) . " ...</td>";
                                            } else{
                                                echo "<td>" . substr($isi->ALASAN, 0, 80) . " ...</td>";
                                            }
                                        } else {
                                            if($isi->REAL_MULAI_OV_TIME == 'NULL' || $isi->REAL_SELESAI_OV_TIME == 'NULL'){
                                                echo "<td style='color:#E63F53'>" . $isi->ALASAN . "</td>";
                                            } else{
                                                echo "<td>" . $isi->ALASAN . "</td>";
                                            }
                                        }
                                        echo "<td align='center'><strong>$isi->TOT_MP</strong></td>";
                                        echo "<td align='center'><strong>" . number_format($isi->RENC_DURASI_OV_TIME,2,',','.') . "</strong></td>";
                                        
                                        ?>
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
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                                </tbody>
                            </table>

                        </div>

                        <div style="width: 60%;">
                            <table width="40%" id='filter' border=0px style="outline: thin ridge #DDDDDD">
                                <tr>
                                    <td width="3%" style='text-align:left;' colspan="4"><strong>Legend :</strong></td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#E63F53;width:25px;height:25px;color:white;'></button> : Not Yet Approved by GM
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#7DD488;width:25px;height:25px;color:white;' ></button> : Approved by GM
                                    </td>
                                    <td width="10%">
                                        <button disabled style='border:0;background:#71AEF5;width:25px;height:25px;color:white;' ></button> : Downloaded by HRD
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
                                        <div class="modal-header bg-primary">
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            <h4 class="modal-title" id="modalprogress"><strong>Detail Overtime No : <?php echo $isi->NO_SEQUENCE ?></strong></h4>
                                        </div>
                                        <div class="modal-body">
                                            <?php echo form_open('aorta/view_spkl_c/approve_form_overtime', 'class="form-horizontal"'); ?>

                                            <input name="NO_SEQUENCE" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $isi->NO_SEQUENCE ?>">
                                            <input name="CHR_DEPT" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $dept ?>">
                                            <input name="CHR_PERIOD" class="form-control" required type="hidden" style="width: 300px;" value="<?php echo $period ?>">

                                            <div id="table-luar">
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

<script src="<?php echo base_url('assets/js/jquery-1.12.3.js') ?>"></script>
<script src="<?php echo base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
<script src="<?php echo base_url('assets/js/dataTables.fixedColumns.min.js') ?>"></script>
<link rel="stylesheet" href="<?php echo base_url('assets/css/fixedColumns.dataTables.min.css'); ?>" >
<script>
                                            function get_data_detail(nospkl) {
                                                $("#data_detail").html("");
                                                $.ajax({
                                                    async: false,
                                                    type: "POST",
                                                    url: "<?php echo site_url('aorta/overtime_c/view_detail_overtime'); ?>",
                                                    data: "nospkl=" + nospkl,
                                                    success: function (data) {
                                                        $("#data_detail" + nospkl).html(data);
                                                    }
                                                });

                                            }

</script>