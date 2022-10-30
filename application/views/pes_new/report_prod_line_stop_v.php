<script>
    $(document).ready(function () {
        var date = new Date();

        $("#datepicker1").datepicker({dateFormat: 'dd-mm-yy'}).val();

    });
</script>

<style type="text/css">

    #table-luar{
        font-size: 11px;
    }
    #td_date{
        text-align:center;
        vertical-align:top;
    } 

    #filter { 
        border-spacing: 10px;
        border-collapse: separate;
    }

    #filterdiagram {
        border-spacing: 5px;
        border-color: #DDDDDD;
        background-color: #F3F4F5;
        border : 1px;
    }

    #testDiv{
        width: 100%;
        white-space: nowrap; 
        overflow-x:scroll;
        overflow-y:visible;
        font-size: 12px;
    }
    th, td { white-space: nowrap; }
    div.dataTables_wrapper {
        width: 100%;
        margin: 0 auto;
    }
    .td-fixed{
        width: 30px;
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

<script>
    $(function () {
    $("#datepicker").datepicker({dateFormat: 'yy/mm/dd', maxDate: 'today'});
    $("#datepicker2").datepicker({dateFormat: 'yy/mm/dd', maxDate: 'today'});
    });</script>


<script>     
    var tableToExcel = (function () {
    var uri = 'data:application/vnd.ms-excel;base64,'
    , template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>'
                , base64 = function (s) {
    return window.btoa(unescape(encodeURIComponent(s)))
        }
    , format = function (s, c) {
    return s.replace(/{(\w+)}/g, function (m, p) {
        return c[p];
    })
    }
    return function (table, name) {
    if (!table.nodeType)
        table = document.getElementById(table)
    var ctx = {worksheet: name || 'Sheet1', table: table.innerHTML}
    window.location.href = uri + base64(format(template, ctx))
    }
    })()
</script>

<aside class="right-side">
    <section class="content-header">
        <ol class="breadcrumb">
            <li><a href="<?php echo base_url('index.php/basis/home_c/') ?>">Home</a></li>
            <li><a href="#"><span><strong>Report Production Line Stop</strong></span></a></li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <!-- BEGIN BASIC ELEMENTS -->
            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-align-left"></i>
                        <span class="grid-title"><strong>REPORT PRODUCTION LINE STOP</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <?php echo form_open('pes_new/report_prod_line_stop_c/search_prod_part', 'class="form-horizontal"'); ?>
                    <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%">Date</td>
                                    <td width="5%">
                                        <input name="CHR_DATE" id="datepicker1" class="form-control" autocomplete="off" required type="text" style="width:200px;" value="<?php echo $date; ?>">
                                    </td>
                                    <td width="5%">Shift</td>
                                    <td width="5%">
                                            <select name="CHR_SHIFT" class="form-control" style="width:100px;">
                                                <?php
                                                foreach ($all_shift as $row) {
                                                    if (trim($row->CHR_SHIFT) == trim($shift)) {
                                                        ?>
                                                        <option selected value="<? echo $shift; ?>"><?php echo trim($row->CHR_SHIFT); ?></option>
                                                    <?php } else { ?>
                                                        <option value="<? echo $row->CHR_SHIFT; ?>"><?php echo trim($row->CHR_SHIFT); ?></option>
                                                        <?php
                                                    }
                                                }
                                                ?>
                                            </select>
                                    </td>
                                    <td width="5%" style='text-align:left;'>
                                        <button type="submit" class="btn btn-primary" style="margin-top: 3px;margin-bottom: 2px;"><span class="fa fa-filter"></span>&nbsp;&nbsp;Filter</button>
                                    </td>
                                    <td width="75%"></td>
                                </tr>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="75%" style='text-align:right;'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel', 'Summary Line Stop')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                                </tr>
                            </table>
                            <?php form_close(); ?>
                        </div>
                        
                        <table id="dataTables1" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr> 
                                    <th style="text-align:center;" >Group</th>
                                    <th style="text-align:center;" >Work Center</th>
                                    <th style="text-align:center;" >Work Duration (m)</th>
                                    <th style="text-align:center;" >Line Stop Duration (m)</th>
                                    <th style="text-align:center;" >Effective</th>
                                    <th style="text-align:center;" >Percentage (%)</th>
                                    <th style='text-align:center;' >Target (%)</th>
                                    <th style="text-align:center;" >Judge</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data as $isi) {
                                    if($isi->PERCENTAGE == null){
                                        $percentage = 0;
                                    }else{
                                        $percentage = $isi->PERCENTAGE;
                                    }
                                    if($isi->JUDGE == 'O'){
                                        $color = 'bg bg-green';
                                    }else{
                                        $color = 'bg bg-red';
                                    }
                                    echo "<tr> ";
                                    echo "<td style='text-align:center;' >$isi->CHR_GROUP_PRODUCT</td>";
                                    echo "<td style='text-align:center;' >$isi->CHR_WORK_CENTER</td>";
                                    echo "<td style='text-align:center;' >$isi->TIMEWORK</td>";
                                    echo "<td style='text-align:center;' >$isi->TIME_LINESTOP</td>";
                                    echo "<td style='text-align:center;' >$isi->EFFECTIVE</td>";
                                    echo "<td style='text-align:center;' >$percentage</td>";
                                    echo "<td style='text-align:center;' >$isi->TARGETPERS</td>";
                                    echo "<td style='text-align:center;' class='$color'>$isi->JUDGE</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <table id="exportToExcel" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr> 
                                    <th style="text-align:center;" >Group</th>
                                    <th style="text-align:center;" >Work Center</th>
                                    <th style="text-align:center;" >Work Duration (m)</th>
                                    <th style="text-align:center;" >Line Stop Duration (m)</th>
                                    <th style="text-align:center;" >Effective</th>
                                    <th style="text-align:center;" >Percentage (%)</th>
                                    <th style="text-align:center;" >Target (%)</th>
                                    <th style="text-align:center;" >Judge</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data as $isi) {
                                    if($isi->PERCENTAGE == null){
                                        $percentage = 0;
                                    }else{
                                        $percentage = $isi->PERCENTAGE;
                                    }
                                    if($isi->JUDGE == 'O'){
                                        $color = 'bg bg-green';
                                    }else{
                                        $color = 'bg bg-red';
                                    }
                                    echo "<tr> ";
                                    echo "<td style='text-align:center;' >$isi->CHR_GROUP_PRODUCT</td>";
                                    echo "<td style='text-align:center;' >$isi->CHR_WORK_CENTER</td>";
                                    echo "<td style='text-align:center;' >$isi->TIMEWORK</td>";
                                    echo "<td style='text-align:center;' >$isi->TIME_LINESTOP</td>";
                                    echo "<td style='text-align:center;' >$isi->EFFECTIVE</td>";
                                    echo "<td style='text-align:center;' >$percentage</td>";
                                    echo "<td style='text-align:center;' >$isi->TARGETPERS</td>";
                                    echo "<td style='text-align:center;' class='$color'>$isi->JUDGE</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>


            <div class="col-md-12">
                <div class="grid">
                    <div class="grid-header">
                        <i class="fa fa-align-left"></i>
                        <span class="grid-title"><strong>REPORT PRODUCTION LINE STOP DETAIL</strong></span>
                        <div class="pull-right grid-tools">
                            <a data-widget="collapse" title="Collapse"><i class="fa fa-chevron-up"></i></a>
                            <a data-widget="reload" title="Reload"><i class="fa fa-refresh"></i></a>
                            <a data-widget="remove" title="Remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="grid-body">
                    <div class="pull">
                            <table width="100%" id='filter' border=0px>
                                <tr>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="5%"></td>
                                    <td width="25%" style='text-align:right;'>
                                        <input type="button" class="btn btn-primary" onclick="tableToExcel('exportToExcel2', 'Detail Line Stop')" value="Export to Excel" style="margin-bottom: 20px;">
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <table id="dataTables2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%">
                            <thead>
                                <tr> 
                                    <th style="text-align:center;" >Group</th>
                                    <th style="text-align:center;" >Line Stop</th>
                                    <th style="text-align:center;" >Work Center</th>
                                    <th style="text-align:center;" >Duration (m)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data_detail as $isi) {
                                    echo "<tr> ";
                                    echo "<td style='text-align:center;'>$isi->CHR_GROUP_PRODUCT</td>";
                                    echo "<td>$isi->CHR_LINE_STOP</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td style='text-align:center;'>$isi->TIME_LINE_STOP</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                        <table id="exportToExcel2" class="table table-striped table-condensed table-hover display" cellspacing="0" width="100%" style="display:none;">
                        <thead>
                                <tr> 
                                    <th style="text-align:center;" >Group</th>
                                    <th style="text-align:center;" >Line Stop</th>
                                    <th style="text-align:center;" >Work Center</th>
                                    <th style="text-align:center;" >Line Stop Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($data_detail as $isi) {
                                    echo "<tr> ";
                                    echo "<td style='text-align:center;'>$isi->CHR_GROUP_PRODUCT</td>";
                                    echo "<td>$isi->CHR_LINE_STOP</td>";
                                    echo "<td style='text-align:center;'>$isi->CHR_WORK_CENTER</td>";
                                    echo "<td style='text-align:center;'>$isi->TIME_LINE_STOP</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>

            <!-- <div class="col-md-12" >
                <div class="grid">
                    
                    <div class="grid-header">
                        <i class="fa fa-bar-chart-o"></i>
                        <span class="grid-title"><strong>Efficiency</strong></strong></span>
                    </div>
                    <div class="grid-body">
                        <iframe src="<?php //echo site_url('pes_new/report_prod_line_stop_c/get_efficiency_prod_per_group'); ?>" height="500px" width="100%" scrolling="auto" frameborder="0" allowtransparency="true"></iframe>
                    </div>
                </div>
            </div> -->

        </div>
    </section>
</aside>


