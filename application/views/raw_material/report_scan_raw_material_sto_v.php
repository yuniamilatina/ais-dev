<script type="text/javascript" src="<?php echo base_url('assets/script/canvasjs.min.js') ?>"></script>

<style type="text/css">
    #table-luar {
        font-size: 11px;
    }

    #td_date {
        text-align: center;
        vertical-align: top;
    }

    #filter {
        border-spacing: 10px;
        border-collapse: separate;
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

    .blue {
        background-color: #0ED09C;
    }
</style>
<script>
    // setTimeout(function() {
    //     document.getElementById("hide-sub-menus").click();
    // }, 250);
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Report QCWIS</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title">REPORT QCWIS</span>
                    </div>
                    <div class="grid-body">
                        <div class="pull">
                            <table width="100%" id='filter' border='0px'>
                                <tr>
                                    <td width="10%">
                                        <select id="tanggal" onChange="document.location.href = this.options[this.selectedIndex].value;" class="form-control" style="width:120px;">
                                            <?php for ($x = -5; $x <= 0; $x++) {
                                                $y = $x * 28 ?>
                                                <option value="<?php echo site_url('quality/report_quinsa_c/search_qcwis/' . date("Ym", strtotime("+$y day")) . '/' . trim($wc) . '/' . $partno . '/' . $item); ?>" <?php
                                                                                                                                                                                                                    if ($selected_date == date("Ym", strtotime("+$y day"))) {
                                                                                                                                                                                                                        echo 'SELECTED';
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                    ?>> <?php echo date("M Y", strtotime("+$y day")); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select id="e1" onChange="document.location.href = this.options[this.selectedIndex].value;" class="form-control" style="width:120px;">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<? echo site_url('quality/report_quinsa_c/search_qcwis/' . $selected_date . '/' . (trim($row->CHR_WORK_CENTER)) . '/' . $partno . '/' . $item); ?>" <?php
                                                                                                                                                                                                                    if (trim($wc) == trim($row->CHR_WORK_CENTER)) {
                                                                                                                                                                                                                        echo 'SELECTED';
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                    ?>><?php echo trim($row->CHR_WORK_CENTER); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="10%">
                                        <select id="e2" onChange="document.location.href = this.options[this.selectedIndex].value;" class="form-control" style="width:200px;">
                                            <option value="">-Silahkan Pilih-</option>
                                            <?php foreach ($allpartno as $row) { ?>
                                                <option value="<? echo site_url('quality/report_quinsa_c/search_qcwis/' . $selected_date . '/' . (trim($wc)) . '/' . (trim($row->CHR_PART_NO)) . '/' . $item); ?>" <?php
                                                                                                                                                                                                                    if ($partno == trim($row->CHR_PART_NO)) {
                                                                                                                                                                                                                        echo 'SELECTED';
                                                                                                                                                                                                                    }
                                                                                                                                                                                                                    ?>><?php echo trim($row->CHR_PART_NO); ?> - <?php echo trim($row->CHR_BACK_NO); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                    <td width="60%">
                                        <select id="params" onChange="document.location.href = this.options[this.selectedIndex].value;" class="form-control" style="width:400px;">
                                        <option value="">-Silahkan Pilih-</option>    
                                        <?php foreach ($all_item_cek as $row) { ?>
                                                <option value="<? echo site_url('quality/report_quinsa_c/search_qcwis/' . $selected_date . '/' . (trim($wc)) . '/' . $partno . '/' . $row->CHR_SEQ); ?>" <?php
                                                                                                                                                                                                            if ($item == $row->CHR_SEQ) {
                                                                                                                                                                                                                echo 'SELECTED';
                                                                                                                                                                                                            }
                                                                                                                                                                                                            ?>><?php echo $row->CHR_SEQ; ?>- <?php echo $row->CHR_CHECK_POINT; ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- </?php if ($data_range == false) { ?>
                            <table width=100% id='filterdiagram'>
                                <td> No data available in diagram</td>
                            </table>
                        </?php } else { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_range/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        </?php } ?> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title"><strong>Control Result</strong></span>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_max == true) { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_max/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        <?php } elseif ($data_min == true) { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_min/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        <?php } elseif ($data_ok == true) { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_ok/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        <?php } elseif ($data_yes == true) { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_yes/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        <?php } elseif ($data_range == true) { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_range/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        <?php } else { ?>
                            <table width=100% id='filterdiagram'>
                                <td>No data available in diagram</td>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title"><strong>Detail Result</strong></span>
                        <div class="pull-right grid-tools">
                            <?php echo form_open('quality/report_quinsa_c/export_detail_report_quinsa', 'class="form-horizontal"'); ?>
                                <input name="WORK_CENTER" value="<?php echo trim($wc); ?>" type="hidden">
                                <input name="PERIODE" value="<?php echo $selected_date; ?>" type="hidden">
                                <input name="PART_NO" value="<?php echo $partno; ?>" type="hidden">
                                <input name="ITEM_CHECK" value="<?php echo $item; ?>" type="hidden">
                                <button type="submit" name="btn_submit_2" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_all == true) { ?>
                            <table width="100%">
                                <thead>
                                    <tr style="text-align:left;">   
                                        <th width="10%">Part No</th>
                                        <th width="2%">:</th>
                                        <th width="10%"><?php echo $data_all[0]->CHR_PARTNO; ?></th>
                                        <th width="10%"></th>
                                        <th width="10%">Insp. Name</th>
                                        <th width="2%">:</th>
                                        <th width="10%"><?php echo $data_all[0]->CHR_SEQ . ' - ' . $data_all[0]->CHR_CHECK_POINT; ?></th>
                                        <th width="10%"></th>
                                        <th width="10%">Execute By</th>
                                        <th width="2%">:</th>
                                        <th width="10%"><?php echo $data_all[0]->CHR_EXEC_BY; ?></th>                                        
                                    </tr>
                                    <tr style="text-align:left;">   
                                        <th width="10%">Model Name</th>
                                        <th width="2%">:</th>
                                        <th width="10%"><?php echo $data_all[0]->CHR_MODEL_NM; ?></th>
                                        <th width="10%"></th>
                                        <th width="10%">Insp. Master Doc</th>
                                        <th width="2%">:</th>
                                        <th width="10%"><?php echo $data_all[0]->CHR_REF_MASTER; ?></th>
                                        <th width="10%"></th>
                                        <th width="10%">Insp. Area</th>
                                        <th width="2%">:</th>
                                        <th width="10%"><?php echo $data_all[0]->CHR_INSPEC_TYPE; ?></th>
                                    </tr>
                                    <tr style="text-align:left;">   
                                        <th width="10%">Part Name</th>
                                        <th width="2%">:</th>
                                        <th width="10%"><?php echo $data_all[0]->CHR_PART_NM; ?></th>
                                        <th width="10%"></th>
                                        <th width="10%">Sampling Method</th>
                                        <th width="2%">:</th>
                                        <th width="10%"><?php echo $data_all[0]->CHR_SAMPLING  . ' - ' . $data_all[0]->CHR_CONTROL; ?></th>
                                        <th width="10%"></th>
                                        <th width="10%">Insp. Type</th>
                                        <th width="2%">:</th>
                                        <th width="10%"><?php echo $data_all[0]->CHR_TYPE  . ' - ' . $data_all[0]->CHR_SPECIAL_CHAR; ?></th>
                                    </tr>
                                </thead>
                            </table>
                            &nbsp;
                            <table id="dataTables3" class="table table-condensed table-striped display">
                                <thead>
                                    <tr style="text-align:center;">
                                        <th rowspan="2">No</th>
                                        <th rowspan="2">Doc ID</th>
                                        <th rowspan="2">Prod Order</th>
                                        <th rowspan="2">First/Last</th>                                        
                                        <th rowspan="2">Date/Time</th>
                                        <th rowspan="2">User</th>
                                        <th rowspan="2">Repetition</th>
                                        <th colspan="3" style="text-align:center;">Spec Limit (SL)</th>
                                        <th colspan="3" style="text-align:center;">Control Limit (CL)</th>
                                        <th rowspan="2">Result</th>
                                        <th rowspan="2">Status</th>
                                    </tr>
                                    <tr style="text-align:center;">
                                        <th>Target</th>
                                        <th>LSL</th>
                                        <th>USL</th>
                                        <th>Target</th>
                                        <th>LCL</th>
                                        <th>UCL</th>
                                    </tr>
                                </thead>
                                    <?php
                                        $no = 1;
                                        foreach($data_all as $dt){
                                            echo '<tr style="text-align:center;">';
                                            echo '<td>' . $no . '</td>';
                                            echo '<td>' . $dt->CHR_DOC_ID . '</td>';
                                            echo '<td>' . $dt->CHR_LOT_NOMOR . '</td>';
                                            echo '<td>' . $dt->CHR_STRATEGY . '</td>';
                                            echo '<td>' . substr($dt->CHR_CREATE_DATE,6,2) . '/' . substr($dt->CHR_CREATE_DATE,4,2)  . '/' . substr($dt->CHR_CREATE_DATE,0,4) . ' ' . substr($dt->CHR_CREATED_TIME,0,2) . ':' . substr($dt->CHR_CREATED_TIME,2,2) . '</td>';
                                            echo '<td>' . $dt->CHR_CREATE_BY . '</td>';
                                            echo '<td>' . $dt->CHR_REPETITION . '</td>';
                                            echo '<td>' . $dt->CHR_TARGET_SL . '</td>';
                                            echo '<td>' . $dt->CHR_LSL . '</td>';
                                            echo '<td>' . $dt->CHR_USL . '</td>';
                                            echo '<td>' . $dt->CHR_TARGET_CL . '</td>';
                                            echo '<td>' . $dt->CHR_LCL . '</td>';
                                            echo '<td>' . $dt->CHR_UCL . '</td>';
                                            echo '<td><strong>' . $dt->CHR_RESULT . '</strong></td>';
                                            if(trim($dt->CHR_STATUS) == 'OK'){
                                                echo '<td><img src="' . base_url() . '/assets/img/check1.png' . '" width="18"></td>';
                                            } else if(trim($dt->CHR_STATUS) == 'NG'){
                                                echo '<td><img src="' . base_url() . '/assets/img/error1.png' . '" width="18"></td>';
                                            } else {
                                                echo '<td>-</td>';
                                            }                                            
                                            echo '</tr>';
                                            $no++;
                                        } 
                                    ?>
                                <tbody>
                                </tbody>
                        <?php } else { ?>
                            <table width=100% id='filterdiagram'>
                                <td>No data available in diagram</td>
                            </table>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title"><strong>MAX CHART</strong></span>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_max == false) { ?>
                            <table width=100% id='filterdiagram'>
                                <td>No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_max/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title"><strong>MIN CHART</strong></span>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_min == false) { ?>
                            <table width=100% id='filterdiagram'>
                                <td>No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_min/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title"><strong>OK/NG TABLE</strong></span>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_ok == false) { ?>
                            <table width=100% id='filterdiagram'>
                                <td>No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_ok/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <span class="grid-title"><strong>YES/NO TABLE</strong></span>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_yes == false) { ?>
                            <table width=100% id='filterdiagram'>
                                <td> No data available in diagram</td>
                            </table>
                        <?php } else { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_yes/' . $selected_date .  '/' . trim($wc) . '/' . $partno .  '/' . $item); ?>" height="410px" width="100%" style="border:none;"></iframe>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div> -->

    </section>
</aside>