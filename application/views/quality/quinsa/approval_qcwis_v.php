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

    $(function() {
        $("#datepicker5").datepicker({dateFormat: 'dd-mm-yy'}).val();
    });

    $(function() {
        $( ".datepicker" ).datepicker();
    });
    
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/'); ?>"><span>Home</span></a></li>
            <li><a href=""><strong>Approval QCWIS</strong></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-check-square-o"></i>
                        <span class="grid-title"><strong>APPROVAL QCWIS</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                        </div>   
                        <div class="pull-right grid-tools">                            
                            <!-- <?php echo form_open('quality/report_quinsa_c/approval_qcwis_by_date', 'class="form-horizontal"'); ?>
                                <input name="CHR_DATE" value="<?php echo $selected_date; ?>" type="hidden">
                                <input name="CHR_WORK_CENTER" value="<?php echo $wc; ?>" type="hidden">
                                <input name="CHR_PART_NO" value="<?php echo $partno; ?>" type="hidden">
                                <button type="submit" name="btn_submit" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-thumbs-up"></i> Approve</button>
                            <?php echo form_close() ?>   -->
                            <button type="submit" name="btn_submit" onclick="approve_qcwis()" class="btn btn-primary" data-placement="right"><i class="fa fa-thumbs-up"></i> Approve</button>                          
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php echo form_open('quality/report_quinsa_c/search_approval_qcwis', 'class="form-horizontal"'); ?>
                        <div class="pull">
                            <table width="50%" id='filter' border='0px'>
                                <tr>
                                    <td>Date</td>
                                    <td>
                                        <div class="input-group date form_time" data-date="2014-06-14T05:25:07Z" data-date-format="HH:ii" data-link-field="dtp_input4" style="width:170px;">
                                            <input type="text" name="date_from" class="form-control date-picker" id="datepicker5" name="date" value="<?php echo date("d-m-Y", strtotime($selected_date)) ?>" >
                                            <span class="input-group-addon"><i class="fa fa-th"></i></span>
                                        </div>
                                    </td>
                                    <td>Work Center</td>
                                    <td width="10%">
                                        <select id="e1" id="wcenter" name="wcenter" class="form-control" style="width:120px;" onchange="get_list_partno(value);">
                                            <?php foreach ($all_work_centers as $row) { ?>
                                                <option value="<? echo (trim($row->CHR_WORK_CENTER)); ?>" <?php
                                                    if (trim($wc) == trim($row->CHR_WORK_CENTER)) {
                                                            echo 'SELECTED';
                                                    }
                                                    ?>><?php echo trim($row->CHR_WORK_CENTER); ?>
                                                </option>
                                            <?php } ?>
                                        </select>
                                    </td>                                    
                                    <td>Part No</td>
                                    <td width="10%">
                                        <select id="e2" name="partno" class="form-control" style="width:200px;"> 
                                            <?php foreach ($allpartno as $row) { ?>
                                                <option value="<? echo (trim($row->CHR_PARTNO)); ?>" <?php
                                                    if ($partno == trim($row->CHR_PARTNO)) {
                                                        echo 'SELECTED';
                                                    }
                                                    ?>><?php echo trim($row->CHR_PARTNO); ?> - <?php echo trim($row->CHR_BACK_NO); ?>
                                                </option>
                                            <?php } ?>                                           
                                        </select>
                                    </td>                                    
                                    <td>
                                        <button type="submit" id="btn_filter" class="btn btn-info" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <?php echo form_close(); ?>
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
                        <?php if ($data_qcwis != null) { ?>
                            <iframe src="<?php echo site_url('quality/report_quinsa_c/get_chart_qcwis/' . $selected_date .  '/' . trim($wc) . '/' . $partno); ?>" height="500px" width="100%" style="border:none;"></iframe>
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
                                <button type="submit" name="btn_submit_2" value="1" class="btn btn-primary" data-placement="right"><i class="fa fa-download"></i> Export to Excel</button>
                            <?php echo form_close() ?>
                        </div>
                    </div>
                    <div class="grid-body">
                        <?php if ($data_all != NULL) { ?>
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
    </section>
</aside>
<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        document.body.style.zoom = 0.90;

        // var interval_close = setInterval(closeSideBar, 250);

        // function closeSideBar() {
        //     $("#hide-sub-menus").click();
        //     clearInterval(interval_close);
        // }
    });

    function get_list_partno(value) {
        var wc = value;
        var dt = document.getElementById('datepicker5').value;
        $.ajax({
            async: false,
            type: "POST",
            dataType: "json",
            url: "<?php echo site_url('quality/report_quinsa_c/get_partno_by_wc'); ?>",
            data: "wcenter=" + wc + "&date=" + dt,
            success: function(json_data) {
                // alert(json_data);
                $("#e2").html(json_data);
            }
        });
    }

    function approve_qcwis() {
        var wc_app = document.getElementById('wcenter').value;
        var dt_app = document.getElementById('datepicker5').value;
        var pn_app = document.getElementById('e2').value;

        $.ajax({
            async: false,
            type: "POST",
            dataType: 'json',
            url: "<?php echo site_url('quality/report_quinsa_c/approval_qcwis_by_date'); ?>",
            data: "wcenter_approve=" + wc_app + "&date_approve=" + dt_app + "&partno_approve=" + pn_app,
            success: function(json_data) {
                document.getElementById('btn_submit').click();
            },
            error: function(request) {
                alert(request.responseText);
            }
        });
        
    }
</script>